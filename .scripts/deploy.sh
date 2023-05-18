#!/usr/bin/env bash
set -e

echo "Deployment started"

# Enter maintenance mode
(php artisan down) || true

git pull origin main

# Install composer dependencies
composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache
php artisan clear-compiled

# Recreate cache
php artisan optimize

# Compile npm assets
npm ci --foreground-scripts
npm run build

# Run database migrations
#php artisan migrate --force

# Run database seeders
#php artisan db:seed --force

# Update caches
php artisan view:clear
php artisan config:clear
php artisan cache:clear
php artisan config:cache

# Exit maintenance mode
php artisan up

echo "Deployment finished!"
