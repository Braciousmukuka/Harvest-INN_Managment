<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;

class TestProductCrud extends Command
{
    protected $signature = 'test:product-crud';
    protected $description = 'Test Product CRUD operations';

    public function handle()
    {
        $this->info('Testing Product CRUD Operations...');
        
        // Test 1: Create a product
        $this->info('1. Testing product creation...');
        $createData = [
            'name' => 'Test Carrots',
            'sku' => 'CR001',
            'description' => 'Fresh organic carrots',
            'category' => 'crop',
            'price' => 12.50,
            'price_unit' => 'per kg',
            'quantity' => 75,
            'quantity_unit' => 'kg',
            'status' => 'in_stock'
        ];
        
        $product = Product::create($createData);
        $this->info("✓ Product created with ID: {$product->id}");
        
        // Test 2: Read the product
        $this->info('2. Testing product retrieval...');
        $retrievedProduct = Product::find($product->id);
        if ($retrievedProduct) {
            $this->info("✓ Product retrieved: {$retrievedProduct->name}");
        } else {
            $this->error("✗ Failed to retrieve product");
            return;
        }
        
        // Test 3: Update the product
        $this->info('3. Testing product update...');
        $updateData = [
            'price' => 15.00,
            'quantity' => 60,
            'status' => 'low_stock'
        ];
        
        $product->update($updateData);
        $product->refresh();
        $this->info("✓ Product updated - New price: {$product->price}, Status: {$product->status}");
        
        // Test 4: Delete the product
        $this->info('4. Testing product deletion...');
        $productId = $product->id;
        $product->delete();
        
        $deletedProduct = Product::find($productId);
        if (!$deletedProduct) {
            $this->info("✓ Product deleted successfully");
        } else {
            $this->error("✗ Failed to delete product");
        }
        
        // Test API endpoint
        $this->info('5. Testing API endpoint...');
        $testProduct = Product::first();
        if ($testProduct) {
            $controller = new \App\Http\Controllers\Api\ProductController();
            $response = $controller->getProduct($testProduct);
            $data = json_decode($response->getContent(), true);
            
            if (isset($data['product'])) {
                $this->info("✓ API endpoint working - Product: {$data['product']['name']}");
            } else {
                $this->error("✗ API endpoint not working properly");
            }
        } else {
            $this->info("ℹ No products available to test API endpoint");
        }
        
        $this->info('All tests completed!');
        $this->info('Current product count: ' . Product::count());
    }
}
