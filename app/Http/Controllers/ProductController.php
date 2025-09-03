<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::query();
        
        // Apply search filter if provided
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        // Apply category filter if provided
        if ($category = $request->input('category')) {
            $query->where('category', $category);
        }
        
        // Apply sorting
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'name_asc':
                $query->orderBy('name', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('name', 'desc');
                break;
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        $products = $query->paginate(10);
        
        // Get stock statistics
        $stockStats = [
            'total' => Product::count(),
            'in_stock' => Product::where('status', 'in_stock')->count(),
            'low_stock' => Product::where('status', 'low_stock')->count(),
            'out_of_stock' => Product::where('status', 'out_of_stock')->count(),
        ];
        
        // Get chart data
        $chartData = $this->getChartData();
        
        return view('products.index', compact('products', 'stockStats', 'chartData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        
        Product::create($data);
        
        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        // If request expects JSON (AJAX), return JSON response
        if (request()->expectsJson()) {
            return response()->json($product);
        }
        
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $data['image'] = $request->file('image')->store('products', 'public');
        }
        
        $product->update($data);
        
        return redirect()->route('products.show', $product->id)
            ->with('success', 'Product updated successfully.')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete the image if it exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        
        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }
    
    /**
     * Get chart data for the products index page
     */
    private function getChartData()
    {
        // Most sold products (by quantity)
        $mostSold = Sale::select('products.name', DB::raw('SUM(sales.quantity_sold) as total_quantity'))
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->where('sales.status', 'completed')
            ->groupBy('products.name', 'products.id')
            ->orderBy('total_quantity', 'desc')
            ->limit(6)
            ->get();

        // Monthly sales trend (last 12 months)
        $monthlySales = [];
        $monthLabels = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $monthLabels[] = $date->format('M');
            
            $monthlyTotal = Sale::whereYear('sale_date', $date->year)
                ->whereMonth('sale_date', $date->month)
                ->where('status', 'completed')
                ->sum('final_amount');
                
            $monthlySales[] = round($monthlyTotal, 2);
        }

        // Category distribution
        $categoryData = Product::select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();

        // Stock status distribution
        $stockStatus = [
            'in_stock' => Product::where('status', 'in_stock')->count(),
            'low_stock' => Product::where('status', 'low_stock')->count(),
            'out_of_stock' => Product::where('status', 'out_of_stock')->count(),
        ];

        // Revenue by product (top 5)
        $revenueByProduct = Sale::select('products.name', DB::raw('SUM(sales.final_amount) as total_revenue'))
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->where('sales.status', 'completed')
            ->groupBy('products.name', 'products.id')
            ->orderBy('total_revenue', 'desc')
            ->limit(5)
            ->get();

        return [
            'mostSold' => [
                'labels' => $mostSold->pluck('name')->toArray(),
                'data' => $mostSold->pluck('total_quantity')->toArray()
            ],
            'monthlySales' => [
                'labels' => $monthLabels,
                'data' => $monthlySales
            ],
            'categoryDistribution' => [
                'labels' => $categoryData->pluck('category')->toArray(),
                'data' => $categoryData->pluck('count')->toArray()
            ],
            'stockStatus' => [
                'labels' => ['In Stock', 'Low Stock', 'Out of Stock'],
                'data' => [
                    $stockStatus['in_stock'],
                    $stockStatus['low_stock'],
                    $stockStatus['out_of_stock']
                ]
            ],
            'revenue' => [
                'labels' => $revenueByProduct->pluck('name')->toArray(),
                'data' => $revenueByProduct->pluck('total_revenue')->toArray()
            ]
        ];
    }
}
