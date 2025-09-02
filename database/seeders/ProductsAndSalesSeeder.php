<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;

class ProductsAndSalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Sale::truncate();
        Product::truncate();

        // Create products
        $products = [
            [
                'name' => 'Maize',
                'sku' => 'MAIZE001',
                'description' => 'Fresh maize from our organic farm',
                'category' => 'Crops',
                'price' => 25.00,
                'price_unit' => 'per kg',
                'quantity' => 500.00,
                'quantity_unit' => 'kg',
                'low_stock_threshold' => 50,
                'status' => 'in_stock',
                'harvested_date' => Carbon::now()->subDays(10),
                'expiry_date' => Carbon::now()->addDays(90),
                'location' => 'Warehouse A',
            ],
            [
                'name' => 'Tomatoes',
                'sku' => 'TOM001',
                'description' => 'Fresh red tomatoes',
                'category' => 'Crops',
                'price' => 15.00,
                'price_unit' => 'per kg',
                'quantity' => 200.00,
                'quantity_unit' => 'kg',
                'low_stock_threshold' => 30,
                'status' => 'in_stock',
                'harvested_date' => Carbon::now()->subDays(5),
                'expiry_date' => Carbon::now()->addDays(14),
                'location' => 'Cold Storage',
            ],
            [
                'name' => 'Fresh Milk',
                'sku' => 'MILK001',
                'description' => 'Fresh cow milk',
                'category' => 'Dairy',
                'price' => 12.00,
                'price_unit' => 'per litre',
                'quantity' => 150.00,
                'quantity_unit' => 'litres',
                'low_stock_threshold' => 20,
                'status' => 'in_stock',
                'harvested_date' => Carbon::now()->subDays(1),
                'expiry_date' => Carbon::now()->addDays(7),
                'location' => 'Dairy Section',
            ],
            [
                'name' => 'Chicken Eggs',
                'sku' => 'EGG001',
                'description' => 'Fresh chicken eggs',
                'category' => 'Poultry',
                'price' => 2.50,
                'price_unit' => 'per piece',
                'quantity' => 300.00,
                'quantity_unit' => 'pieces',
                'low_stock_threshold' => 50,
                'status' => 'in_stock',
                'harvested_date' => Carbon::now()->subDays(2),
                'expiry_date' => Carbon::now()->addDays(30),
                'location' => 'Poultry Section',
            ],
            [
                'name' => 'White Beans',
                'sku' => 'BEAN001',
                'description' => 'Organic white beans',
                'category' => 'Crops',
                'price' => 30.00,
                'price_unit' => 'per kg',
                'quantity' => 80.00,
                'quantity_unit' => 'kg',
                'low_stock_threshold' => 20,
                'status' => 'in_stock',
                'harvested_date' => Carbon::now()->subDays(20),
                'expiry_date' => Carbon::now()->addDays(180),
                'location' => 'Warehouse B',
            ],
            [
                'name' => 'Rice',
                'sku' => 'RICE001',
                'description' => 'Premium white rice',
                'category' => 'Crops',
                'price' => 28.00,
                'price_unit' => 'per kg',
                'quantity' => 120.00,
                'quantity_unit' => 'kg',
                'low_stock_threshold' => 25,
                'status' => 'in_stock',
                'harvested_date' => Carbon::now()->subDays(30),
                'expiry_date' => Carbon::now()->addDays(365),
                'location' => 'Warehouse A',
            ],
            [
                'name' => 'Cheese',
                'sku' => 'CHEESE001',
                'description' => 'Homemade cheese',
                'category' => 'Dairy',
                'price' => 45.00,
                'price_unit' => 'per kg',
                'quantity' => 25.00,
                'quantity_unit' => 'kg',
                'low_stock_threshold' => 5,
                'status' => 'low_stock',
                'harvested_date' => Carbon::now()->subDays(3),
                'expiry_date' => Carbon::now()->addDays(21),
                'location' => 'Dairy Section',
            ],
            [
                'name' => 'Chicken Meat',
                'sku' => 'CHICKEN001',
                'description' => 'Fresh chicken meat',
                'category' => 'Poultry',
                'price' => 55.00,
                'price_unit' => 'per kg',
                'quantity' => 0.00,
                'quantity_unit' => 'kg',
                'low_stock_threshold' => 10,
                'status' => 'out_of_stock',
                'harvested_date' => Carbon::now()->subDays(7),
                'expiry_date' => Carbon::now()->addDays(5),
                'location' => 'Poultry Section',
            ],
            [
                'name' => 'Beef',
                'sku' => 'BEEF001',
                'description' => 'Fresh beef cuts',
                'category' => 'Livestock',
                'price' => 85.00,
                'price_unit' => 'per kg',
                'quantity' => 40.00,
                'quantity_unit' => 'kg',
                'low_stock_threshold' => 15,
                'status' => 'in_stock',
                'harvested_date' => Carbon::now()->subDays(2),
                'expiry_date' => Carbon::now()->addDays(10),
                'location' => 'Meat Section',
            ],
            [
                'name' => 'Yogurt',
                'sku' => 'YOGURT001',
                'description' => 'Homemade yogurt',
                'category' => 'Dairy',
                'price' => 18.00,
                'price_unit' => 'per litre',
                'quantity' => 15.00,
                'quantity_unit' => 'litres',
                'low_stock_threshold' => 10,
                'status' => 'low_stock',
                'harvested_date' => Carbon::now()->subDays(1),
                'expiry_date' => Carbon::now()->addDays(14),
                'location' => 'Dairy Section',
            ],
        ];

        foreach ($products as $productData) {
            Product::create($productData);
        }

        // Generate sales data for the last 12 months
        $products = Product::all();
        $customers = [
            ['name' => 'John Banda', 'phone' => '+260977123456', 'email' => 'john@email.com'],
            ['name' => 'Mary Mwanza', 'phone' => '+260966789012', 'email' => 'mary@email.com'],
            ['name' => 'Peter Phiri', 'phone' => '+260955345678', 'email' => 'peter@email.com'],
            ['name' => 'Grace Tembo', 'phone' => '+260977890123', 'email' => 'grace@email.com'],
            ['name' => 'David Chanda', 'phone' => '+260966456789', 'email' => 'david@email.com'],
            ['name' => 'Susan Nyirenda', 'phone' => '+260955567890', 'email' => 'susan@email.com'],
            ['name' => 'James Sakala', 'phone' => '+260977234567', 'email' => 'james@email.com'],
            ['name' => 'Ruth Mulenga', 'phone' => '+260966678901', 'email' => 'ruth@email.com'],
        ];

        $paymentMethods = ['cash', 'mobile_money', 'bank_transfer'];
        $paymentStatuses = ['completed', 'completed', 'completed', 'pending']; // More completed than pending

        // Sales data to match chart expectations
        $salesData = [
            'Maize' => [450, 420, 380, 410, 390, 430, 470, 440, 400, 460, 420, 480],
            'Tomatoes' => [320, 310, 290, 340, 330, 350, 360, 340, 320, 370, 330, 380],
            'Fresh Milk' => [280, 270, 260, 290, 280, 300, 310, 290, 280, 320, 300, 330],
            'Chicken Eggs' => [250, 240, 230, 260, 250, 270, 280, 260, 250, 290, 270, 300],
            'White Beans' => [200, 190, 180, 210, 200, 220, 230, 210, 200, 240, 220, 250],
            'Rice' => [180, 170, 160, 190, 180, 200, 210, 190, 180, 220, 200, 230],
        ];

        // Generate monthly sales for the last 12 months
        $saleCounter = 1;
        for ($month = 11; $month >= 0; $month--) {
            $date = Carbon::now()->subMonths($month);
            
            foreach ($salesData as $productName => $monthlyCounts) {
                $product = $products->where('name', $productName)->first();
                if (!$product) continue;
                
                $salesCount = $monthlyCounts[11 - $month]; // Get the corresponding month's data
                
                // Generate multiple sales for this month
                $dailySales = round($salesCount / 30); // Distribute across the month
                
                for ($day = 1; $day <= min(30, $date->daysInMonth); $day++) {
                    if (rand(1, 3) == 1) continue; // Skip some days randomly
                    
                    $saleDate = $date->copy()->day($day);
                    $customer = $customers[array_rand($customers)];
                    
                    // Vary quantity sold
                    $baseQuantity = max(1, $dailySales + rand(-2, 3));
                    $quantitySold = $baseQuantity;
                    $unitPrice = $product->price;
                    $totalAmount = $quantitySold * $unitPrice;
                    $discountAmount = rand(0, 1) ? round($totalAmount * 0.05, 2) : 0; // 5% discount sometimes
                    $finalAmount = $totalAmount - $discountAmount;
                    
                    Sale::create([
                        'sale_number' => 'SALE' . str_pad($saleCounter, 6, '0', STR_PAD_LEFT),
                        'product_id' => $product->id,
                        'customer_name' => $customer['name'],
                        'customer_phone' => $customer['phone'],
                        'customer_email' => $customer['email'],
                        'quantity_sold' => $quantitySold,
                        'quantity_unit' => $product->quantity_unit,
                        'unit_price' => $unitPrice,
                        'total_amount' => $totalAmount,
                        'discount_amount' => $discountAmount,
                        'final_amount' => $finalAmount,
                        'payment_method' => $paymentMethods[array_rand($paymentMethods)],
                        'payment_status' => $paymentStatuses[array_rand($paymentStatuses)],
                        'sale_date' => $saleDate,
                        'status' => 'completed',
                        'notes' => rand(1, 5) == 1 ? 'Regular customer' : null,
                    ]);
                    
                    $saleCounter++;
                }
            }
        }

        $this->command->info('Products and Sales data seeded successfully!');
        $this->command->info('Created ' . Product::count() . ' products');
        $this->command->info('Created ' . Sale::count() . ' sales records');
    }
}