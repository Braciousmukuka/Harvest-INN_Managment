<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleRequest;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of sales.
     */
    public function index(Request $request)
    {
        $query = Sale::with('product');
        
        // Apply search filter
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('sale_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhereHas('product', function($productQuery) use ($search) {
                      $productQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }
        
        // Apply status filter
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }
        
        // Apply payment status filter
        if ($paymentStatus = $request->input('payment_status')) {
            $query->where('payment_status', $paymentStatus);
        }
        
        // Apply date filter
        if ($dateFrom = $request->input('date_from')) {
            $query->whereDate('sale_date', '>=', $dateFrom);
        }
        
        if ($dateTo = $request->input('date_to')) {
            $query->whereDate('sale_date', '<=', $dateTo);
        }
        
        // Apply sorting
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'amount_high':
                $query->orderBy('final_amount', 'desc');
                break;
            case 'amount_low':
                $query->orderBy('final_amount', 'asc');
                break;
            case 'customer_name':
                $query->orderBy('customer_name', 'asc');
                break;
            case 'newest':
            default:
                $query->latest();
                break;
        }
        
        $sales = $query->paginate(10);
        
        // Get sales statistics
        $salesStats = [
            'total_sales' => Sale::completed()->count(),
            'today_sales' => Sale::completed()->today()->count(),
            'total_revenue' => Sale::completed()->sum('final_amount'),
            'today_revenue' => Sale::completed()->today()->sum('final_amount'),
            'pending_sales' => Sale::where('status', 'pending')->count(),
            'completed_sales' => Sale::where('status', 'completed')->count(),
        ];
        
        return view('sales.index', compact('sales', 'salesStats'));
    }

    /**
     * Show the form for creating a new sale.
     */
    public function create()
    {
        $products = Product::where('status', '!=', 'out_of_stock')
                          ->orderBy('name')
                          ->get();
        
        return view('sales.create', compact('products'));
    }

    /**
     * Store a newly created sale.
     */
    public function store(SaleRequest $request)
    {
        $data = $request->validated();
        
        // Get product and check availability
        $product = Product::findOrFail($data['product_id']);
        
        if ($product->quantity < $data['quantity_sold']) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Insufficient stock. Available quantity: ' . $product->quantity . ' ' . $product->quantity_unit);
        }
        
        DB::transaction(function () use ($data, $product) {
            // Set quantity unit from product
            $data['quantity_unit'] = $product->quantity_unit;
            
            // Calculate amounts
            $data['total_amount'] = $data['quantity_sold'] * $data['unit_price'];
            $data['discount_amount'] = $data['discount_amount'] ?? 0;
            
            // Create sale
            $sale = Sale::create($data);
            
            // Update product quantity
            $product->decrement('quantity', $data['quantity_sold']);
            
            // Update product status based on new quantity
            $product->updateStockStatus();
            $product->save();
        });
        
        return redirect()->route('sales.index')
            ->with('success', 'Sale created successfully.')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
    }

    /**
     * Display the specified sale.
     */
    public function show(Sale $sale)
    {
        $sale->load('product');
        return view('sales.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified sale.
     */
    public function edit(Sale $sale)
    {
        $products = Product::orderBy('name')->get();
        $sale->load('product');
        
        return view('sales.edit', compact('sale', 'products'));
    }

    /**
     * Update the specified sale.
     */
    public function update(SaleRequest $request, Sale $sale)
    {
        $data = $request->validated();
        
        try {
            DB::transaction(function () use ($data, $sale) {
                $oldQuantity = $sale->quantity_sold;
                $oldProductId = $sale->product_id;
                
                // Restore old product quantity
                $oldProduct = Product::find($oldProductId);
                if ($oldProduct) {
                    $oldProduct->increment('quantity', $oldQuantity);
                    $oldProduct->updateStockStatus();
                    $oldProduct->save();
                }
                
                // Get new product and check availability
                $newProduct = Product::findOrFail($data['product_id']);
                
                if ($newProduct->quantity < $data['quantity_sold']) {
                    throw new \Exception('Insufficient stock for the selected product. Available: ' . $newProduct->quantity . ' ' . $newProduct->quantity_unit);
                }
                
                // Set quantity unit from new product
                $data['quantity_unit'] = $newProduct->quantity_unit;
                
                // Calculate amounts
                $data['total_amount'] = $data['quantity_sold'] * $data['unit_price'];
                $data['discount_amount'] = $data['discount_amount'] ?? 0;
                
                // Update sale
                $sale->update($data);
                
                // Update new product quantity
                $newProduct->decrement('quantity', $data['quantity_sold']);
                $newProduct->updateStockStatus();
                $newProduct->save();
            });
            
            return redirect()->route('sales.show', $sale)
                ->with('success', 'Sale updated successfully.')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating sale: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified sale.
     */
    public function destroy(Sale $sale)
    {
        try {
            DB::transaction(function () use ($sale) {
                // Restore product quantity
                $product = $sale->product;
                if ($product) {
                    $product->increment('quantity', $sale->quantity_sold);
                    $product->updateStockStatus();
                    $product->save();
                }
                
                $sale->delete();
            });
            
            return redirect()->route('sales.index')
                ->with('success', 'Sale deleted successfully and product quantity restored.')
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')
                ->with('error', 'Error deleting sale: ' . $e->getMessage())
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate');
        }
    }

    /**
     * Get product details for AJAX
     */
    public function getProductDetails(Product $product)
    {
        return response()->json([
            'product' => $product,
            'available_quantity' => $product->quantity,
            'unit_price' => $product->price,
            'quantity_unit' => $product->quantity_unit,
        ]);
    }
}
