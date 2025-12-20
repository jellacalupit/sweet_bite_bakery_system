#!/bin/bash
set -e

# Use Render's PORT environment variable, default to 8080
PORT=${PORT:-8080}

echo "Starting Laravel application initialization..."

# Ensure storage directories exist and have correct permissions
mkdir -p storage/framework/{cache,data,sessions,views} \
         storage/app/public \
         storage/logs \
         bootstrap/cache
chmod -R 775 storage bootstrap/cache || true

# Check if APP_KEY is set in environment
if [ -z "$APP_KEY" ]; then
    echo "ERROR: APP_KEY is not set! Please set APP_KEY in Render environment variables."
    exit 1
else
    echo "APP_KEY is set."
fi

# Clear existing caches
php artisan config:clear || true
php artisan cache:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Cache config/routes/views for production
php artisan config:cache || echo "Warning: Failed to cache config"
php artisan route:cache || echo "Warning: Failed to cache routes"
php artisan view:cache || echo "Warning: Failed to cache views"

# Optional: run database migrations
# php artisan migrate --force || echo "Warning: Database migration failed"

echo "Environment: ${APP_ENV:-production}"
echo "Debug mode: ${APP_DEBUG:-false}"
echo "Starting Laravel server on port: $PORT"

# Start Laravel server
exec php artisan serve --host=0.0.0.0 --port=$PORT
