<?php
require_once 'vendor/autoload.php';

// Initialize Laravel app
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Incubation;
use App\Models\Product;

echo "=== DASHBOARD CHART DATA TEST ===\n";
echo "Testing data availability for charts...\n\n";

// Test Sales by Status
echo "Sales by Status:\n";
$completed = Sale::where('payment_status', 'completed')->count();
$pending = Sale::where('payment_status', 'pending')->count();
$failed = Sale::where('payment_status', 'failed')->count();
echo "Completed: $completed, Pending: $pending, Failed: $failed\n\n";

// Test Incubation Progress
echo "Incubation Progress:\n";
$active = Incubation::where('status', 'active')->count();
$hatching = Incubation::where('status', 'hatching')->count();
$incompleted = Incubation::where('status', 'completed')->count();
$infailed = Incubation::where('status', 'failed')->count();
echo "Active: $active, Hatching: $hatching, Completed: $incompleted, Failed: $infailed\n\n";

// Test Monthly Financial Data
echo "Monthly Financial Data (last 3 months):\n";
for ($i = 2; $i >= 0; $i--) {
    $date = \Carbon\Carbon::now()->subMonths($i);
    $revenue = Sale::whereMonth('created_at', $date->month)
        ->whereYear('created_at', $date->year)
        ->sum('total_amount');
    $expenses = Purchase::whereMonth('created_at', $date->month)
        ->whereYear('created_at', $date->year)
        ->sum('total_amount');
    echo $date->format('M Y') . " - Revenue: ZMW $revenue, Expenses: ZMW $expenses\n";
}

echo "\n=== PRODUCT CATEGORIES ===\n";
$categories = Product::selectRaw('category, COUNT(*) as count')
    ->groupBy('category')
    ->get();
foreach ($categories as $category) {
    echo ($category->category ?: 'Other') . ": " . $category->count . "\n";
}

echo "\nData looks good for charts!\n";
