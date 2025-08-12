<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    private function createAuthenticatedUser()
    {
        $user = User::factory()->create();
        return $this->actingAs($user);
    }

    public function test_can_view_products_index()
    {
        $this->createAuthenticatedUser();
        
        $response = $this->get('/products');
        
        $response->assertStatus(200);
        $response->assertViewIs('products.index');
    }

    public function test_can_create_product()
    {
        $this->createAuthenticatedUser();
        
        $productData = [
            'name' => 'Test Product',
            'sku' => 'TEST001',
            'description' => 'Test description',
            'category' => 'crop',
            'price' => 25.99,
            'price_unit' => 'per kg',
            'quantity' => 100,
            'quantity_unit' => 'kg',
            'status' => 'in_stock'
        ];

        $response = $this->post('/products', $productData);
        
        $response->assertRedirect('/products');
        $response->assertSessionHas('success', 'Product created successfully.');
        
        $this->assertDatabaseHas('products', [
            'name' => 'Test Product',
            'sku' => 'TEST001'
        ]);
    }

    public function test_can_update_product()
    {
        $this->createAuthenticatedUser();
        
        $product = Product::factory()->create([
            'name' => 'Original Product',
            'price' => 10.00
        ]);

        $updateData = [
            'name' => 'Updated Product',
            'sku' => $product->sku,
            'description' => $product->description,
            'category' => $product->category,
            'price' => 15.00,
            'price_unit' => $product->price_unit,
            'quantity' => $product->quantity,
            'quantity_unit' => $product->quantity_unit,
            'status' => $product->status
        ];

        $response = $this->put("/products/{$product->id}", $updateData);
        
        $response->assertRedirect("/products/{$product->id}");
        $response->assertSessionHas('success', 'Product updated successfully.');
        
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Product',
            'price' => 15.00
        ]);
    }

    public function test_can_delete_product()
    {
        $this->createAuthenticatedUser();
        
        $product = Product::factory()->create();

        $response = $this->delete("/products/{$product->id}");
        
        $response->assertRedirect('/products');
        $response->assertSessionHas('success', 'Product deleted successfully.');
        
        $this->assertDatabaseMissing('products', [
            'id' => $product->id
        ]);
    }

    public function test_api_can_get_product()
    {
        $this->createAuthenticatedUser();
        
        $product = Product::factory()->create();

        $response = $this->get("/api/products/{$product->id}");
        
        $response->assertStatus(200);
        $response->assertJsonStructure([
            'product' => [
                'id',
                'name',
                'sku',
                'price',
                'category'
            ],
            'image_url'
        ]);
    }

    public function test_validation_errors_for_create()
    {
        $this->createAuthenticatedUser();
        
        $response = $this->post('/products', []);
        
        $response->assertSessionHasErrors([
            'name',
            'sku',
            'category',
            'price',
            'price_unit',
            'quantity',
            'quantity_unit',
            'status'
        ]);
    }
}
