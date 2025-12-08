# ================================================================
# Bimbel Farmasi - Production Deployment Checklist
# ================================================================

## 📋 Pre-Deployment Checklist

### 1. Environment Configuration
- [ ] Copy `.env.example` to `.env`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Update `APP_URL` to production domain
- [ ] Generate new `APP_KEY`: `php artisan key:generate`
- [ ] Set `APP_LOCALE=id` dan `APP_FALLBACK_LOCALE=id`

### 2. Database Configuration
- [ ] Update database credentials (host, name, user, password)
- [ ] Test database connection
- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed initial data: `php artisan db:seed --force`
- [ ] Verify admin account exists

### 3. Email Configuration
- [ ] Configure SMTP settings (Gmail, Mailgun, atau SendGrid)
- [ ] Update `MAIL_FROM_ADDRESS` dan `MAIL_FROM_NAME`
- [ ] Test email sending: `php artisan tinker` → `Mail::raw('Test', fn($msg) => $msg->to('your@email.com')->subject('Test'))`

### 4. Payment Gateway (Midtrans)
- [ ] Set `MIDTRANS_PRODUCTION=true`
- [ ] Update `MIDTRANS_SERVER_KEY` dengan production key
- [ ] Update `MIDTRANS_CLIENT_KEY` dengan production key
- [ ] Test payment flow di staging

### 5. Google APIs
- [ ] Generate Google Maps API Key dan tambahkan domain restriction
- [ ] Setup Google OAuth credentials dengan redirect URI production
- [ ] Create public Google Calendar dan ambil Calendar ID
- [ ] Generate Google Calendar API Key
- [ ] Setup Google Drive folder (optional)
- [ ] Create Google Analytics property dan ambil Measurement ID

### 6. Security
- [ ] Install SSL certificate (Let's Encrypt recommended)
- [ ] Force HTTPS di web server config
- [ ] Enable firewall (UFW/firewalld)
- [ ] Disable directory listing
- [ ] Set proper file permissions (755 directories, 644 files)
- [ ] Restrict `.env` access: `chmod 600 .env`

### 7. Performance Optimization
- [ ] Enable OPcache di php.ini
- [ ] Configure Redis/Memcached (optional)
- [ ] Run `php artisan optimize`
- [ ] Run `npm run build`
- [ ] Enable Gzip compression di web server
- [ ] Setup CDN untuk static assets (optional)

### 8. Monitoring & Backup
- [ ] Setup automated database backup (daily)
- [ ] Setup file backup (storage folder)
- [ ] Configure log rotation
- [ ] Setup uptime monitoring (UptimeRobot/Pingdom)
- [ ] Setup error tracking (Sentry/Bugsnag - optional)

### 9. Web Server Configuration
- [ ] Configure Nginx/Apache virtual host
- [ ] Set document root ke `/public`
- [ ] Configure PHP-FPM
- [ ] Setup cron jobs untuk queue/scheduler
- [ ] Test server response

### 10. Testing
- [ ] Test registration flow
- [ ] Test login (email & Google OAuth)
- [ ] Test order creation
- [ ] Test payment upload
- [ ] Test admin panel access
- [ ] Test all public pages
- [ ] Test mobile responsiveness
- [ ] Check SEO meta tags
- [ ] Validate sitemap.xml
- [ ] Check robots.txt

---

## 🚀 Deployment Steps

### Step 1: Server Preparation
```bash
# Update system
sudo apt update && sudo apt upgrade -y

# Install required packages
sudo apt install nginx php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl php8.2-zip php8.2-gd composer nodejs npm git -y
```

### Step 2: Clone Repository
```bash
cd /var/www
git clone https://github.com/BImbelFarmasi-ppw06/BimbelFarmasi-ppw06.git bimbelfarmasi
cd bimbelfarmasi
```

### Step 3: Install Dependencies
```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### Step 4: Configure Environment
```bash
cp .env.example .env
nano .env  # Edit configuration
php artisan key:generate
```

### Step 5: Setup Database
```bash
php artisan migrate --force
php artisan db:seed --force
php artisan storage:link
```

### Step 6: Set Permissions
```bash
sudo chown -R www-data:www-data /var/www/bimbelfarmasi
sudo chmod -R 755 /var/www/bimbelfarmasi/storage
sudo chmod -R 755 /var/www/bimbelfarmasi/bootstrap/cache
chmod 600 .env
```

### Step 7: Optimize Application
```bash
php artisan optimize
```

### Step 8: Configure Nginx
```nginx
server {
    listen 80;
    server_name bimbelfarmasi.com www.bimbelfarmasi.com;
    root /var/www/bimbelfarmasi/public;

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
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### Step 9: SSL Certificate
```bash
sudo apt install certbot python3-certbot-nginx
sudo certbot --nginx -d bimbelfarmasi.com -d www.bimbelfarmasi.com
```

### Step 10: Setup Cron Jobs
```bash
crontab -e
# Add this line:
* * * * * cd /var/www/bimbelfarmasi && php artisan schedule:run >> /dev/null 2>&1
```

---

## 🔧 Post-Deployment

### Monitor Logs
```bash
tail -f storage/logs/laravel.log
tail -f /var/log/nginx/error.log
```

### Performance Check
- Test page load speed with GTmetrix/PageSpeed Insights
- Check SSL rating with SSL Labs
- Verify mobile responsiveness

### Backup Setup
```bash
# Database backup script
0 2 * * * mysqldump -u username -p'password' bimbel_farmasi | gzip > /backups/db-$(date +\%Y\%m\%d).sql.gz

# File backup
0 3 * * * tar -czf /backups/files-$(date +\%Y\%m\%d).tar.gz /var/www/bimbelfarmasi/storage
```

---

## 📞 Support

Jika ada masalah saat deployment:
1. Check logs: `storage/logs/laravel.log`
2. Check web server logs: `/var/log/nginx/error.log`
3. Run: `php artisan config:clear && php artisan cache:clear`
4. Verify file permissions
5. Check database connection

---

## 🔄 Update/Redeploy

Gunakan script `deploy.sh`:
```bash
bash deploy.sh
```

Atau manual:
```bash
git pull origin main
composer install --optimize-autoloader --no-dev
npm run build
php artisan migrate --force
php artisan optimize
sudo systemctl restart php8.2-fpm nginx
```

---

**Last Updated:** December 8, 2025
**Version:** 1.0.0
