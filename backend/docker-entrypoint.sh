#!/bin/bash
set -e

# Use Render's PORT environment variable, default to 8080
PORT=${PORT:-8080}

echo "Starting Laravel application initialization..."

# Ensure storage directories exist and have correct permissions
echo "Setting up storage directories..."
mkdir -p storage/framework/{cache,data,sessions,views} \
    storage/app/public \
    storage/logs \
    bootstrap/cache

chmod -R 775 storage bootstrap/cache || true

# Copy .env.example to .env if .env does not exist
if [ ! -f .env ]; then
    echo ".env not found, copying .env.example..."
    cp .env.example .env
fi

# Generate APP_KEY if missing or empty
APP_KEY=$(php -r "require 'vendor/autoload.php'; echo env('APP_KEY');")
if [ -z "$APP_KEY" ] || [ "$APP_KEY" == "null" ]; then
    echo "APP_KEY is missing, generating..."
    php artisan key:generate --force
else
    echo "APP_KEY is already set."
fi

# Clear caches
echo "Clearing existing caches..."
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Cache config/routes/views for production
echo "Caching config, routes, and views..."
php artisan config:cache || echo "Warning: Failed to cache config"
php artisan route:cache || echo "Warning: Failed to cache routes"
php artisan view:cache || echo "Warning: Failed to cache views"

# Run optional database migrations (commented if not needed)
# php artisan migrate --force || echo "Warning: Database migration failed"

# Display environment info
echo "Environment: ${APP_ENV:-production}"
echo "Debug mode: ${APP_DEBUG:-false}"
echo "Starting server on port: $PORT"

# Start Laravel server on the Render port
exec php artisan serve --host=0.0.0.0 --port=$PORT
