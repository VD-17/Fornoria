#!/bin/bash
set -e

cd /var/www/html

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

# Run database migrations
php artisan migrate --force

# Cache configuration for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# Ensure storage directories exist and are writable
php artisan storage:link --force 2>/dev/null || true

# Start Apache in the foreground
exec apache2-foreground
