# 📱 Namecheap Alpine.js Mobile Menu Fix Deployment

## Quick Fix for Mobile Menu Not Working

### 🎯 Problem
Mobile navigation menu toggle button doesn't work because Alpine.js is missing.

### 🔧 Solution Applied
Added Alpine.js to `resources/js/bootstrap.js` and rebuilt assets.

---

## 🚀 Deployment Methods

### **Method 1: File Manager Upload (Fastest)**

1. **Download Built Assets from Local:**
   - Copy files from your local `public/build/assets/` folder
   - You need: `app-BQWjgekO.js` and `app-Df-OTTEe.css`

2. **Upload via cPanel:**
   - Login to Namecheap cPanel
   - Go to **File Manager**
   - Navigate to `public_html/public/build/assets/`
   - Upload the new `app-BQWjgekO.js` file
   - Replace the old version

3. **Update Source File:**
   - Navigate to `public_html/resources/js/`
   - Edit `bootstrap.js`
   - Add this code:
   ```javascript
   // Import and initialize Alpine.js for mobile navigation
   import Alpine from 'alpinejs';
   window.Alpine = Alpine;
   Alpine.start();
   ```

### **Method 2: cPanel Git (Recommended for Future)**

1. **Enable Git in cPanel:**
   - Go to cPanel → **Git Version Control**
   - Click **Create Repository**
   - Repository Path: `/public_html`
   - Repository Name: `harvest-inn`

2. **Clone from GitHub:**
   - Repository URL: `https://github.com/Braciousmukuka/Harvest-INN_Managment.git`
   - Branch: `main`

3. **Set up Auto-deployment:**
   - Enable "Pull Updates" hook
   - Your site will auto-update when you push to GitHub

### **Method 3: FTP/SFTP Upload**

1. **Connect via FTP:**
   - Host: Your domain or server IP
   - Username: Your cPanel username
   - Password: Your cPanel password

2. **Upload Required Files:**
   ```
   /public_html/
   ├── resources/js/bootstrap.js (updated)
   └── public/build/assets/app-BQWjgekO.js (new)
   ```

### **Method 4: SSH Deployment (If Available)**

```bash
# Connect to server
ssh username@yourdomain.com

# Navigate to site
cd public_html

# Pull latest changes
git pull origin main

# Install dependencies
npm install

# Build assets
npm run build

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 🔍 Verification Steps

1. **Test Mobile Menu:**
   - Open site on mobile device or resize browser
   - Click hamburger menu icon (☰)
   - Menu should slide down/appear

2. **Check Browser Console:**
   - Open Developer Tools (F12)
   - Look for Alpine.js initialization
   - Should see no JavaScript errors

3. **Verify Asset Loading:**
   - Check Network tab in DevTools
   - Confirm `app-BQWjgekO.js` loads successfully
   - File size should be ~83KB

---

## 📋 Files Changed

### `resources/js/bootstrap.js`
```javascript
import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Import and initialize Alpine.js for mobile navigation
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();
```

### Built Assets
- `public/build/assets/app-BQWjgekO.js` (new, includes Alpine.js)
- `public/build/manifest.json` (updated with new asset references)

---

## ⚠️ Important Notes

1. **Backup First:** Always backup your current files before uploading
2. **Cache Clear:** Clear browser cache after deployment
3. **Mobile Test:** Test on actual mobile devices, not just browser resize
4. **Production Mode:** Ensure APP_ENV=production in .env file

---

## 🆘 Troubleshooting

### Menu Still Not Working?
1. Clear browser cache completely
2. Check if new JavaScript file is loading
3. Verify no JavaScript console errors
4. Test on different mobile devices

### Build Process Failed?
1. Ensure Node.js is available on server
2. Run `npm install` first
3. Check for build errors in console
4. Upload pre-built assets manually

### Permission Issues?
```bash
chmod 755 public/build/assets/
chmod 644 public/build/assets/*
```

---

## 📞 Support

If deployment issues persist:
1. Check Namecheap hosting documentation
2. Contact Namecheap support for SSH/Git access
3. Consider using staging environment first

**Mobile menu fix is critical for user experience - prioritize this deployment!** 📱✅