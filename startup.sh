#!/bin/bash
cd /home/site/wwwroot
php artisan config:cache
php artisan route:cache
php artisan view:cache
php -S 0.0.0.0:8080 index.php
