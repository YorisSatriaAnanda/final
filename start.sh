#!/bin/bash

# Jalankan migrasi dan cache Laravel
php artisan migrate --force
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan PHP-FPM di background
php-fpm -y /assets/php-fpm.conf &

# Jalankan Nginx di foreground
exec nginx -c /etc/nginx/nginx.conf
