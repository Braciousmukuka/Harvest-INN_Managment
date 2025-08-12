<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class LowStockFunctionalityTest extends TestCase
{
    use RefreshDatabase;

    private function createAuthenticatedUser()
    {
        $user = User::factory()->create();
        return $this->actingAs($user);
    }

    public function test_products_automatically_set_to_low_stock_when_quantity_below_20()
    {
        $product = Product::factory()->create([
            'quantity' => 15,
            'status' => 'in_stock'
        ]);

        // The model should automatically set status to low_stock
        $this->assertEquals('low_stock', $product->fresh()->status);
    }

    public function test_products_automatically_set_to_out_of_stock_when_quantity_is_zero()
    {
        $product = Product::factory()->create([
            'quantity' => 0,
            'status' => 'in_stock'
        ]);

        // The model should automatically set status to out_of_stock
        $this->assertEquals('out_of_stock', $product->fresh()->status);
    }

    public function test_products_automatically_set_to_in_stock_when_quantity_above_20()
    {
        $product = Product::factory()->create([
            'quantity' => 25,
            'status' => 'low_stock'
        ]);

        // The model should automatically set status to in_stock
        $this->assertEquals('in_stock', $product->fresh()->status);
    }

    public function test_updating_quantity_automatically_updates_status()
    {
        $product = Product::factory()->create([
            'quantity' => 50,
            'status' => 'in_stock'
        ]);

        // Update quantity to below 20
        $product->update(['quantity' => 10]);
        $this->assertEquals('low_stock', $product->fresh()->status);

        // Update quantity to 0
        $product->update(['quantity' => 0]);
        $this->assertEquals('out_of_stock', $product->fresh()->status);

        // Update quantity back to above 20
        $product->update(['quantity' => 30]);
        $this->assertEquals('in_stock', $product->fresh()->status);
    }

    public function test_is_low_stock_method_works_correctly()
    {
        $lowStockProduct = Product::factory()->create(['quantity' => 15]);
        $inStockProduct = Product::factory()->create(['quantity' => 25]);
        $outOfStockProduct = Product::factory()->create(['quantity' => 0]);

        $this->assertTrue($lowStockProduct->isLowStock());
        $this->assertFalse($inStockProduct->isLowStock());
        $this->assertFalse($outOfStockProduct->isLowStock());
    }

    public function test_is_out_of_stock_method_works_correctly()
    {
        $lowStockProduct = Product::factory()->create(['quantity' => 15]);
        $inStockProduct = Product::factory()->create(['quantity' => 25]);
        $outOfStockProduct = Product::factory()->create(['quantity' => 0]);

        $this->assertFalse($lowStockProduct->isOutOfStock());
        $this->assertFalse($inStockProduct->isOutOfStock());
        $this->assertTrue($outOfStockProduct->isOutOfStock());
    }

    public function test_stock_status_text_method_works_correctly()
    {
        $lowStockProduct = Product::factory()->create(['quantity' => 15]);
        $inStockProduct = Product::factory()->create(['quantity' => 25]);
        $outOfStockProduct = Product::factory()->create(['quantity' => 0]);

        $this->assertEquals('Low Stock', $lowStockProduct->getStockStatusText());
        $this->assertEquals('In Stock', $inStockProduct->getStockStatusText());
        $this->assertEquals('Out of Stock', $outOfStockProduct->getStockStatusText());
    }

    public function test_dashboard_shows_low_stock_alerts()
    {
        $this->createAuthenticatedUser();

        // Create some products with different stock levels
        Product::factory()->create(['name' => 'Low Stock Product', 'quantity' => 5]);
        Product::factory()->create(['name' => 'Out of Stock Product', 'quantity' => 0]);
        Product::factory()->create(['name' => 'In Stock Product', 'quantity' => 50]);

        $response = $this->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Stock Alert');
        $response->assertSee('Low Stock Product');
        $response->assertSee('Out of Stock Product');
    }

    public function test_products_index_shows_correct_stock_stats()
    {
        $this->createAuthenticatedUser();

        // Create products with different stock levels
        Product::factory()->create(['quantity' => 5]);  // low stock
        Product::factory()->create(['quantity' => 0]);  // out of stock
        Product::factory()->create(['quantity' => 50]); // in stock
        Product::factory()->create(['quantity' => 30]); // in stock

        $response = $this->get('/products');

        $response->assertStatus(200);
        // Should show 2 in stock, 1 low stock, 1 out of stock
        $response->assertSee('In Stock');
        $response->assertSee('Low Stock');
        $response->assertSee('Out of Stock');
    }
}
