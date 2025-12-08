# 🎓 Bimbel Farmasi - Platform Bimbingan Belajar Farmasi

[![CI/CD Pipeline](https://github.com/BImbelFarmasi-ppw06/BimbelFarmasi-ppw06/actions/workflows/ci.yml/badge.svg)](https://github.com/BImbelFarmasi-ppw06/BimbelFarmasi-ppw06/actions)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)

Platform bimbingan belajar online untuk persiapan UKOM D3 Farmasi, CPNS & P3K Farmasi, dan jasa joki tugas farmasi.

## 📋 Table of Contents

-   [Features](#-features)
-   [Tech Stack](#-tech-stack)
-   [Requirements](#-requirements)
-   [Installation](#-installation)
-   [Configuration](#-configuration)
-   [Database Setup](#-database-setup)
-   [Running Tests](#-running-tests)
-   [Deployment](#-deployment)
-   [Maintenance](#-maintenance)
-   [Troubleshooting](#-troubleshooting)

## ✨ Features

-   🔐 **Multi-Auth System** - User & Admin authentication with Google OAuth
-   📚 **Program Management** - CRUD for bimbel programs (UKOM, CPNS/P3K, Joki Tugas)
-   💳 **Payment Integration** - Midtrans payment gateway & manual bank transfer
-   📸 **Payment Verification** - Upload bukti pembayaran with admin approval workflow
-   🎯 **Try-Out System** - Quiz bank for exam preparation
-   ⭐ **Testimonials** - Student reviews and ratings
-   📊 **Admin Dashboard** - Statistics, payment management, student tracking
-   🔒 **Security** - Rate limiting, CSRF protection, enum-based validation
-   📱 **Responsive UI** - Tailwind CSS with modern design

## 🛠 Tech Stack

### Backend

-   **Framework**: Laravel 12.x (PHP 8.2+)
-   **Authentication**: Laravel Sanctum 4.2, Socialite (Google OAuth)
-   **API Documentation**: L5-Swagger 9.0 (OpenAPI 3.0)
-   **Payment**: Midtrans PHP SDK 2.6
-   **Database**: MySQL 8.0+

### Frontend

-   **Build Tool**: Vite 7.0
-   **UI Library**: React 18.3
-   **Styling**: Tailwind CSS 4.0
-   **Icons**: Heroicons

### DevOps & Testing

-   **Testing**: PHPUnit 11.5
-   **Code Style**: Laravel Pint
-   **CI/CD**: GitHub Actions
-   **Dependency Management**: Dependabot

## 📦 Requirements

### Server Requirements

-   PHP >= 8.2
-   Composer >= 2.0
-   Node.js >= 20.x
-   MySQL >= 8.0 or MariaDB >= 10.3
-   Redis (optional, recommended for caching)

### PHP Extensions

```
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- Tokenizer
- XML
```

## 🚀 Installation

### 1. Clone Repository

```bash
git clone https://github.com/BImbelFarmasi-ppw06/BimbelFarmasi-ppw06.git
cd BimbelFarmasi-ppw06
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Environment Variables

Edit `.env` file with your credentials:

```env
APP_NAME="Bimbel Farmasi"
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=bimbel_farmasi
DB_USERNAME=your_db_user
DB_PASSWORD=your_db_password

# Midtrans Configuration
MIDTRANS_SERVER_KEY=your-server-key
MIDTRANS_CLIENT_KEY=your-client-key
MIDTRANS_IS_PRODUCTION=false

# Google OAuth
GOOGLE_CLIENT_ID=your-google-client-id
GOOGLE_CLIENT_SECRET=your-google-client-secret
GOOGLE_REDIRECT_URI=${APP_URL}/login/google/callback

# Redis (optional)
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@bimbelfarmasi.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### 5. Database Setup

```bash
# Run migrations
php artisan migrate

# Seed database (optional)
php artisan db:seed

# Create storage symlink
php artisan storage:link
```

### 6. Build Frontend Assets

```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Start Development Server

```bash
php artisan serve
```

Visit: `http://localhost:8000`

## ⚙ Configuration

### Environment Variables Reference

| Variable                 | Description                    | Default          | Required                    |
| ------------------------ | ------------------------------ | ---------------- | --------------------------- |
| `APP_NAME`               | Application name               | Bimbel Farmasi   | Yes                         |
| `APP_ENV`                | Environment (local/production) | local            | Yes                         |
| `APP_DEBUG`              | Enable debug mode              | false            | Yes                         |
| `APP_URL`                | Application URL                | http://localhost | Yes                         |
| `DB_CONNECTION`          | Database driver                | mysql            | Yes                         |
| `DB_HOST`                | Database host                  | 127.0.0.1        | Yes                         |
| `DB_PORT`                | Database port                  | 3306             | Yes                         |
| `DB_DATABASE`            | Database name                  | bimbel_farmasi   | Yes                         |
| `DB_USERNAME`            | Database username              | root             | Yes                         |
| `DB_PASSWORD`            | Database password              | -                | Yes                         |
| `MIDTRANS_SERVER_KEY`    | Midtrans server key            | -                | Yes                         |
| `MIDTRANS_CLIENT_KEY`    | Midtrans client key            | -                | Yes                         |
| `MIDTRANS_IS_PRODUCTION` | Production mode                | false            | Yes                         |
| `GOOGLE_CLIENT_ID`       | Google OAuth client ID         | -                | Yes (if using Google login) |
| `GOOGLE_CLIENT_SECRET`   | Google OAuth secret            | -                | Yes (if using Google login) |
| `REDIS_HOST`             | Redis server host              | 127.0.0.1        | No                          |
| `REDIS_PORT`             | Redis server port              | 6379             | No                          |

## 🗄 Database Setup

### Migrations

```bash
# Run all pending migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset and re-run all migrations
php artisan migrate:fresh

# Check migration status
php artisan migrate:status
```

### Database Indexes

The application uses the following indexes for performance:

**Orders Table:**

-   `user_id` - Filter orders by user
-   `status` - Filter by order status
-   `created_at` - Sort by date
-   Composite: `(user_id, status)`, `(status, created_at)`

**Payments Table:**

-   `order_id` - Foreign key lookup
-   `status` - Filter by payment status
-   `created_at` - Sort by date
-   Composite: `(status, created_at)`

**Programs Table:**

-   `slug` - URL-based lookups
-   `is_active` - Filter active programs
-   Composite: `(is_active, type)`

## 🧪 Running Tests

```bash
# Run all tests
vendor/bin/phpunit

# Run with coverage
vendor/bin/phpunit --coverage-html coverage

# Run specific test suite
vendor/bin/phpunit --testsuite Feature

# Run specific test file
vendor/bin/phpunit tests/Feature/Auth/AuthenticationTest.php

# Run with detailed output
vendor/bin/phpunit --testdox
```

### Test Database Setup

Tests use SQLite in-memory database by default. To use MySQL:

1. Create testing database:

```sql
CREATE DATABASE bimbel_farmasi_testing;
```

2. Update `.env.testing`:

```env
DB_CONNECTION=mysql
DB_DATABASE=bimbel_farmasi_testing
```

## 📦 Deployment

### Production Deployment Checklist

-   [ ] Set `APP_ENV=production` and `APP_DEBUG=false`
-   [ ] Generate new `APP_KEY`
-   [ ] Configure production database
-   [ ] Set up Midtrans production keys
-   [ ] Configure mail server (SMTP)
-   [ ] Enable Redis for caching
-   [ ] Set up queue workers
-   [ ] Configure cron jobs
-   [ ] Set up SSL certificate
-   [ ] Configure backup strategy
-   [ ] Set up monitoring (Laravel Telescope in production)

### Zero-Downtime Deployment

```bash
#!/bin/bash
# deploy.sh

# Enable maintenance mode
php artisan down

# Pull latest changes
git pull origin main

# Install/update dependencies
composer install --no-dev --optimize-autoloader
npm ci
npm run build

# Run migrations
php artisan migrate --force

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Restart queue workers
php artisan queue:restart

# Disable maintenance mode
php artisan up

echo "Deployment completed successfully!"
```

### Queue Workers (Supervisor)

Create `/etc/supervisor/conf.d/bimbel-farmasi-worker.conf`:

```ini
[program:bimbel-farmasi-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/bimbel-farmasi/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/bimbel-farmasi/storage/logs/worker.log
stopwaitsecs=3600
```

Start supervisor:

```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start bimbel-farmasi-worker:*
```

### Cron Jobs

Add to crontab (`crontab -e`):

```cron
* * * * * cd /var/www/bimbel-farmasi && php artisan schedule:run >> /dev/null 2>&1
```

### Nginx Configuration

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name bimbelfarmasi.com www.bimbelfarmasi.com;
    root /var/www/bimbel-farmasi/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 🔧 Maintenance

### Database Backup

```bash
#!/bin/bash
# backup-db.sh

TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_DIR="/backups/database"
DB_NAME="bimbel_farmasi"

mkdir -p $BACKUP_DIR

mysqldump -u root -p$DB_PASSWORD $DB_NAME | gzip > $BACKUP_DIR/backup_$TIMESTAMP.sql.gz

# Keep only last 30 days
find $BACKUP_DIR -name "backup_*.sql.gz" -mtime +30 -delete

echo "Backup completed: backup_$TIMESTAMP.sql.gz"
```

### Cache Management

```bash
# Clear all caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Rebuild caches (production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Log Management

```bash
# View logs
tail -f storage/logs/laravel.log

# Clear old logs (keep last 7 days)
find storage/logs -name "*.log" -mtime +7 -delete
```

## 🐛 Troubleshooting

### Common Issues

**500 Internal Server Error**

```bash
# Check permissions
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache

# Clear caches
php artisan cache:clear
php artisan config:clear
```

**Storage Link Not Working**

```bash
# Remove old symlink
rm public/storage

# Recreate
php artisan storage:link
```

**Queue Not Processing**

```bash
# Restart queue workers
php artisan queue:restart

# Or restart supervisor
sudo supervisorctl restart bimbel-farmasi-worker:*
```

**Composer Install Fails**

```bash
# Clear composer cache
composer clear-cache

# Install with verbose output
composer install -vvv
```

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 👥 Contributors

-   **Development Team** - BImbelFarmasi-ppw06

## 📞 Support

For support, email support@bimbelfarmasi.com or create an issue in this repository.

---

Made with ❤️ for Indonesian Pharmacy Students

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
