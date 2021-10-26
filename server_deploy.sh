#!/bin/sh
set -e

echo "Deploying application ..."

# Enter maintenance mode
    # Update codebase
 (php artisan down --message 'The app is being (quickly!) updated. Please try again in a minute.') || true
    
    tar xf dist.tar.gz
    rm dist.tar.gz 

    # Install dependencies based on lock file
    composer install --no-interaction --prefer-dist --optimize-autoloader

    # Migrate database
    php artisan migrate

    php artisan up
    # Note: If you're using queue workers, this is the place to restart them.
    # ...

echo "Application deployed!"