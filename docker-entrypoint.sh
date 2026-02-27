# #!/bin/sh

# # Exit if any command fails
# set -e

# # Generate application key if not set
# if [ -z "$APP_KEY" ]; then
#     php artisan key:generate
# fi

# # Cache configurations
# php artisan config:cache
# php artisan route:cache
# php artisan view:cache

# # Run migrations (be careful with this in production)
# # php artisan migrate --force

# # Start PHP-FPM
# # exec "$@"
# exec apache2-foreground




#!/bin/sh

# Exit if any command fails
set -e

# Generate application key if not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate
fi

# Create storage link if it doesn't exist
echo "🔗 Creating storage link..."
php artisan storage:link || true

# Fix storage permissions
echo "🔧 Fixing storage permissions..."
chmod -R 755 storage
chmod -R 755 public/storage
chmod -R 644 storage/app/public/products/* 2>/dev/null || true
chmod -R 644 public/storage/products/* 2>/dev/null || true

# Cache configurations
echo "🚀 Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Run migrations (be careful with this in production)
# php artisan migrate --force

echo "✅ Setup complete! Starting Apache..."

# Start Apache
exec apache2-foreground