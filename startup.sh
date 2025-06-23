#!/bin/bash

cd /home/site/wwwroot

# Bersihkan dan cache ulang konfigurasi Laravel
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan Laravel dari folder public
php -S 0.0.0.0:8080 -t public
