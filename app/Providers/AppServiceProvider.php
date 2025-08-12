<?php

namespace App\Providers;

use App\Models\Product;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
        
        // Share recent products with dashboard view
        View::composer('dashboard', function ($view) {
            $recentProducts = Product::latest()->take(5)->get();
            $view->with('recentProducts', $recentProducts);
        });
    }
}
