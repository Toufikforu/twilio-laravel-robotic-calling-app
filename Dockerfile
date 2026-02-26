FROM php:8.3-cli-bookworm

RUN set -eux; \
  apt-get update; \
  apt-get install -y --no-install-recommends \
    git unzip zip curl ca-certificates \
    libzip-dev libicu-dev \
  ; \
  docker-php-ext-install -j"$(nproc)" \
    pdo pdo_pgsql bcmath intl zip \
  ; \
  rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

COPY . .

EXPOSE 10000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]