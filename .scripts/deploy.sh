#!/bin/bash

set -e

echo "Deployment started ..."

# Turn ON Maintenance Mode or return true
# if already is in maintenance mode
#(php artisan down) || true

# Pull the latest version of the app
git checkout -f
git pull origin master

# Install composer dependencies
echo "Install composer dependencies"
composer2 install --optimize-autoloader --no-dev --no-interaction

# Clearing Cache
echo "Clearing Cache"
php artisan cache:clear
php artisan config:clear

# Recreate cache
#php artisan optimize

# Run database migrations
echo "Run database migrations"
php artisan migrate --force

# Run database seeders
#php artisan db:seed --force

# use node
# echo "use node 20.9.0"
# nvm use 20.9.0

# Install NPM dependencies
echo "Install NPM dependencies"
npm run install

# package build
echo "Build NPM dependencies"
npm run build

# Turn OFF Maintenance mode
#php artisan up

echo "Deployment finished!"
