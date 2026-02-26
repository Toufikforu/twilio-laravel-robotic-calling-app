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

# Copy app code
COPY . .

# Install dependencies (production)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# ✅ Ensure Laravel writable dirs exist and are writable (fixes many 500s on Render)
RUN mkdir -p \
      storage/logs \
      storage/framework/cache \
      storage/framework/sessions \
      storage/framework/views \
      bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R 775 storage bootstrap/cache

# ✅ Clear caches (avoid stale config/routes/views after env changes)
RUN php artisan config:clear || true \
 && php artisan route:clear || true \
 && php artisan view:clear || true \
 && php artisan cache:clear || true

# Optional: If you ever cached config/routes locally, this avoids weird deploy issues
RUN rm -f bootstrap/cache/config.php bootstrap/cache/routes-v7.php bootstrap/cache/routes.php 2>/dev/null || true

# Run as non-root user
USER www-data

EXPOSE 10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]