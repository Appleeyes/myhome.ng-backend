#!/usr/bin/env bash

echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "Publishing Swagger assets..."
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

echo "Creating directory for Swagger assets..."
mkdir -p /var/www/html/public/vendor/l5-swagger

echo "Copying Swagger assets..."
cp -r /var/www/html/vendor/darkaonline/l5-swagger/public/* /var/www/html/public/vendor/l5-swagger/

echo "Listing contents of /var/www/html/public"
ls -l /var/www/html/public

echo "Listing contents of /var/www/html/public/vendor/l5-swagger"
ls -l /var/www/html/public/vendor/l5-swagger

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Clearing view cache..."
php artisan view:clear

echo "Clearing application cache..."
php artisan cache:clear

echo "Running migrations..."
php artisan migrate --force
