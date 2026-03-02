#!/bin/sh
set -e

mkdir -p /tmp/views /tmp/sessions || true
chmod -R 777 /tmp/views /tmp/sessions || true

php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear  || true
php artisan cache:clear || true

exec "$@"