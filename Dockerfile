FROM php:8.3-fpm-bookworm

# --- System deps + PHP extensions ---
RUN apt-get update && apt-get install -y --no-install-recommends \
    git unzip zip curl \
    nginx supervisor \
    libzip-dev \
    libicu-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) \
    pdo pdo_pgsql \
    mbstring \
    intl \
    zip \
    gd \
    bcmath \
    opcache \
 && rm -rf /var/lib/apt/lists/*

# --- Composer ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for caching
COPY composer.json composer.lock ./

# Sanity check: ensure required extensions exist before composer
RUN php -m | egrep -i "bcmath|pdo_pgsql" \
 && composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy application source
COPY . .

# Permissions for Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Nginx + Supervisor configs
COPY docker/nginx.conf /etc/nginx/nginx.conf
COPY docker/site.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

EXPOSE 8080
ENV PORT=8080

CMD ["/usr/bin/supervisord", "-n"]