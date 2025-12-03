# Stock Opname - VPS Deployment Guide

Panduan lengkap untuk deploy aplikasi Stock Opname ke VPS.

## 📋 Requirements

### VPS Minimum Specs:
- **RAM**: 2GB minimum (4GB recommended)
- **Storage**: 20GB minimum
- **OS**: Ubuntu 22.04 LTS atau Ubuntu 24.04 LTS
- **CPU**: 2 cores minimum

### Software Required:
- Nginx
- PHP 8.2+ (dengan extensions: FPM, MySQL, mbstring, XML, BCMath, cURL, Zip, GD, Redis)
- MySQL 8.0+
- Composer
- Node.js 18+ & NPM
- Redis Server
- Supervisor
- Git
- Certbot (untuk SSL)

---

## 🚀 Deployment Steps

### 1. First Time Setup VPS

**Update konfigurasi di `deploy.sh`:**
```bash
REMOTE_USER="your_vps_user"      # Username SSH VPS Anda
REMOTE_HOST="your_vps_ip"         # IP Address VPS Anda
REMOTE_PATH="/var/www/stock_opname"
```

**Jalankan setup otomatis:**
```bash
chmod +x deploy.sh
./deploy.sh setup
```

Script ini akan:
- Update system packages
- Install Nginx, PHP, MySQL, Node.js, Redis, Supervisor
- Membuat database `stock_opname`
- Membuat user MySQL dengan password default
- Setup direktori project

---

### 2. Configure VPS Manual

#### A. Setup Nginx

1. Copy konfigurasi Nginx:
```bash
sudo nano /etc/nginx/sites-available/stock_opname
```

2. Paste isi dari file `nginx.conf` (sesuaikan domain)

3. Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/stock_opname /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

#### B. Setup SSL dengan Let's Encrypt

```bash
# Install Certbot
sudo apt install certbot python3-certbot-nginx

# Generate SSL certificate
sudo certbot --nginx -d yourdomain.com -d www.yourdomain.com

# Auto-renewal (optional check)
sudo certbot renew --dry-run
```

#### C. Setup Firewall (UFW)

```bash
sudo ufw allow OpenSSH
sudo ufw allow 'Nginx Full'
sudo ufw enable
sudo ufw status
```

#### D. Configure MySQL

```bash
# Login ke MySQL
sudo mysql

# Create database dan user dengan password yang aman
CREATE DATABASE stock_opname;
CREATE USER 'stock_opname'@'localhost' IDENTIFIED BY 'your_secure_password_here';
GRANT ALL PRIVILEGES ON stock_opname.* TO 'stock_opname'@'localhost';
FLUSH PRIVILEGES;
EXIT;
```

#### E. Setup Supervisor (Queue Workers)

1. Copy konfigurasi:
```bash
sudo cp supervisor.conf /etc/supervisor/conf.d/stock-opname-worker.conf
```

2. Update dan start:
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start stock-opname-worker:*
```

---

### 3. Configure Environment di VPS

1. SSH ke VPS:
```bash
ssh your_user@your_vps_ip
```

2. Buat file `.env` di `/var/www/stock_opname/`:
```bash
cd /var/www/stock_opname
nano .env
```

3. Copy isi dari `.env.production` dan sesuaikan:
```env
APP_URL=https://yourdomain.com
DB_PASSWORD=your_secure_password_here
```

4. Generate APP_KEY baru (jika perlu):
```bash
php artisan key:generate
```

---

### 4. Deploy Application

Dari local machine:

```bash
# Build dan deploy
./deploy.sh
```

Script akan:
- Build assets production (Vite)
- Compress project files
- Upload ke VPS
- Install dependencies
- Run migrations
- Clear & cache config
- Restart services

---

## 🔄 Update/Re-deploy

Setiap kali ada perubahan code:

```bash
# Commit changes
git add .
git commit -m "Your changes"
git push

# Deploy
./deploy.sh
```

---

## 📱 Update Mobile App API URL

Setelah deploy, update API URL di mobile app:

**Edit `stock_opname_mobile/lib/config/app_config.dart`:**
```dart
static const String baseUrl = String.fromEnvironment(
  'API_BASE_URL',
  defaultValue: 'https://yourdomain.com/api',  // Update ini
);
```

Atau run dengan environment variable:
```bash
flutter run --dart-define=API_BASE_URL=https://yourdomain.com/api
```

---

## 🛠️ Troubleshooting

### Cek Logs

**Laravel Logs:**
```bash
tail -f /var/www/stock_opname/storage/logs/laravel.log
```

**Nginx Logs:**
```bash
sudo tail -f /var/log/nginx/stock_opname_error.log
sudo tail -f /var/log/nginx/stock_opname_access.log
```

**PHP-FPM Logs:**
```bash
sudo tail -f /var/log/php8.2-fpm.log
```

**Queue Worker Logs:**
```bash
sudo tail -f /var/www/stock_opname/storage/logs/worker.log
```

### Permission Issues

```bash
cd /var/www/stock_opname
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 755 storage bootstrap/cache
```

### Clear Cache di Production

```bash
cd /var/www/stock_opname
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Restart Services

```bash
# PHP-FPM
sudo systemctl restart php8.2-fpm

# Nginx
sudo systemctl restart nginx

# Queue Workers
sudo supervisorctl restart stock-opname-worker:*

# Redis
sudo systemctl restart redis
```

### Database Migration Issues

```bash
# Check migration status
php artisan migrate:status

# Rollback last migration
php artisan migrate:rollback

# Fresh migrate (WARNING: deletes all data)
php artisan migrate:fresh --seed
```

---

## 🔒 Security Checklist

- [ ] SSL Certificate installed (HTTPS)
- [ ] Firewall configured (UFW)
- [ ] Strong database password
- [ ] `APP_DEBUG=false` in production
- [ ] `.env` file secured (not in git)
- [ ] File permissions correct (755 for directories, 644 for files)
- [ ] Disable directory listing in Nginx
- [ ] Security headers configured
- [ ] Regular backups scheduled
- [ ] PHP configuration hardened

---

## 💾 Backup Strategy

### Database Backup (Cron Job)

```bash
# Create backup script
sudo nano /usr/local/bin/backup-stock-opname.sh
```

```bash
#!/bin/bash
BACKUP_DIR="/var/backups/stock_opname"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)
DB_NAME="stock_opname"
DB_USER="stock_opname"
DB_PASS="your_password"

mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u$DB_USER -p$DB_PASS $DB_NAME | gzip > $BACKUP_DIR/db_$TIMESTAMP.sql.gz

# Backup files
tar -czf $BACKUP_DIR/files_$TIMESTAMP.tar.gz /var/www/stock_opname

# Keep only last 7 days
find $BACKUP_DIR -type f -mtime +7 -delete

echo "Backup completed: $TIMESTAMP"
```

```bash
# Make executable
sudo chmod +x /usr/local/bin/backup-stock-opname.sh

# Add to crontab (daily at 2 AM)
sudo crontab -e
# Add: 0 2 * * * /usr/local/bin/backup-stock-opname.sh
```

---

## 📊 Monitoring

### Setup Basic Monitoring

```bash
# Install htop for process monitoring
sudo apt install htop

# Check disk usage
df -h

# Check memory usage
free -h

# Check PHP-FPM status
sudo systemctl status php8.2-fpm

# Check Nginx status
sudo systemctl status nginx

# Check MySQL status
sudo systemctl status mysql

# Check queue workers
sudo supervisorctl status
```

---

## 🚀 Performance Optimization

### PHP-FPM Tuning

Edit `/etc/php/8.2/fpm/pool.d/www.conf`:
```ini
pm = dynamic
pm.max_children = 50
pm.start_servers = 5
pm.min_spare_servers = 5
pm.max_spare_servers = 35
pm.max_requests = 500
```

### MySQL Tuning

Edit `/etc/mysql/mysql.conf.d/mysqld.cnf`:
```ini
[mysqld]
innodb_buffer_pool_size = 1G
max_connections = 150
query_cache_size = 32M
```

### Redis Configuration

Edit `/etc/redis/redis.conf`:
```ini
maxmemory 256mb
maxmemory-policy allkeys-lru
```

---

## 📞 Support

Jika ada masalah saat deployment, cek:
1. Laravel logs
2. Nginx error logs
3. PHP-FPM logs
4. System logs: `sudo journalctl -xe`

---

## ✅ Post-Deployment Checklist

- [ ] Website dapat diakses via HTTPS
- [ ] API endpoint berfungsi (`/api/login`)
- [ ] Database migrations sukses
- [ ] Queue workers berjalan
- [ ] SSL certificate valid
- [ ] Mobile app dapat connect ke API
- [ ] Backup script berjalan
- [ ] Monitoring setup
- [ ] DNS configured correctly
- [ ] Performance tested
