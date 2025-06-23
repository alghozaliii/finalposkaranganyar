#!/bin/bash

# Set permissions
chmod -R 755 /home/site/wwwroot/storage
chmod -R 755 /home/site/wwwroot/bootstrap/cache

# Navigate to Laravel directory
cd /home/site/wwwroot

# Copy environment file if not exists
if [ ! -f .env ]; then
    cp .env.example .env
    php artisan key:generate --force
fi

# Cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start the application (if needed)
echo "Laravel application started"