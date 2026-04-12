#!/bin/bash

echo "Waiting for MySQL..."
until php artisan migrate --force 2>/dev/null; do
  echo "Retrying in 3 seconds..."
  sleep 3
done

php artisan db:seed --force

php artisan serve --host=0.0.0.0 --port=${PORT:-8000}