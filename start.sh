#!/bin/bash

echo "🚀 Starting Laravel App..."

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Clear cache
echo "🧹 Clearing cache..."
php artisan optimize:clear

# Cache config (optional tapi bagus di production)
php artisan config:cache
php artisan route:cache

# Run migration (safe mode)
echo "🗄️ Running migrations..."
php artisan migrate:fresh --force

echo "✅ Setup completed"

# Start server
echo "🌐 Starting server..."
php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
