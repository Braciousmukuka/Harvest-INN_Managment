# 🌐 HarvestInn PWA - Namecheap Shared Hosting Guide

## 📋 Pre-Deployment Checklist

### ✅ What You Have:
- Complete Laravel application with SQLite database
- PWA functionality (installable app)
- Offline support with service worker
- Self-contained (no external database required)
- Optimized for shared hosting

### 🎯 Namecheap Hosting Requirements:
- **PHP Version**: 8.1 or higher ✅
- **Extensions**: sqlite3, mbstring, xml, curl ✅
- **Storage**: 100MB+ (your app uses ~50MB) ✅
- **MySQL**: Not required (using SQLite) ✅

## 🚀 Step-by-Step Deployment

### Step 1: Prepare Files for Upload
```bash
# Run this locally before uploading
./generate-pwa-icons.sh  # Generate PWA icons
php artisan optimize     # Optimize for production
zip -r harvestinn.zip . -x "node_modules/*" "*.git*" "tests/*"
```

### Step 2: Upload to Namecheap
1. **Log into cPanel** on your Namecheap hosting
2. **Open File Manager**
3. **Navigate to public_html** (or your domain folder)
4. **Upload harvestinn.zip**
5. **Extract the zip file**
6. **Move all files from the extracted folder to public_html**

### Step 3: Configure Domain
**Important**: Your Laravel app needs the `public` folder as document root.

**Option A: Subdomain Setup (Recommended)**
1. Create subdomain: `app.yourdomain.com`
2. Point subdomain to `/public_html/harvestinn/public`

**Option B: Main Domain Setup**
1. Move contents of `public` folder to `public_html`
2. Move Laravel app to `public_html/app`
3. Edit `public_html/index.php`:
```php
require __DIR__.'/app/vendor/autoload.php';
$app = require_once __DIR__.'/app/bootstrap/app.php';
```

### Step 4: Set Permissions
```bash
# In cPanel File Manager, set permissions:
chmod 755 storage/
chmod 755 bootstrap/cache/
chmod 644 database/database.sqlite
```

### Step 5: Run Setup Commands
**Via SSH (if available):**
```bash
cd public_html/harvestinn
php artisan migrate --force
php artisan config:cache
php artisan route:cache
```

**Via cPanel Terminal or create setup.php:**
```php
<?php
// Create this file in your public folder and run once
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

// Run migrations
$kernel->call('migrate', ['--force' => true]);
$kernel->call('config:cache');
$kernel->call('route:cache');

echo "HarvestInn setup completed!";
unlink(__FILE__); // Delete this file after running
?>
```

### Step 6: Update Environment
Create `.env` file in your app root:
```env
APP_NAME=HarvestInn
APP_ENV=production
APP_KEY=base64:ii5nYJfiujq1iGlyx1v6uE7rsUGn+IxWHxrJix0+GaI=
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=sqlite
SESSION_DRIVER=file
CACHE_STORE=file
QUEUE_CONNECTION=sync

MAIL_MAILER=log
```

## 📱 PWA Installation Features

### ✅ Your Users Can:
- **Install on Mobile**: Add to home screen (iOS/Android)
- **Install on Desktop**: Install button in Chrome/Edge
- **Work Offline**: View cached data without internet
- **Fast Loading**: Cached assets load instantly
- **Native Feel**: Full-screen app experience

### 🔧 PWA Features Included:
- **App Manifest**: Complete installation metadata
- **Service Worker**: Offline functionality
- **App Icons**: All required sizes (72px to 512px)
- **Offline Page**: Custom offline experience
- **Install Prompt**: Smart install suggestions
- **Network Status**: Shows connection state
- **Caching Strategy**: Intelligent asset caching

## 🎯 Post-Deployment Testing

### Test PWA Installation:
1. **Visit your site** on mobile/desktop
2. **Look for install prompt** in browser
3. **Chrome**: "Install" button in address bar
4. **Mobile Safari**: "Add to Home Screen" in share menu
5. **Android**: "Add to Home Screen" prompt

### Test Offline Mode:
1. **Install the app**
2. **Disconnect internet**
3. **Open the app** - should work offline
4. **Reconnect** - should sync automatically

## 📊 Namecheap Specific Tips

### File Structure:
```
public_html/
├── harvestinn/          # Your Laravel app
│   ├── app/
│   ├── database/
│   │   └── database.sqlite
│   ├── storage/         # Must be writable
│   └── public/          # Web accessible files
├── .htaccess           # URL rewriting
└── index.php           # Entry point
```

### Performance Optimization:
- **Enable OPcache** in cPanel PHP settings
- **Use latest PHP version** (8.1+)
- **Enable Gzip compression** in cPanel
- **Set up CloudFlare** for CDN (free)

### Security Settings:
- **Hide .env file** (add to .htaccess):
```apache
<Files .env>
    Order allow,deny
    Deny from all
</Files>
```

## 🆘 Troubleshooting

### Common Issues:

**"500 Internal Server Error"**
- Check file permissions (755/644)
- Verify PHP version (8.1+)
- Check error logs in cPanel

**"Database not found"**
- Ensure database.sqlite exists
- Check file permissions (644)
- Verify SQLite extension enabled

**PWA not installing**
- Check HTTPS is enabled
- Verify manifest.json is accessible
- Check service worker loads without errors

**Offline mode not working**
- Clear browser cache
- Check service worker registration
- Verify offline.html exists

## 🎉 Success Checklist

After deployment, your HarvestInn should:
- ✅ Load on your domain
- ✅ Show install prompt on supported browsers
- ✅ Work offline after installation
- ✅ Display all farm management features
- ✅ Show analytics charts
- ✅ Allow user login/registration
- ✅ Save data to SQLite database

## 📞 Support

If you encounter issues:
1. Check Namecheap knowledge base
2. Use cPanel error logs
3. Test locally first
4. Check PHP version compatibility

Your HarvestInn PWA is now ready for production use! 🚀
