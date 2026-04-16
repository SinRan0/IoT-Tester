#!/bin/bash
composer install --no-dev --optimize-autoloader
composer dump-autoload
php artisan optimize:clear
php artisan config:clear
php artisan route:clear

echo "Waiting for MySQL..."
until php artisan migrate --force; do
  echo "Retrying in 3 seconds..."
  sleep 3
done

php artisan db:seed --force

php artisan serve --host=0.0.0.0 --port=${PORT:-8080}