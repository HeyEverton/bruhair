#!/bin/bash

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"                   # This loads nvm
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion" # This loads nvm bash_completion
export NVM_INC="$HOME/.nvm/versions/node/v18.19.1/include/node"

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
echo "use node 18.19.1"
nvm use 18.19.1

# Install NPM dependencies
echo "Install NPM dependencies"
npm install

# package build
echo "Build NPM dependencies"
npm run build

# Turn OFF Maintenance mode
#php artisan up

echo "Deployment finished!"
