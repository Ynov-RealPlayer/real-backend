#!/bin/bash
set -e

echo "🚩 Deployment started ... 🚩"

export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
nvm install --lts
node -v
npm -v
# Enter maintenance mode or return true
# if already is in maintenance mode
(php artisan down) || true

git stash

# Pull the latest version of the app
git pull origin master

<<<<<<< HEAD
# Install composer dependencies
composer install --ignore-platform-reqs
=======
# Install composer dependencies !
composer install
>>>>>>> 10074389150718bfbf1b6df5c898af50e4fcbe01

# Clear the old cache
php artisan clear-compiled

# Recreate cache
php artisan optimize

# Compile npm assets
npm install
npm run build

# Run database migrations
php artisan migrate --force

# Exit maintenance mode
php artisan up

echo "⭐ Deployment done ! ⭐"