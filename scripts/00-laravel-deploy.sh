#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

# echo "generating application key..."
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

# Ensure correct permissions
echo "Setting permissions for Passport keys..."
chmod 600 /var/www/html/storage/oauth-private.key
chmod 600 /var/www/html/storage/oauth-public.key
chown www-data:www-data /var/www/html/storage/oauth-private.key
chown www-data:www-data /var/www/html/storage/oauth-public.key

# Verify Passport key existence and permissions
echo "Checking Passport keys..."
ls -l /var/www/html/storage/oauth-private.key
ls -l /var/www/html/storage/oauth-public.key

# Optional: Exit with error if keys are missing
if [ ! -f /var/www/html/storage/oauth-private.key ] || [ ! -f /var/www/html/storage/oauth-public.key ]; then
    echo "Passport keys are missing or not readable. Deployment aborted."
    exit 1
fi

# Print the last 100 lines of the Laravel log
echo "Printing Laravel log..."
tail -n 100 /var/www/html/storage/logs/laravel.log


echo "Deployment completed successfully."
