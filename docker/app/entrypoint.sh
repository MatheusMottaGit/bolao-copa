#!/bin/bash
set -e

mkdir -p storage/framework/{cache/data,sessions,testing,views} storage/logs storage/app/public
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

until php -r "new PDO('mysql:host=${DB_HOST};port=${DB_PORT:-3306};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
    echo "Aguardando o banco de dados..."
    sleep 2
done

php artisan migrate --force

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
