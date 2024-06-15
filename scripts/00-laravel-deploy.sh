#!/usr/bin/env bash

set -e

echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

# echo "Generating application key..."
# php artisan key:generate --show

# echo "Creating public/docs directory if it doesn't exist..."
# mkdir -p /var/www/html/public/docs

# echo "Creating symbolic link for Swagger UI assets..."
# ln -s /var/www/html/vendor/swagger-api/swagger-ui/dist/ /var/www/html/public/docs/asset

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

echo "Setting up Passport keys..."
php artisan passport:keys --force

# Check the storage directory contents
echo "Checking storage directory..."
ls -l /var/www/html/storage

# Verify Passport key existence in the expected directory
if [ -f /var/www/html/storage/oauth-private.key ] && [ -f /var/www/html/storage/oauth-public.key ]; then
    echo "Setting permissions for Passport keys..."
    chmod 600 /var/www/html/storage/oauth/*.key
    chown www-data:www-data /var/www/html/storage/oauth/*.key
else
    # If keys are not found, search the entire project for them
    echo "Passport keys are missing in expected directory. Searching the entire project..."
    find /var/www/html -name oauth-private.key -o -name oauth-public.key

    # Attempt to locate keys
    private_key=$(find /var/www/html -name oauth-private.key)
    public_key=$(find /var/www/html -name oauth-public.key)

    if [ -n "$private_key" ] && [ -n "$public_key" ]; then
        echo "Passport keys found. Moving them to the correct location..."
        mv "$private_key" /var/www/html/storage/oauth/
        mv "$public_key" /var/www/html/storage/oauth/

        echo "Setting permissions for Passport keys..."
        chmod 600 /var/www/html/storage/oauth/*.key
        chown www-data:www-data /var/www/html/storage/oauth/*.key
    else
        echo "Passport keys are missing or not readable. Deployment aborted."
        exit 1
    fi
fi

# Verify Passport key existence and permissions
echo "Checking Passport keys..."
ls -l /var/www/html/storage/oauth/

echo "Deployment completed successfully."
