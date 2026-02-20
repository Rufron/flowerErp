#!/bin/sh

# Exit if any command fails
set -e

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate
fi

# Cache configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (be careful with this in production)
# php artisan migrate --force

# Start PHP-FPM
# exec "$@"
exec apache2-foreground