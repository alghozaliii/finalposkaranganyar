#!/bin/bash

echo "Starting Laravel application setup..."

# Navigate to app directory
cd /home/site/wwwroot

# Remove default Azure files
rm -f hostingstart.html
rm -f default.html

# Set proper permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache
chown -R www-data:www-data storage
chown -R www-data:www-data bootstrap/cache

# Copy environment file if it doesn't exist
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example"
    cp .env.example .env
fi

# Generate application key if not set
if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
    echo "Generating application key..."
    php artisan key:generate --force
fi

# Clear any existing cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan key:generate --force

# Cache configuration for production
echo "Caching configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Create storage symlink if it doesn't exist
if [ ! -L public/storage ]; then
    php artisan storage:link
fi

echo "Laravel setup completed successfully"

# Start PHP-FPM
exec php-fpm