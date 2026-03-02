#!/bin/sh
set -e

# Fix permissions at runtime (important on Render)
chmod -R 775 /app/storage /app/bootstrap/cache || true

# Clear caches (safe)
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear  || true
php artisan cache:clear || true

# If you are using DB sessions or need schema, run migrations:
php artisan migrate --force || true

exec "$@"