#!/bin/bash

# ================================================================
# Bimbel Farmasi - Production Deployment Script
# ================================================================
# Script ini untuk deploy aplikasi ke production server
# Jalankan: bash deploy.sh
# ================================================================

echo "🚀 Starting Bimbel Farmasi Production Deployment..."
echo ""

# 1. Pull latest code
echo "📥 Pulling latest code from repository..."
git pull origin main

# 2. Install/Update Composer dependencies
echo "📦 Installing Composer dependencies..."
composer install --optimize-autoloader --no-dev

# 3. Install/Update NPM dependencies and build assets
echo "🎨 Building frontend assets..."
npm install
npm run build

# 4. Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan event:clear

# 5. Run database migrations
echo "💾 Running database migrations..."
php artisan migrate --force

# 6. Storage link (if not exists)
echo "🔗 Creating storage symlink..."
php artisan storage:link

# 7. Optimize application
echo "⚡ Optimizing application..."
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
php artisan optimize

# 8. Set proper permissions
echo "🔒 Setting file permissions..."
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# 9. Restart services
echo "🔄 Restarting services..."
# Uncomment sesuai web server yang digunakan
# sudo systemctl restart php8.2-fpm
# sudo systemctl restart nginx
# sudo systemctl restart apache2

echo ""
echo "✅ Deployment completed successfully!"
echo "🌐 Website: https://bimbelfarmasi.com"
echo ""
echo "⚠️  Jangan lupa:"
echo "   - Update .env dengan credentials production"
echo "   - Setup SSL certificate (Let's Encrypt)"
echo "   - Configure backup automation"
echo "   - Enable firewall rules"
echo ""
