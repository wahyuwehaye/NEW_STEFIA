# STEFIA Deployment Guide

## Overview

STEFIA (Student Educational Financial Administration) is a comprehensive Laravel-based financial management system for educational institutions. This guide covers the complete deployment process for production environments.

## System Requirements

### Minimum Requirements
- **PHP**: 8.2 or higher
- **MySQL**: 8.0 or higher
- **Node.js**: 18.0 or higher
- **Composer**: 2.0 or higher
- **Redis**: 7.0 or higher (optional but recommended)
- **Web Server**: Nginx or Apache
- **Memory**: 2GB RAM minimum, 4GB recommended
- **Storage**: 10GB minimum, 20GB recommended

### Production Environment
- **OS**: Ubuntu 20.04 LTS or CentOS 8
- **SSL Certificate**: Required for production
- **Database**: Dedicated MySQL server
- **Caching**: Redis for session and cache storage
- **Queue Processing**: Supervisor for queue workers
- **Monitoring**: Application monitoring tools

## Pre-Deployment Checklist

### 1. Environment Setup
- [ ] Verify PHP version and extensions
- [ ] Install and configure MySQL
- [ ] Install Node.js and npm
- [ ] Install Composer
- [ ] Configure web server (Nginx/Apache)
- [ ] Set up SSL certificate
- [ ] Configure firewall rules

### 2. Database Preparation
- [ ] Create database and user
- [ ] Configure database permissions
- [ ] Set up database backups
- [ ] Configure connection pooling

### 3. Security Configuration
- [ ] Generate application key
- [ ] Set secure environment variables
- [ ] Configure CSRF protection
- [ ] Set up rate limiting
- [ ] Configure CORS settings

## Deployment Methods

### Method 1: Docker Deployment (Recommended)

#### Prerequisites
```bash
# Install Docker and Docker Compose
curl -fsSL https://get.docker.com -o get-docker.sh
sh get-docker.sh

# Install Docker Compose
sudo curl -L "https://github.com/docker/compose/releases/latest/download/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

#### Deployment Steps
```bash
# 1. Clone the repository
git clone https://github.com/your-repo/stefia.git
cd stefia

# 2. Copy environment configuration
cp .env.example .env

# 3. Configure environment variables
nano .env

# 4. Build and start containers
docker-compose up -d

# 5. Install dependencies and migrate database
docker-compose exec app composer install --no-dev --optimize-autoloader
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate --force
docker-compose exec app php artisan db:seed --force

# 6. Build frontend assets
docker-compose exec app npm install
docker-compose exec app npm run build

# 7. Set permissions
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
```

### Method 2: Manual Deployment

#### Server Setup
```bash
# Update system packages
sudo apt update && sudo apt upgrade -y

# Install PHP and extensions
sudo apt install -y php8.2-fpm php8.2-mysql php8.2-xml php8.2-zip php8.2-mbstring php8.2-curl php8.2-bcmath php8.2-gd php8.2-redis

# Install MySQL
sudo apt install -y mysql-server

# Install Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs

# Install Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Install Redis
sudo apt install -y redis-server

# Install Nginx
sudo apt install -y nginx
```

#### Application Deployment
```bash
# 1. Clone repository
cd /var/www
sudo git clone https://github.com/your-repo/stefia.git
cd stefia

# 2. Set permissions
sudo chown -R www-data:www-data /var/www/stefia
sudo chmod -R 755 /var/www/stefia
sudo chmod -R 775 /var/www/stefia/storage
sudo chmod -R 775 /var/www/stefia/bootstrap/cache

# 3. Install dependencies
composer install --no-dev --optimize-autoloader

# 4. Configure environment
cp .env.example .env
nano .env

# 5. Generate application key
php artisan key:generate

# 6. Run migrations
php artisan migrate --force

# 7. Seed database
php artisan db:seed --force

# 8. Install and build frontend assets
npm install
npm run build

# 9. Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Environment Configuration

### Required Environment Variables

```env
# Application
APP_NAME=STEFIA
APP_ENV=production
APP_KEY=base64:your-generated-key
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=stefia
DB_USERNAME=stefia_user
DB_PASSWORD=secure_password

# Cache & Session
CACHE_DRIVER=redis
SESSION_DRIVER=redis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# Queue
QUEUE_CONNECTION=redis

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@your-domain.com
MAIL_FROM_NAME="${APP_NAME}"

# API
SANCTUM_STATEFUL_DOMAINS=your-domain.com
```

## Web Server Configuration

### Nginx Configuration
```nginx
server {
    listen 80;
    server_name your-domain.com;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl http2;
    server_name your-domain.com;
    root /var/www/stefia/public;

    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;

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

## Queue Configuration

### Supervisor Configuration
```ini
[program:stefia-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/stefia/artisan queue:work --verbose --tries=3 --timeout=90
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=4
redirect_stderr=true
stdout_logfile=/var/www/stefia/storage/logs/worker.log
stopwaitsecs=3600
```

### Start Supervisor
```bash
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start stefia-worker:*
```

## Cron Jobs

### Laravel Scheduler
```bash
# Add to crontab
sudo crontab -e

# Add this line
* * * * * cd /var/www/stefia && php artisan schedule:run >> /dev/null 2>&1
```

## Security Hardening

### 1. File Permissions
```bash
# Set proper ownership
sudo chown -R www-data:www-data /var/www/stefia

# Set directory permissions
sudo find /var/www/stefia -type d -exec chmod 755 {} \;

# Set file permissions
sudo find /var/www/stefia -type f -exec chmod 644 {} \;

# Set executable permissions
sudo chmod 755 /var/www/stefia/artisan

# Secure sensitive directories
sudo chmod -R 775 /var/www/stefia/storage
sudo chmod -R 775 /var/www/stefia/bootstrap/cache
```

### 2. Database Security
```sql
-- Create dedicated database user
CREATE USER 'stefia_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON stefia.* TO 'stefia_user'@'localhost';
FLUSH PRIVILEGES;

-- Remove test databases and users
DROP DATABASE IF EXISTS test;
DELETE FROM mysql.user WHERE User='';
FLUSH PRIVILEGES;
```

### 3. Additional Security
```bash
# Configure firewall
sudo ufw allow ssh
sudo ufw allow 80
sudo ufw allow 443
sudo ufw enable

# Disable unnecessary services
sudo systemctl disable apache2 # if using nginx
sudo systemctl disable sendmail # if using external mail
```

## Monitoring and Logging

### 1. Application Logs
```bash
# Monitor application logs
tail -f /var/www/stefia/storage/logs/laravel.log

# Rotate logs
sudo logrotate -d /etc/logrotate.d/laravel
```

### 2. System Monitoring
```bash
# Install monitoring tools
sudo apt install -y htop iotop nethogs

# Monitor processes
htop

# Monitor database
mysql -u root -p -e "SHOW PROCESSLIST;"
```

## Backup Strategy

### 1. Database Backup
```bash
#!/bin/bash
# Database backup script
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/stefia"
mkdir -p $BACKUP_DIR

mysqldump -u stefia_user -p'secure_password' stefia > $BACKUP_DIR/stefia_db_$DATE.sql
gzip $BACKUP_DIR/stefia_db_$DATE.sql

# Keep only last 7 days
find $BACKUP_DIR -name "stefia_db_*.sql.gz" -mtime +7 -delete
```

### 2. Application Backup
```bash
#!/bin/bash
# Application backup script
DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="/var/backups/stefia"
APP_DIR="/var/www/stefia"

tar -czf $BACKUP_DIR/stefia_app_$DATE.tar.gz -C $APP_DIR .
find $BACKUP_DIR -name "stefia_app_*.tar.gz" -mtime +7 -delete
```

## Performance Optimization

### 1. PHP Optimization
```ini
# /etc/php/8.2/fpm/php.ini
memory_limit = 256M
max_execution_time = 300
upload_max_filesize = 100M
post_max_size = 100M
max_input_vars = 10000

# OPcache settings
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
opcache.revalidate_freq=60
opcache.fast_shutdown=1
```

### 2. Database Optimization
```sql
-- Optimize MySQL configuration
[mysqld]
innodb_buffer_pool_size = 1G
innodb_log_file_size = 256M
innodb_flush_log_at_trx_commit = 2
query_cache_size = 256M
query_cache_limit = 2M
```

### 3. Laravel Optimization
```bash
# Optimize Laravel for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan storage:link
```

## Troubleshooting

### Common Issues

1. **Permission Errors**
   ```bash
   sudo chown -R www-data:www-data storage bootstrap/cache
   sudo chmod -R 775 storage bootstrap/cache
   ```

2. **Database Connection Issues**
   ```bash
   # Check MySQL status
   sudo systemctl status mysql
   
   # Check connection
   mysql -u stefia_user -p -e "SELECT 1;"
   ```

3. **Queue Not Processing**
   ```bash
   # Check supervisor status
   sudo supervisorctl status stefia-worker:*
   
   # Restart workers
   sudo supervisorctl restart stefia-worker:*
   ```

4. **Assets Not Loading**
   ```bash
   # Rebuild assets
   npm run build
   
   # Check permissions
   sudo chmod -R 755 public/build
   ```

## Maintenance

### Regular Tasks

1. **Update Dependencies**
   ```bash
   composer update
   npm update
   ```

2. **Clear Cache**
   ```bash
   php artisan cache:clear
   php artisan config:clear
   php artisan route:clear
   php artisan view:clear
   ```

3. **Database Maintenance**
   ```bash
   php artisan migrate
   php artisan db:seed --class=UpdateSeeder
   ```

### Monthly Tasks

1. **Security Updates**
   ```bash
   sudo apt update && sudo apt upgrade -y
   ```

2. **Log Rotation**
   ```bash
   sudo logrotate -f /etc/logrotate.conf
   ```

3. **Performance Review**
   ```bash
   php artisan telescope:clear
   php artisan horizon:clear
   ```

## Support and Documentation

### Getting Help
- **Documentation**: Check the `/docs` directory for detailed documentation
- **Issues**: Report issues on GitHub repository
- **Support**: Contact the development team

### Version Information
- **Laravel**: 11.x
- **PHP**: 8.2+
- **Node.js**: 18.x
- **MySQL**: 8.0+
- **Redis**: 7.x

This deployment guide ensures a secure, scalable, and maintainable STEFIA installation in production environments.
