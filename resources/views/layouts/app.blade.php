<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <!-- Prevent Caching During Development -->
        <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
        <meta http-equiv="Pragma" content="no-cache">
        <meta http-equiv="Expires" content="0">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- PWA Meta Tags -->
        <meta name="description" content="Complete farm management system for tracking products, sales, purchases, and incubations">
        <meta name="theme-color" content="#28a745">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="default">
        <meta name="apple-mobile-web-app-title" content="HarvestInn">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="application-name" content="HarvestInn">
        
        <!-- PWA Manifest -->
        <link rel="manifest" href="{{ asset('manifest.json') }}">
        
        <!-- PWA Icons -->
        <link rel="icon" type="image/png" sizes="72x72" href="{{ asset('pwa-icons/icon-72x72.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('pwa-icons/icon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="128x128" href="{{ asset('pwa-icons/icon-128x128.png') }}">
        <link rel="icon" type="image/png" sizes="144x144" href="{{ asset('pwa-icons/icon-144x144.png') }}">
        <link rel="icon" type="image/png" sizes="152x152" href="{{ asset('pwa-icons/icon-152x152.png') }}">
        <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('pwa-icons/icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="384x384" href="{{ asset('pwa-icons/icon-384x384.png') }}">
        <link rel="icon" type="image/png" sizes="512x512" href="{{ asset('pwa-icons/icon-512x512.png') }}">
        
        <!-- Apple Touch Icons -->
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('pwa-icons/icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('pwa-icons/icon-192x192.png') }}">
        
        <!-- Microsoft Tiles -->
        <meta name="msapplication-TileImage" content="{{ asset('pwa-icons/icon-144x144.png') }}">
        <meta name="msapplication-TileColor" content="#28a745">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Berry Dashboard CSS -->
        <link href="{{ asset('assets/css/plugins/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/fonts/tabler-icons.min.css') }}" rel="stylesheet">
        
        <!-- Feather Icons -->
        <link href="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.css" rel="stylesheet">
        
        <!-- Page specific styles -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-50">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow border-b border-harvest-gold/20">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset
            
            <!-- Flash Messages -->
            @include('components.flash-messages')

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>
        </div>
        
        <!-- Berry Dashboard JS -->
        <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/pcoded.js') }}"></script>
        
        <!-- Feather Icons JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.29.0/dist/feather.min.js"></script>
        <script>
            // Initialize Feather icons globally
            document.addEventListener('DOMContentLoaded', function() {
                feather.replace();
            });
        </script>
        
        <!-- Page specific scripts -->
        @stack('scripts')
        
        <!-- PWA Service Worker Registration (Optimized) -->
        <script>
            // Only register service worker in production for better development experience
            @if(config('app.env') === 'production')
            if ('serviceWorker' in navigator) {
                // Delay registration to allow page to load first
                setTimeout(function() {
                    navigator.serviceWorker.register('/sw.js')
                        .then(function(registration) {
                            console.log('HarvestInn SW registered: ', registration.scope);
                        })
                        .catch(function(registrationError) {
                            console.log('HarvestInn SW registration failed: ', registrationError);
                        });
                }, 1000); // Register after 1 second delay
            }
            @else
            console.log('Service Worker disabled in development mode');
            @endif

            // PWA Install Prompt
            let deferredPrompt;
            let installBtn = document.getElementById('pwa-install-btn');
            let installBtnMobile = document.getElementById('pwa-install-btn-mobile');

            window.addEventListener('beforeinstallprompt', (e) => {
                console.log('HarvestInn can be installed');
                e.preventDefault();
                deferredPrompt = e;
                
                // Show install buttons
                if (installBtn) installBtn.style.display = 'inline-flex';
                if (installBtnMobile) installBtnMobile.style.display = 'flex';
                
                // Create floating install prompt
                showInstallPrompt();
            });

            function installPWA() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the install prompt');
                            showInstallSuccess();
                        } else {
                            console.log('User dismissed the install prompt');
                        }
                        deferredPrompt = null;
                        hideInstallButtons();
                        closeInstallPrompt();
                    });
                } else {
                    // Fallback: show manual install instructions
                    showInstallHelp();
                }
            }

            function showInstallSuccess() {
                const successMsg = document.createElement('div');
                successMsg.innerHTML = `
                    <div style="position: fixed; top: 20px; right: 20px; background: #28a745; color: white; padding: 15px 20px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 9999; font-family: sans-serif;">
                        <div style="display: flex; align-items: center;">
                            <svg style="width: 24px; height: 24px; margin-right: 10px;" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <div>
                                <strong>Success!</strong><br>
                                <small>HarvestInn has been installed successfully</small>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(successMsg);
                setTimeout(() => successMsg.remove(), 5000);
            }

            function hideInstallButtons() {
                if (installBtn) installBtn.style.display = 'none';
                if (installBtnMobile) installBtnMobile.style.display = 'none';
            }

            function showInstallHelp() {
                const helpModal = document.createElement('div');
                helpModal.id = 'install-help-modal';
                helpModal.innerHTML = `
                    <div style="position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 10000; display: flex; align-items: center; justify-content: center; padding: 20px;">
                        <div style="background: white; border-radius: 15px; max-width: 500px; width: 100%; max-height: 90vh; overflow-y: auto; font-family: sans-serif;">
                            <div style="padding: 30px;">
                                <div style="text-align: center; margin-bottom: 25px;">
                                    <div style="width: 60px; height: 60px; background: #28a745; border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">📱</div>
                                    <h2 style="margin: 0; color: #333; font-size: 24px;">Install HarvestInn App</h2>
                                    <p style="color: #666; margin: 10px 0 0;">Get the full app experience on your device</p>
                                </div>
                                
                                <div style="margin-bottom: 25px;">
                                    <h3 style="color: #28a745; font-size: 18px; margin-bottom: 15px; display: flex; align-items: center;">
                                        <span style="margin-right: 10px;">🖥️</span> Desktop (Chrome/Edge)
                                    </h3>
                                    <ol style="padding-left: 20px; line-height: 1.6; color: #555;">
                                        <li>Look for the <strong>"Install"</strong> button in your browser's address bar</li>
                                        <li>Click the install button or use the "Get App" button above</li>
                                        <li>Confirm installation in the popup</li>
                                        <li>The app will open in its own window</li>
                                    </ol>
                                </div>
                                
                                <div style="margin-bottom: 25px;">
                                    <h3 style="color: #28a745; font-size: 18px; margin-bottom: 15px; display: flex; align-items: center;">
                                        <span style="margin-right: 10px;">📱</span> iPhone/iPad (Safari)
                                    </h3>
                                    <ol style="padding-left: 20px; line-height: 1.6; color: #555;">
                                        <li>Tap the <strong>Share</strong> button (square with arrow)</li>
                                        <li>Scroll down and tap <strong>"Add to Home Screen"</strong></li>
                                        <li>Tap <strong>"Add"</strong> in the top right corner</li>
                                        <li>The app icon will appear on your home screen</li>
                                    </ol>
                                </div>
                                
                                <div style="margin-bottom: 25px;">
                                    <h3 style="color: #28a745; font-size: 18px; margin-bottom: 15px; display: flex; align-items: center;">
                                        <span style="margin-right: 10px;">🤖</span> Android (Chrome)
                                    </h3>
                                    <ol style="padding-left: 20px; line-height: 1.6; color: #555;">
                                        <li>Tap the <strong>menu</strong> (three dots) in the browser</li>
                                        <li>Select <strong>"Add to Home screen"</strong> or <strong>"Install app"</strong></li>
                                        <li>Tap <strong>"Add"</strong> to confirm</li>
                                        <li>The app will be installed like a native app</li>
                                    </ol>
                                </div>
                                
                                <div style="background: #f8f9fa; padding: 20px; border-radius: 10px; margin-bottom: 25px;">
                                    <h4 style="color: #28a745; margin: 0 0 10px; font-size: 16px;">✨ App Benefits:</h4>
                                    <ul style="margin: 0; padding-left: 20px; line-height: 1.6; color: #555;">
                                        <li>Works offline</li>
                                        <li>Faster loading</li>
                                        <li>Native app experience</li>
                                        <li>Home screen access</li>
                                        <li>Push notifications (coming soon)</li>
                                    </ul>
                                </div>
                                
                                <div style="text-align: center;">
                                    <button onclick="closeInstallHelp()" style="background: #28a745; color: white; border: none; padding: 12px 30px; border-radius: 25px; font-size: 16px; cursor: pointer; margin-right: 10px;">Got it!</button>
                                    <button onclick="installPWA(); closeInstallHelp();" style="background: #007bff; color: white; border: none; padding: 12px 30px; border-radius: 25px; font-size: 16px; cursor: pointer;">Try Install</button>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
                document.body.appendChild(helpModal);
            }

            function closeInstallHelp() {
                const modal = document.getElementById('install-help-modal');
                if (modal) modal.remove();
            }

            // Close modal when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target.id === 'install-help-modal') {
                    closeInstallHelp();
                }
            });

            function showInstallPrompt() {
                // Create install prompt if it doesn't exist
                if (document.getElementById('pwa-install-prompt')) return;
                
                const installPrompt = document.createElement('div');
                installPrompt.id = 'pwa-install-prompt';
                installPrompt.innerHTML = `
                    <div style="position: fixed; bottom: 20px; right: 20px; background: #28a745; color: white; padding: 15px 20px; border-radius: 10px; box-shadow: 0 4px 15px rgba(0,0,0,0.2); z-index: 9999; max-width: 300px; font-family: sans-serif;">
                        <div style="display: flex; align-items: center; justify-content: space-between;">
                            <div>
                                <strong>Install HarvestInn</strong>
                                <br><small>Add to your home screen for easy access</small>
                            </div>
                            <button onclick="installPWA()" style="background: white; color: #28a745; border: none; padding: 8px 15px; border-radius: 5px; margin-left: 10px; cursor: pointer; font-weight: bold;">Install</button>
                        </div>
                        <button onclick="closeInstallPrompt()" style="position: absolute; top: 5px; right: 10px; background: none; border: none; color: white; font-size: 18px; cursor: pointer;">&times;</button>
                    </div>
                `;
                document.body.appendChild(installPrompt);
                
                // Auto-hide after 10 seconds
                setTimeout(() => {
                    closeInstallPrompt();
                }, 10000);
            }

            function installPWA() {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the install prompt');
                        }
                        deferredPrompt = null;
                        closeInstallPrompt();
                    });
                }
            }

            function closeInstallPrompt() {
                const prompt = document.getElementById('pwa-install-prompt');
                if (prompt) {
                    prompt.remove();
                }
            }

            // Handle app installation
            window.addEventListener('appinstalled', (evt) => {
                console.log('HarvestInn was installed');
                closeInstallPrompt();
                hideInstallButtons();
                showInstallSuccess();
            });

            // Make functions globally available
            window.installPWA = installPWA;
            window.showInstallHelp = showInstallHelp;
            window.closeInstallHelp = closeInstallHelp;

            // PWA Popup Management
            const installPopup = document.getElementById('pwa-install-popup');
            const popupInstallBtn = document.getElementById('popup-install-btn');

            function showPWAPopup() {
                // Check if user has dismissed popup recently
                const dismissed = localStorage.getItem('pwa-popup-dismissed');
                const dismissedTime = dismissed ? parseInt(dismissed) : 0;
                const oneDayAgo = Date.now() - (24 * 60 * 60 * 1000); // 24 hours
                
                // Check if already installed
                const isInstalled = window.matchMedia('(display-mode: standalone)').matches;
                
                if (!dismissed || dismissedTime < oneDayAgo) {
                    if (!isInstalled && installPopup) {
                        setTimeout(() => {
                            installPopup.classList.add('show');
                        }, 4000); // Show after 4 seconds on app pages
                    }
                }
            }

            window.closePWAPopup = function() {
                if (installPopup) {
                    installPopup.classList.remove('show');
                    // Remember dismissal for 24 hours
                    localStorage.setItem('pwa-popup-dismissed', Date.now().toString());
                }
            }

            // Enhanced beforeinstallprompt handling for popup
            window.addEventListener('beforeinstallprompt', (e) => {
                e.preventDefault();
                deferredPrompt = e;
                
                // Show install buttons in navigation
                showInstallButtons();
                
                // Show install button in popup if popup exists
                if (popupInstallBtn) {
                    popupInstallBtn.style.display = 'inline-block';
                    // Hide the help button when install is available
                    const helpBtn = document.getElementById('popup-help-btn');
                    if (helpBtn) helpBtn.style.display = 'none';
                }
            });

            // Handle popup install button
            if (popupInstallBtn) {
                popupInstallBtn.addEventListener('click', () => {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then((choiceResult) => {
                            if (choiceResult.outcome === 'accepted') {
                                console.log('PWA was installed via popup');
                                closePWAPopup();
                            }
                            deferredPrompt = null;
                            hideInstallButtons();
                        });
                    }
                });
            }

            // Hide popup when app is installed
            window.addEventListener('appinstalled', () => {
                closePWAPopup();
            });

            // Auto-hide popup after 30 seconds if no interaction
            setTimeout(() => {
                if (installPopup && installPopup.classList.contains('show')) {
                    closePWAPopup();
                }
            }, 30000);

            // Show popup for new visitors (only if not on welcome page)
            if (!window.location.pathname === '/' && installPopup) {
                showPWAPopup();
            }

            // Network status indicator
            function updateNetworkStatus() {
                const statusIndicator = document.getElementById('network-status');
                if (statusIndicator) {
                    if (navigator.onLine) {
                        statusIndicator.style.display = 'none';
                    } else {
                        statusIndicator.innerHTML = '<div style="background: #dc3545; color: white; text-align: center; padding: 5px; font-size: 12px;">Offline Mode - Limited functionality</div>';
                        statusIndicator.style.display = 'block';
                    }
                }
            }

            window.addEventListener('online', updateNetworkStatus);
            window.addEventListener('offline', updateNetworkStatus);
            window.addEventListener('load', updateNetworkStatus);
        </script>
        
        <!-- Network Status Indicator -->
        <div id="network-status" style="position: fixed; top: 0; left: 0; right: 0; z-index: 9999;"></div>
        
        <!-- PWA Install Popup -->
        <div id="pwa-install-popup" class="pwa-install-popup" style="display: none;">
            <button class="close-btn" onclick="closePWAPopup()">&times;</button>
            <div class="text-center">
                <i class="fas fa-mobile-alt pwa-popup-icon" style="font-size: 40px; display: block; margin-bottom: 10px; animation: bounce 2s infinite;"></i>
                <h5 class="mb-2">📱 Install HarvestInn App</h5>
                <p class="mb-0 small">Get faster access, work offline, and enjoy a native app experience!</p>
            </div>
            <div class="pwa-popup-buttons" style="display: flex; gap: 10px; margin-top: 15px;">
                <button id="popup-install-btn" class="pwa-popup-btn primary" style="display: none; flex: 1; padding: 10px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; background: #fab200; color: #333;">
                    <i class="fas fa-download me-1"></i>Install Now
                </button>
                <button class="pwa-popup-btn primary" onclick="showInstallHelp()" id="popup-help-btn" style="flex: 1; padding: 10px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; background: #fab200; color: #333;">
                    <i class="fas fa-info-circle me-1"></i>How to Install
                </button>
                <button class="pwa-popup-btn secondary" onclick="closePWAPopup()" style="flex: 1; padding: 10px; border: none; border-radius: 8px; cursor: pointer; font-weight: 600; background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.3);">
                    <i class="fas fa-times me-1"></i>Later
                </button>
            </div>
        </div>

        <style>
            /* PWA Install Popup Styles */
            .pwa-install-popup {
                position: fixed;
                bottom: 20px;
                right: 20px;
                background: linear-gradient(135deg, #087112, #0a8f1a);
                color: white;
                padding: 20px;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.3);
                max-width: 350px;
                z-index: 1050;
                transform: translateY(100px);
                opacity: 0;
                transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
                border: 2px solid rgba(255,255,255,0.2);
            }
            
            .pwa-install-popup.show {
                transform: translateY(0);
                opacity: 1;
                display: block !important;
            }
            
            .pwa-install-popup .close-btn {
                position: absolute;
                top: 10px;
                right: 15px;
                background: none;
                border: none;
                color: white;
                font-size: 20px;
                cursor: pointer;
                opacity: 0.7;
                transition: opacity 0.3s;
            }
            
            .pwa-install-popup .close-btn:hover {
                opacity: 1;
            }
            
            .pwa-popup-icon {
                animation: bounce 2s infinite;
            }
            
            @keyframes bounce {
                0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
                40% { transform: translateY(-10px); }
                60% { transform: translateY(-5px); }
            }
            
            .pwa-popup-btn:hover {
                transform: translateY(-2px);
                transition: all 0.3s;
            }
            
            @media (max-width: 768px) {
                .pwa-install-popup {
                    bottom: 10px;
                    right: 10px;
                    left: 10px;
                    max-width: none;
                }
            }
        </style>
    </body>
</html>
