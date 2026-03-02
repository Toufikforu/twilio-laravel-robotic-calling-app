#!/bin/sh
set -e

# Fix perms as root, then run as www-data
if [ "$(id -u)" -eq 0 ]; then
  echo "Fixing permissions..."
  mkdir -p /app/storage/framework/views /app/storage/logs /app/bootstrap/cache || true
  chown -R www-data:www-data /app/storage /app/bootstrap/cache || true
  chmod -R 775 /app/storage /app/bootstrap/cache || true

  echo "Clearing caches..."
  su -s /bin/sh www-data -c "php artisan config:clear || true"
  su -s /bin/sh www-data -c "php artisan route:clear || true"
  su -s /bin/sh www-data -c "php artisan view:clear  || true"
  su -s /bin/sh www-data -c "php artisan cache:clear || true"

  echo "Starting app..."
  exec su -s /bin/sh www-data -c "$*"
fi

exec "$@"