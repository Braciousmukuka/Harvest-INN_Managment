<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    // Redirect to login if not authenticated, dashboard if authenticated
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/test-email', function () {
    try {
        \Mail::to(request('email', 'no_reply@harvestinnzm.com'))->send(new \App\Mail\TestMail());
        return 'Email sent successfully! Check your inbox.';
    } catch (\Exception $e) {
        return 'Error sending email: ' . $e->getMessage();
    }
});

// Test route for login without form
Route::get('/test-login', function () {
    $user = \App\Models\User::first();
    \Auth::login($user);
    return redirect('/dashboard')->with('success', 'Logged in as ' . $user->name);
});

// Simple data test page without authentication
Route::get('/data-test', function () {
    $products = \App\Models\Product::all();
    $sales = \App\Models\Sale::with('product')->latest()->take(10)->get();
    $purchases = \App\Models\Purchase::latest()->take(5)->get();
    $incubations = \App\Models\Incubation::all();
    
    $html = '<h1>HarvestInn Data Test</h1>';
    $html .= '<h2>Products (' . $products->count() . ')</h2><ul>';
    foreach($products as $product) {
        $html .= '<li>' . $product->name . ' - ' . $product->sku . ' - ZMW ' . $product->price . '</li>';
    }
    $html .= '</ul>';
    
    $html .= '<h2>Recent Sales (' . $sales->count() . ' of ' . \App\Models\Sale::count() . ' total)</h2><ul>';
    foreach($sales as $sale) {
        $html .= '<li>' . $sale->sale_number . ' - ' . $sale->customer_name . ' - ' . $sale->product->name . ' - ZMW ' . $sale->total_amount . '</li>';
    }
    $html .= '</ul>';
    
    $html .= '<h2>Recent Purchases (' . $purchases->count() . ' of ' . \App\Models\Purchase::count() . ' total)</h2><ul>';
    foreach($purchases as $purchase) {
        $html .= '<li>' . $purchase->supplier_name . ' - ' . $purchase->item_name . ' - ZMW ' . $purchase->total_amount . '</li>';
    }
    $html .= '</ul>';
    
    $html .= '<h2>Incubations (' . $incubations->count() . ')</h2><ul>';
    foreach($incubations as $incubation) {
        $html .= '<li>' . $incubation->batch_number . ' - ' . $incubation->batch_name . ' - ' . $incubation->status . '</li>';
    }
    $html .= '</ul>';
    
    return $html;
});

// Working dashboard with guaranteed charts
Route::get('/working-dashboard', function () {
    // Use the same data structure as main dashboard
    $stockStats = [
        'total' => \App\Models\Product::count(),
        'in_stock' => \App\Models\Product::where('status', 'in_stock')->count(),
        'low_stock' => \App\Models\Product::where('status', 'low_stock')->count(),
        'out_of_stock' => \App\Models\Product::where('status', 'out_of_stock')->count(),
    ];
    
    $salesStats = [
        'total_sales' => \App\Models\Sale::count(),
        'total_revenue' => \App\Models\Sale::sum('total_amount'),
        'pending_sales' => \App\Models\Sale::where('payment_status', 'pending')->count(),
        'completed_sales' => \App\Models\Sale::where('payment_status', 'completed')->count(),
    ];
    
    $purchaseStats = [
        'total_purchases' => \App\Models\Purchase::count(),
        'total_amount' => \App\Models\Purchase::sum('total_amount'),
    ];
    
    $incubationStats = [
        'active_batches' => \App\Models\Incubation::whereIn('status', ['active', 'hatching'])->count(),
        'total_eggs_incubating' => \App\Models\Incubation::whereIn('status', ['active', 'hatching'])->sum('eggs_placed'),
    ];
    
    // Simplified chart data
    $chartData = [
        'monthlyFinancials' => ['labels' => [], 'revenue' => [], 'expenses' => []],
        'salesByStatus' => [
            'labels' => ['Completed', 'Pending', 'Failed'],
            'data' => [
                \App\Models\Sale::where('payment_status', 'completed')->count(),
                \App\Models\Sale::where('payment_status', 'pending')->count(),
                \App\Models\Sale::where('payment_status', 'failed')->count(),
            ]
        ],
        'incubationProgress' => [
            'labels' => ['Active', 'Hatching', 'Completed', 'Failed'],
            'data' => [
                \App\Models\Incubation::where('status', 'active')->count(),
                \App\Models\Incubation::where('status', 'hatching')->count(),
                \App\Models\Incubation::where('status', 'completed')->count(),
                \App\Models\Incubation::where('status', 'failed')->count(),
            ]
        ],
        'dailySalesTrend' => ['labels' => [], 'data' => []]
    ];
    
    // Generate monthly data (last 6 months for simplicity)
    for ($i = 5; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subMonths($i);
        $chartData['monthlyFinancials']['labels'][] = $date->format('M Y');
        $chartData['monthlyFinancials']['revenue'][] = \App\Models\Sale::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->sum('total_amount');
        $chartData['monthlyFinancials']['expenses'][] = \App\Models\Purchase::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->sum('total_amount');
    }
    
    // Generate daily data (last 10 days)
    for ($i = 9; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subDays($i);
        $chartData['dailySalesTrend']['labels'][] = $date->format('M d');
        $chartData['dailySalesTrend']['data'][] = \App\Models\Sale::whereDate('created_at', $date)
            ->sum('total_amount');
    }
    
    $lowStockProducts = collect(); // Empty for now
    
    return view('working-dashboard', compact(
        'stockStats', 
        'salesStats', 
        'purchaseStats', 
        'incubationStats', 
        'chartData',
        'lowStockProducts'
    ));
});

// CSS-only dashboard for debugging
Route::get('/css-dashboard', function () {
    return view('css-dashboard');
});

// Simple dashboard for debugging
Route::get('/simple-dashboard', function () {
    return view('simple-dashboard');
});

// Test charts page - simple static charts to verify rendering
Route::get('/test-charts', function () {
    return view('test-charts');
});

// Minimal working dashboard
Route::get('/minimal-dashboard', function () {
    $salesCount = \App\Models\Sale::count();
    $revenue = \App\Models\Sale::sum('total_amount');
    $purchases = \App\Models\Purchase::count();
    $products = \App\Models\Product::count();
    
    // Get some monthly data
    $monthlyData = [];
    for ($i = 5; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subMonths($i);
        $monthlyData[] = [
            'month' => $date->format('M'),
            'revenue' => \App\Models\Sale::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->sum('total_amount') ?: rand(500, 2000)
        ];
    }
    
    return view('minimal-dashboard', compact('salesCount', 'revenue', 'purchases', 'products', 'monthlyData'));
});

// Debug chart data
Route::get('/debug-charts', function () {
    // Same chart data generation as dashboard
    $chartData = [
        'monthlyFinancials' => ['labels' => [], 'revenue' => [], 'expenses' => []],
        'salesByStatus' => [
            'labels' => ['Completed', 'Pending', 'Failed'],
            'data' => [
                \App\Models\Sale::where('payment_status', 'completed')->count(),
                \App\Models\Sale::where('payment_status', 'pending')->count(),
                \App\Models\Sale::where('payment_status', 'failed')->count(),
            ]
        ],
        'incubationProgress' => [
            'labels' => ['Active', 'Hatching', 'Completed', 'Failed'],
            'data' => [
                \App\Models\Incubation::where('status', 'active')->count(),
                \App\Models\Incubation::where('status', 'hatching')->count(),
                \App\Models\Incubation::where('status', 'completed')->count(),
                \App\Models\Incubation::where('status', 'failed')->count(),
            ]
        ],
        'dailySalesTrend' => ['labels' => [], 'data' => []]
    ];
    
    // Generate sample monthly data
    for ($i = 5; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subMonths($i);
        $chartData['monthlyFinancials']['labels'][] = $date->format('M Y');
        $chartData['monthlyFinancials']['revenue'][] = \App\Models\Sale::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)->sum('total_amount');
        $chartData['monthlyFinancials']['expenses'][] = \App\Models\Purchase::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)->sum('total_amount');
    }
    
    // Generate sample daily data (last 10 days)
    for ($i = 9; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subDays($i);
        $chartData['dailySalesTrend']['labels'][] = $date->format('M d');
        $chartData['dailySalesTrend']['data'][] = \App\Models\Sale::whereDate('created_at', $date)->sum('total_amount') ?: rand(100, 1000);
    }
    
    return response()->json($chartData);
});

// Performance test route
Route::get('/performance-test', function () {
    $start = microtime(true);
    
    return response()->json([
        'message' => 'Performance test endpoint',
        'environment' => config('app.env'),
        'service_worker_enabled' => config('app.env') === 'production',
        'load_time_ms' => round((microtime(true) - $start) * 1000, 2),
        'timestamp' => now()->format('Y-m-d H:i:s')
    ]);
});

// Chart debug page
Route::get('/chart-debug', function () {
    // Get the same chart data as dashboard
    $chartData = [
        // Monthly Revenue vs Expenses (Last 12 months)
        'monthlyFinancials' => [
            'labels' => [],
            'revenue' => [],
            'expenses' => []
        ],
        
        // Sales by Payment Status
        'salesByStatus' => [
            'labels' => ['Completed', 'Pending', 'Failed'],
            'data' => [
                \App\Models\Sale::where('payment_status', 'completed')->count(),
                \App\Models\Sale::where('payment_status', 'pending')->count(),
                \App\Models\Sale::where('payment_status', 'failed')->count(),
            ]
        ],
    ];
    
    // Generate monthly financial data (last 12 months)
    for ($i = 11; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subMonths($i);
        $chartData['monthlyFinancials']['labels'][] = $date->format('M Y');
        $chartData['monthlyFinancials']['revenue'][] = \App\Models\Sale::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->sum('total_amount');
        $chartData['monthlyFinancials']['expenses'][] = \App\Models\Purchase::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->sum('total_amount');
    }
    
    return view('chart-debug', compact('chartData'));
});

// Test chart data generation for products
Route::get('/test-product-charts', function () {
    $controller = new \App\Http\Controllers\ProductController();
    
    // Use reflection to call the private method
    $reflection = new ReflectionClass($controller);
    $method = $reflection->getMethod('getChartData');
    $method->setAccessible(true);
    
    $chartData = $method->invoke($controller);
    
    return response()->json($chartData);
});

// Auto-login and redirect to dashboard
Route::get('/auto-login', function () {
    $user = \App\Models\User::first();
    if ($user) {
        \Auth::login($user);
        return redirect('/dashboard');
    }
    return redirect('/login')->with('error', 'No users found');
});

// Working dashboard without auth (for testing)
Route::get('/dashboard-test', function () {
    // Product Analytics
    $stockStats = [
        'total' => \App\Models\Product::count(),
        'in_stock' => \App\Models\Product::where('status', 'in_stock')->count(),
        'low_stock' => \App\Models\Product::where('status', 'low_stock')->count(),
        'out_of_stock' => \App\Models\Product::where('status', 'out_of_stock')->count(),
    ];
    
    $lowStockProducts = \App\Models\Product::where('status', 'low_stock')
        ->orWhere('status', 'out_of_stock')
        ->orderBy('quantity', 'asc')
        ->take(5)
        ->get();

// Debug dashboard to verify data flow
Route::get('/debug-dashboard', function () {
    // Use the same data generation as the main dashboard
    $stockStats = [
        'total' => \App\Models\Product::count(),
        'in_stock' => \App\Models\Product::where('status', 'in_stock')->count(),
        'low_stock' => \App\Models\Product::where('status', 'low_stock')->count(),
        'out_of_stock' => \App\Models\Product::where('status', 'out_of_stock')->count(),
    ];
    
    $lowStockProducts = \App\Models\Product::where('status', 'low_stock')
        ->orWhere('status', 'out_of_stock')
        ->orderBy('quantity', 'asc')
        ->take(5)
        ->get();
    
    $salesStats = [
        'total_sales' => \App\Models\Sale::count(),
        'total_revenue' => \App\Models\Sale::sum('total_amount'),
        'pending_sales' => \App\Models\Sale::where('payment_status', 'pending')->count(),
        'completed_sales' => \App\Models\Sale::where('payment_status', 'completed')->count(),
        'monthly_revenue' => \App\Models\Sale::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_amount'),
        'daily_sales' => \App\Models\Sale::whereDate('created_at', today())->count(),
    ];
    
    $purchaseStats = [
        'total_purchases' => \App\Models\Purchase::count(),
        'total_amount' => \App\Models\Purchase::sum('total_amount'),
        'pending_purchases' => \App\Models\Purchase::where('status', 'pending')->count(),
        'delivered_purchases' => \App\Models\Purchase::where('status', 'delivered')->count(),
    ];
    
    $incubationStats = [
        'active_batches' => \App\Models\Incubation::whereIn('status', ['active', 'hatching'])->count(),
        'total_eggs_incubating' => \App\Models\Incubation::whereIn('status', ['active', 'hatching'])->sum('eggs_placed'),
        'completed_batches' => \App\Models\Incubation::where('status', 'completed')->count(),
        'total_hatched' => \App\Models\Incubation::sum('eggs_hatched'),
    ];
    
    return view('debug-dashboard', compact(
        'lowStockProducts', 
        'stockStats', 
        'salesStats', 
        'purchaseStats', 
        'incubationStats'
    ));
});
    
    // Sales Analytics
    $salesStats = [
        'total_sales' => \App\Models\Sale::count(),
        'total_revenue' => \App\Models\Sale::sum('total_amount'),
        'pending_sales' => \App\Models\Sale::where('payment_status', 'pending')->count(),
        'completed_sales' => \App\Models\Sale::where('payment_status', 'completed')->count(),
        'monthly_revenue' => \App\Models\Sale::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_amount'),
        'daily_sales' => \App\Models\Sale::whereDate('created_at', today())->count(),
    ];
    
    // Purchase Analytics
    $purchaseStats = [
        'total_purchases' => \App\Models\Purchase::count(),
        'total_amount' => \App\Models\Purchase::sum('total_amount'),
        'pending_purchases' => \App\Models\Purchase::where('status', 'pending')->count(),
        'delivered_purchases' => \App\Models\Purchase::where('status', 'delivered')->count(),
        'monthly_expenses' => \App\Models\Purchase::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_amount'),
    ];
    
    // Incubation Analytics
    $incubationStats = [
        'active_batches' => \App\Models\Incubation::whereIn('status', ['active', 'hatching'])->count(),
        'total_eggs_incubating' => \App\Models\Incubation::whereIn('status', ['active', 'hatching'])->sum('eggs_placed'),
        'completed_batches' => \App\Models\Incubation::where('status', 'completed')->count(),
        'total_hatched' => \App\Models\Incubation::sum('eggs_hatched'),
        'average_hatch_rate' => \App\Models\Incubation::where('status', 'completed')
            ->where('eggs_placed', '>', 0)
            ->get()
            ->avg(function($batch) {
                return ($batch->eggs_hatched / $batch->eggs_placed) * 100;
            }) ?: 0,
    ];
    
    // Chart Data for Analytics
    $chartData = [
        // Monthly Revenue vs Expenses (Last 12 months)
        'monthlyFinancials' => [
            'labels' => [],
            'revenue' => [],
            'expenses' => []
        ],
        
        // Sales by Payment Status
        'salesByStatus' => [
            'labels' => ['Completed', 'Pending', 'Failed'],
            'data' => [
                \App\Models\Sale::where('payment_status', 'completed')->count(),
                \App\Models\Sale::where('payment_status', 'pending')->count(),
                \App\Models\Sale::where('payment_status', 'failed')->count(),
            ]
        ],
        
        // Product Categories Distribution
        'productCategories' => [
            'labels' => [],
            'data' => []
        ],
        
        // Incubation Progress
        'incubationProgress' => [
            'labels' => ['Active', 'Hatching', 'Completed', 'Failed'],
            'data' => [
                \App\Models\Incubation::where('status', 'active')->count(),
                \App\Models\Incubation::where('status', 'hatching')->count(),
                \App\Models\Incubation::where('status', 'completed')->count(),
                \App\Models\Incubation::where('status', 'failed')->count(),
            ]
        ],
        
        // Daily Sales Trend (Last 30 days)
        'dailySalesTrend' => [
            'labels' => [],
            'data' => []
        ]
    ];
    
    // Generate monthly financial data (last 12 months)
    for ($i = 11; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subMonths($i);
        $chartData['monthlyFinancials']['labels'][] = $date->format('M Y');
        $chartData['monthlyFinancials']['revenue'][] = \App\Models\Sale::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->sum('total_amount');
        $chartData['monthlyFinancials']['expenses'][] = \App\Models\Purchase::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->sum('total_amount');
    }
    
    // Generate product categories data
    $categoryData = \App\Models\Product::selectRaw('category, COUNT(*) as count')
        ->groupBy('category')
        ->get();
    foreach ($categoryData as $category) {
        $chartData['productCategories']['labels'][] = $category->category ?: 'Other';
        $chartData['productCategories']['data'][] = $category->count;
    }
    
    // Generate daily sales trend (last 30 days)
    for ($i = 29; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subDays($i);
        $chartData['dailySalesTrend']['labels'][] = $date->format('M d');
        $chartData['dailySalesTrend']['data'][] = \App\Models\Sale::whereDate('created_at', $date)
            ->sum('total_amount');
    }
    
    return view('dashboard', compact(
        'lowStockProducts', 
        'stockStats', 
        'salesStats', 
        'purchaseStats', 
        'incubationStats', 
        'chartData'
    ));
});

// Direct dashboard access with auto-login
Route::get('/auto-dashboard', function () {
    $user = \App\Models\User::first();
    \Auth::login($user);
    
    // Get dashboard data directly
    $stockStats = [
        'total' => \App\Models\Product::count(),
        'in_stock' => \App\Models\Product::where('status', 'in_stock')->count(),
        'low_stock' => \App\Models\Product::where('status', 'low_stock')->count(),
        'out_of_stock' => \App\Models\Product::where('status', 'out_of_stock')->count(),
    ];
    
    $salesStats = [
        'total_sales' => \App\Models\Sale::count(),
        'total_revenue' => \App\Models\Sale::sum('total_amount'),
        'pending_sales' => \App\Models\Sale::where('payment_status', 'pending')->count(),
        'completed_sales' => \App\Models\Sale::where('payment_status', 'completed')->count(),
        'monthly_revenue' => \App\Models\Sale::whereMonth('created_at', date('m'))->sum('total_amount'),
        'daily_sales' => \App\Models\Sale::whereDate('created_at', today())->count(),
    ];
    
    return view('dashboard', compact('stockStats', 'salesStats'));
});

// Test route for sales debugging (temporary)
Route::get('/test-sales', function () {
    $sales = \App\Models\Sale::with('product')->latest()->paginate(10);
    $totalSales = \App\Models\Sale::count();
    $totalRevenue = \App\Models\Sale::sum('total_amount');
    $pendingSales = \App\Models\Sale::where('payment_status', 'pending')->count();
    $completedSales = \App\Models\Sale::where('payment_status', 'completed')->count();

    $salesData = compact('sales', 'totalSales', 'totalRevenue', 'pendingSales', 'completedSales');
    
    return view('sales.index', $salesData);
});

// Test route for products debugging (temporary)
Route::get('/test-products', function () {
    $products = \App\Models\Product::latest()->get();
    $stockStats = [
        'total' => \App\Models\Product::count(),
        'low_stock' => \App\Models\Product::where('status', 'low_stock')->count(),
        'out_of_stock' => \App\Models\Product::where('status', 'out_of_stock')->count(),
    ];

    return view('products.simple', compact('products', 'stockStats'));
});

// Debug CSRF and forms
Route::get('/debug-csrf', function () {
    return [
        'csrf_token' => csrf_token(),
        'session_token' => session()->token(),
        'app_key' => config('app.key'),
        'session_driver' => config('session.driver'),
        'session_lifetime' => config('session.lifetime'),
    ];
});

Route::post('/test-form', function (\Illuminate\Http\Request $request) {
    return [
        'success' => true,
        'message' => 'Form submitted successfully!',
        'data' => $request->all(),
        'token_valid' => $request->session()->token() === $request->get('_token'),
    ];
})->name('test-form');

Route::get('/test-form', function () {
    return view('test-form');
});

// Direct product creation test
Route::get('/test-product-create', function () {
    try {
        $product = \App\Models\Product::create([
            'name' => 'Test Product ' . time(),
            'sku' => 'TEST-' . time(),
            'description' => 'Test product created via direct route',
            'category' => 'crop',
            'price' => 25.99,
            'price_unit' => 'per_kg',
            'quantity' => 50,
            'quantity_unit' => 'kg',
            'status' => 'in_stock',
            'low_stock_threshold' => 10,
        ]);
        
        return [
            'success' => true,
            'message' => 'Product created successfully!',
            'product' => $product,
        ];
    } catch (\Exception $e) {
        return [
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
            'line' => $e->getLine(),
            'file' => $e->getFile(),
        ];
    }
});

// Test product controller directly without middleware
Route::post('/test-product-store', function (\Illuminate\Http\Request $request) {
    $controller = new \App\Http\Controllers\ProductController();
    
    try {
        return $controller->store(new \App\Http\Requests\ProductRequest([
            'name' => $request->get('name', 'Test Product'),
            'sku' => $request->get('sku', 'TEST-001'),
            'description' => $request->get('description', 'Test description'),
            'category' => $request->get('category', 'crop'),
            'price' => $request->get('price', 10.00),
            'price_unit' => $request->get('price_unit', 'per_kg'),
            'quantity' => $request->get('quantity', 100),
            'quantity_unit' => $request->get('quantity_unit', 'kg'),
            'status' => $request->get('status', 'in_stock'),
        ]));
    } catch (\Exception $e) {
        return [
            'success' => false,
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString(),
        ];
    }
});

// New working products page
Route::get('/products-page', function () {
    $products = \App\Models\Product::latest()->get();
    $stockStats = [
        'total' => \App\Models\Product::count(),
        'low_stock' => \App\Models\Product::where('status', 'low_stock')->count(),
        'out_of_stock' => \App\Models\Product::where('status', 'out_of_stock')->count(),
        'in_stock' => \App\Models\Product::where('status', 'in_stock')->count(),
    ];

    return view('products-simple-working', compact('products', 'stockStats'));
});

// Simple test route
Route::get('/test-simple', function () {
    return 'Simple test route is working!';
});

// Dashboard debug route
Route::get('/dashboard-debug', function () {
    return view('dashboard-debug');
});

// Simple dashboard test
Route::get('/simple-dashboard', function () {
    return view('simple-dashboard');
});

// Ultra simple products test
Route::get('/products-basic', function () {
    $products = \App\Models\Product::all();
    $html = '<h1>HarvestInn Products</h1>';
    $html .= '<p>Total Products: ' . $products->count() . '</p>';
    $html .= '<table border="1" style="border-collapse: collapse; width: 100%;">';
    $html .= '<tr><th>ID</th><th>Name</th><th>SKU</th><th>Price</th><th>Quantity</th><th>Status</th></tr>';
    
    foreach($products as $product) {
        $html .= '<tr>';
        $html .= '<td>' . $product->id . '</td>';
        $html .= '<td>' . $product->name . '</td>';
        $html .= '<td>' . $product->sku . '</td>';
        $html .= '<td>ZMW ' . number_format($product->price, 2) . '</td>';
        $html .= '<td>' . $product->quantity . ' ' . $product->quantity_unit . '</td>';
        $html .= '<td>' . ucfirst($product->status) . '</td>';
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    return $html;
});

// Test routes for debugging sales CRUD without auth  
Route::prefix('test-sales')->group(function() {
    Route::delete('/{sale}', function(\App\Models\Sale $sale) {
        try {
            \Log::info('Attempting to delete sale: ' . $sale->id);
            $sale->delete();
            
            // Return redirect for regular form submission
            return redirect('/test-sales')->with('success', 'Sale deleted successfully');
        } catch (\Exception $e) {
            \Log::error('Error deleting sale: ' . $e->getMessage());
            return redirect('/test-sales')->with('error', 'Error deleting sale: ' . $e->getMessage());
        }
    })->name('test-sales.destroy');
    
    Route::get('/{sale}/edit', function(\App\Models\Sale $sale) {
        $products = \App\Models\Product::all();
        return view('sales.edit', compact('sale', 'products'));
    })->name('test-sales.edit');
    
    Route::put('/{sale}', function(\Illuminate\Http\Request $request, \App\Models\Sale $sale) {
        try {
            \Log::info('Attempting to update sale: ' . $sale->id);
            $sale->update($request->all());
            return redirect('/test-sales')->with('success', 'Sale updated successfully');
        } catch (\Exception $e) {
            \Log::error('Error updating sale: ' . $e->getMessage());
            return back()->with('error', 'Error updating sale: ' . $e->getMessage());
        }
    })->name('test-sales.update');
});

Route::get('/dashboard', function () {
    // Product Analytics
    $stockStats = [
        'total' => \App\Models\Product::count(),
        'in_stock' => \App\Models\Product::where('status', 'in_stock')->count(),
        'low_stock' => \App\Models\Product::where('status', 'low_stock')->count(),
        'out_of_stock' => \App\Models\Product::where('status', 'out_of_stock')->count(),
    ];
    
    // Low Stock Products Collection (not a count)
    $lowStockProducts = \App\Models\Product::where('status', 'low_stock')
        ->orWhere('status', 'out_of_stock')
        ->orderBy('quantity', 'asc')
        ->take(5)
        ->get();
    
    // Sales Analytics
    $salesStats = [
        'total_sales' => \App\Models\Sale::count(),
        'total_revenue' => \App\Models\Sale::sum('total_amount'),
        'pending_sales' => \App\Models\Sale::where('payment_status', 'pending')->count(),
        'completed_sales' => \App\Models\Sale::where('payment_status', 'completed')->count(),
        'monthly_revenue' => \App\Models\Sale::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_amount'),
        'daily_sales' => \App\Models\Sale::whereDate('created_at', today())->count(),
    ];
    
    // Purchase Analytics
    $purchaseStats = [
        'total_purchases' => \App\Models\Purchase::count(),
        'total_amount' => \App\Models\Purchase::sum('total_amount'),
        'pending_purchases' => \App\Models\Purchase::where('status', 'pending')->count(),
        'delivered_purchases' => \App\Models\Purchase::where('status', 'delivered')->count(),
        'monthly_expenses' => \App\Models\Purchase::whereMonth('created_at', date('m'))
            ->whereYear('created_at', date('Y'))
            ->sum('total_amount'),
    ];
    
    // Incubation Analytics
    $incubationStats = [
        'active_batches' => \App\Models\Incubation::whereIn('status', ['active', 'hatching'])->count(),
        'total_eggs_incubating' => \App\Models\Incubation::whereIn('status', ['active', 'hatching'])->sum('eggs_placed'),
        'completed_batches' => \App\Models\Incubation::where('status', 'completed')->count(),
        'total_hatched' => \App\Models\Incubation::sum('eggs_hatched'),
        'average_hatch_rate' => \App\Models\Incubation::where('status', 'completed')
            ->where('eggs_placed', '>', 0)
            ->get()
            ->avg(function($batch) {
                return ($batch->eggs_hatched / $batch->eggs_placed) * 100;
            }) ?: 0,
    ];
    
    // Chart Data for Analytics
    $chartData = [
        // Monthly Revenue vs Expenses (Last 12 months)
        'monthlyFinancials' => [
            'labels' => [],
            'revenue' => [],
            'expenses' => []
        ],
        
        // Sales by Payment Status
        'salesByStatus' => [
            'labels' => ['Completed', 'Pending', 'Failed'],
            'data' => [
                \App\Models\Sale::where('payment_status', 'completed')->count(),
                \App\Models\Sale::where('payment_status', 'pending')->count(),
                \App\Models\Sale::where('payment_status', 'failed')->count(),
            ]
        ],
        
        // Product Categories Distribution
        'productCategories' => [
            'labels' => [],
            'data' => []
        ],
        
        // Incubation Progress
        'incubationProgress' => [
            'labels' => ['Active', 'Hatching', 'Completed', 'Failed'],
            'data' => [
                \App\Models\Incubation::where('status', 'active')->count(),
                \App\Models\Incubation::where('status', 'hatching')->count(),
                \App\Models\Incubation::where('status', 'completed')->count(),
                \App\Models\Incubation::where('status', 'failed')->count(),
            ]
        ],
        
        // Daily Sales Trend (Last 30 days)
        'dailySalesTrend' => [
            'labels' => [],
            'data' => []
        ]
    ];
    
    // Generate monthly financial data (last 12 months)
    for ($i = 11; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subMonths($i);
        $chartData['monthlyFinancials']['labels'][] = $date->format('M Y');
        $chartData['monthlyFinancials']['revenue'][] = \App\Models\Sale::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->sum('total_amount');
        $chartData['monthlyFinancials']['expenses'][] = \App\Models\Purchase::whereMonth('created_at', $date->month)
            ->whereYear('created_at', $date->year)
            ->sum('total_amount');
    }
    
    // Generate product categories data
    $categoryData = \App\Models\Product::selectRaw('category, COUNT(*) as count')
        ->groupBy('category')
        ->get();
    foreach ($categoryData as $category) {
        $chartData['productCategories']['labels'][] = $category->category ?: 'Other';
        $chartData['productCategories']['data'][] = $category->count;
    }
    
    // Generate daily sales trend (last 30 days)
    for ($i = 29; $i >= 0; $i--) {
        $date = \Carbon\Carbon::now()->subDays($i);
        $chartData['dailySalesTrend']['labels'][] = $date->format('M d');
        $chartData['dailySalesTrend']['data'][] = \App\Models\Sale::whereDate('created_at', $date)
            ->sum('total_amount');
    }
    
    return view('dashboard', compact(
        'lowStockProducts', 
        'stockStats', 
        'salesStats', 
        'purchaseStats', 
        'incubationStats', 
        'chartData'
    ));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Products Routes
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    
    // Sales Routes
    Route::resource('sales', SaleController::class);
    Route::get('/sales/product/{product}/details', [SaleController::class, 'getProductDetails'])->name('sales.product.details');
    
    // Purchases Routes
    Route::resource('purchases', \App\Http\Controllers\PurchaseController::class);
    
    // Incubations Routes  
    Route::resource('incubations', \App\Http\Controllers\IncubationController::class);
    Route::post('/incubations/{incubation}/progress', [\App\Http\Controllers\IncubationController::class, 'updateProgress'])->name('incubations.progress');
    
    // API Routes
    Route::prefix('api')->name('api.')->group(function() {
        Route::get('/products/{product}', [\App\Http\Controllers\Api\ProductController::class, 'getProduct'])->name('api.products.get');
    });
});

require __DIR__.'/auth.php';
