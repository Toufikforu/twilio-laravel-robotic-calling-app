# Laravel on Render (Docker) - PHP 8.3 + PostgreSQL
FROM php:8.3-cli-bookworm

# Install OS packages needed to compile PHP extensions + common runtime tools
RUN set -eux; \
  apt-get update; \
  apt-get install -y --no-install-recommends \
    git unzip zip curl ca-certificates \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    libonig-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
  ; \
  # Configure + install PHP extensions commonly required by Laravel packages
  docker-php-ext-configure gd --with-freetype --with-jpeg; \
  docker-php-ext-install -j"$(nproc)" \
    bcmath \
    exif \
    gd \
    intl \
    mbstring \
    opcache \
    pcntl \
    pdo \
    pdo_pgsql \
    zip \
  ; \
  rm -rf /var/lib/apt/lists/*

# Copy Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy composer files first (better caching)
COPY composer.json composer.lock ./

# Show PHP + extensions and run composer with verbose logs (helps Render logs)
RUN php -v \
 && php -m | sort \
 && composer install -vvv --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy the rest of the app
COPY . .

# Laravel writeable dirs
RUN chmod -R ug+rwx storage bootstrap/cache || true

# Render web services expect your app to bind to a port
EXPOSE 10000

# Start Laravel (simple mode)
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]