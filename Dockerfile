FROM php:8.2-cli

# System deps needed by common Laravel packages
RUN apt-get update && apt-get install -y \
    git unzip curl \
    libpq-dev \
    libzip-dev zip \
    libicu-dev \
    libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo pdo_pgsql zip intl gd pcntl \
  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy only composer files first (better caching)
COPY composer.json composer.lock* ./

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy the rest of the app
COPY . .

EXPOSE 10000
CMD php artisan serve --host=0.0.0.0 --port=10000