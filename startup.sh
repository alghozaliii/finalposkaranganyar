#!/bin/bash

echo "Running Laravel startup script"

# Set permission
chmod -R 755 /home/site/wwwroot/storage
chmod -R 755 /home/site/wwwroot/bootstrap/cache

# Start php built-in server
php -S 0.0.0.0:8080 -t public
