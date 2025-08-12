<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;

class UpdateStockStatus extends Command
{
    protected $signature = 'products:update-stock-status';
    protected $description = 'Update stock status for all products based on quantity thresholds';

    public function handle()
    {
        $this->info('Updating stock status for all products...');
        
        $products = Product::all();
        $updated = 0;
        
        foreach ($products as $product) {
            $oldStatus = $product->status;
            $product->updateStockStatus();
            
            if ($product->isDirty('status')) {
                $product->save();
                $updated++;
                $this->line("Updated {$product->name} (SKU: {$product->sku}) from '{$oldStatus}' to '{$product->status}' (Qty: {$product->quantity})");
            }
        }
        
        $this->info("Stock status update completed!");
        $this->info("Total products processed: {$products->count()}");
        $this->info("Products updated: {$updated}");
        
        // Show summary
        $lowStock = Product::where('status', 'low_stock')->count();
        $outOfStock = Product::where('status', 'out_of_stock')->count();
        $inStock = Product::where('status', 'in_stock')->count();
        
        $this->table(
            ['Status', 'Count'],
            [
                ['In Stock', $inStock],
                ['Low Stock (< 20)', $lowStock],
                ['Out of Stock (0)', $outOfStock],
            ]
        );
        
        return 0;
    }
}
