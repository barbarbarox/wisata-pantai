#!/usr/bin/env bash
set -euo pipefail

cd /var/www/html
chown root:root /var/www/html
chmod 0755 /var/www/html

# Refresh built public assets into the shared public volume
mkdir -p /var/www/html/public
cp -a /opt/app-public/. /var/www/html/public/

# Ensure runtime directories and log file exist with proper permissions
mkdir -p \
    storage/app/public/media \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs \
    bootstrap/cache

touch storage/logs/laravel.log
ln -sfn /var/www/html/storage/app/public /var/www/html/public/storage

chown -R www-data:www-data storage bootstrap/cache
chmod -R ug+rwx storage bootstrap/cache

exec "$@"
