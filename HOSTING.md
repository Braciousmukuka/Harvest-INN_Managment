# HarvestInn Farm Management System - Hosting Guide

## 🌟 Self-Contained Hosting (No External Database Required)

Your HarvestInn application is completely self-contained and uses SQLite, which means:
- ✅ No MySQL/PostgreSQL server needed
- ✅ No external database hosting costs
- ✅ Single file database (database/database.sqlite)
- ✅ Easy backup and deployment
- ✅ Works on any hosting provider

## 🚀 Deployment Options

### Option 1: Shared Hosting (cPanel/Plesk)
1. Upload all files to your hosting account
2. Point your domain to the `public` folder
3. Run: `php artisan migrate --force`
4. Set folder permissions: `chmod -R 755 storage bootstrap/cache`

### Option 2: VPS/Cloud Server (DigitalOcean, AWS, etc.)
1. Clone/upload your application
2. Install PHP 8.1+ with extensions: `sqlite3`, `mbstring`, `xml`, `curl`
3. Install Composer and run: `composer install --no-dev --optimize-autoloader`
4. Run the deployment script: `./deploy.sh`
5. Configure Nginx/Apache to serve from `public` directory

### Option 3: Docker Deployment
```dockerfile
FROM php:8.2-apache
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html/storage
EXPOSE 80
```

### Option 4: Laravel Forge/Vapor
- Works perfectly with SQLite
- Just deploy and run migrations

## 📁 Essential Files for Hosting

```
HarvestInn/
├── app/                 # Application logic
├── database/
│   └── database.sqlite  # Your complete database (backup this!)
├── public/              # Web server document root
├── storage/             # File storage (needs write permissions)
├── .env                 # Environment configuration
└── artisan              # Laravel command line tool
```

## 🔧 Server Requirements

**Minimum PHP Requirements:**
- PHP >= 8.1
- SQLite3 extension
- mbstring extension
- XML extension
- cURL extension

**Optional but Recommended:**
- opcache for better performance
- composer for updates

## 🛡️ Security Checklist

- ✅ APP_DEBUG=false in production
- ✅ Strong APP_KEY generated
- ✅ storage/ and bootstrap/cache/ writable
- ✅ .env file protected from web access
- ✅ Only public/ folder accessible via web

## 📊 Database Backup

Your entire database is in one file:
```bash
# Backup
cp database/database.sqlite backups/database-$(date +%Y%m%d).sqlite

# Restore
cp backups/database-20250802.sqlite database/database.sqlite
```

## 🌐 Custom Domain Setup

1. Point your domain to the `public` folder
2. Update APP_URL in .env: `APP_URL=https://yourdomain.com`
3. Clear caches: `php artisan config:clear`

## 📈 Performance Tips

- Enable OPcache on your server
- Use `php artisan config:cache` for production
- Enable gzip compression in your web server
- Use a CDN for static assets

## 🎯 Ready-to-Deploy Features

Your application includes:
- ✅ Complete farm management system
- ✅ Product inventory tracking
- ✅ Sales management with analytics
- ✅ Purchase tracking
- ✅ Incubation monitoring
- ✅ Interactive Chart.js dashboards
- ✅ User authentication
- ✅ Responsive design
- ✅ Print-friendly reports
