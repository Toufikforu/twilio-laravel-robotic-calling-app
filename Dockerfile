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
COPY . .

RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Create writable dirs (still do this at build time)
RUN mkdir -p \
      storage/logs \
      storage/framework/cache \
      storage/framework/sessions \
      storage/framework/views \
      bootstrap/cache

# Copy an entrypoint that fixes perms at runtime + runs migrations
COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

USER www-data

# Render provides $PORT at runtime; EXPOSE is informational only
EXPOSE 10000

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=${PORT:-10000}"]