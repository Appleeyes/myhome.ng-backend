#!/usr/bin/env bash

echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

# echo "Generating application key..."
# php artisan key:generate --show

echo "Creating public/docs/asset directory if it doesn't exist..."
mkdir -p /var/www/html/public/docs/asset

# echo "Verify file presence"
# ls -l /var/www/html/public/docs/

# echo "Creating symbolic link for Swagger UI assets..."
# ln -s /var/www/html/vendor/swagger-api/swagger-ui/dist/ /var/www/html/public/docs/asset

echo "Copying Swagger UI assets..."
cp -r /var/www/html/vendor/swagger-api/swagger-ui/dist/* /var/www/html/public/docs/asset/

# echo "Verify files presence"
# ls -l /var/www/html/public/docs/asset/

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Clearing view cache..."
php artisan view:clear

echo "Clearing application cache..."
php artisan cache:clear

echo "Testing database connection..."
php artisan db:test-connection

echo "Running migrations..."
php artisan migrate --force

# echo "Installing Laravel Passport"
# php artisan passport:install --force
