#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "Publishing Swagger UI assets..."
php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"

echo "Generating Swagger documentation..."
php artisan l5-swagger:generate

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
