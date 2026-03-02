# ---------- Node build stage ----------
FROM node:20-bookworm AS nodebuild
WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY . .
RUN npm run build


# ---------- PHP runtime stage ----------
FROM php:8.3-cli-bookworm

RUN set -eux; \
  apt-get update; \
  apt-get install -y --no-install-recommends \
    git unzip zip curl ca-certificates \
    libzip-dev libicu-dev libpq-dev pkg-config \
  ; \
  docker-php-ext-install -j"$(nproc)" \
    pdo pdo_pgsql bcmath intl zip \
  ; \
  rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy app source
COPY . .

# Install PHP dependencies (production)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy built Vite assets (includes public/build/manifest.json)
COPY --from=nodebuild /app/public/build /app/public/build

# Ensure Laravel writable dirs exist
RUN mkdir -p \
    /app/storage/logs \
    /app/storage/framework/cache \
    /app/storage/framework/sessions \
    /app/storage/framework/views \
    /app/bootstrap/cache

# Set ownership & permissions at build time (runtime will also re-apply)
RUN chown -R www-data:www-data /app/storage /app/bootstrap/cache \
 && chmod -R 775 /app/storage /app/bootstrap/cache

# Entrypoint (runs as root, fixes perms, then drops to www-data)
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 10000

ENTRYPOINT ["/entrypoint.sh"]
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=${PORT:-10000}"]