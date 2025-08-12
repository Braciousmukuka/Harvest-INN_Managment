<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Incubation;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportExcelData extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'import:excel {file=Harvest-Inn Farm Mgt.xlsx}';

    /**
     * The console command description.
     */
    protected $description = 'Import data from Excel file into database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filename = $this->argument('file');
        $filepath = base_path($filename);
        
        if (!file_exists($filepath)) {
            $this->error("File not found: {$filepath}");
            return 1;
        }
        
        $this->info("Starting import from: {$filename}");
        
        try {
            // Load the Excel file
            $spreadsheet = IOFactory::load($filepath);
            $worksheetNames = $spreadsheet->getSheetNames();
            
            $this->info("Found worksheets: " . implode(', ', $worksheetNames));
            
            // Process each worksheet
            foreach ($worksheetNames as $sheetName) {
                $this->info("Processing worksheet: {$sheetName}");
                $worksheet = $spreadsheet->getSheetByName($sheetName);
                $data = $worksheet->toArray();
                
                // Skip empty sheets
                if (empty($data) || count($data) <= 1) {
                    $this->warn("Skipping empty sheet: {$sheetName}");
                    continue;
                }
                
                $this->processSheet($sheetName, $data);
            }
            
            $this->info("Import completed successfully!");
            
        } catch (\Exception $e) {
            $this->error("Import failed: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    private function processSheet($sheetName, $data)
    {
        // Get headers from first row
        $headers = array_map('trim', $data[0]);
        $headers = array_map('strtolower', $headers);
        
        $this->info("Headers: " . implode(', ', $headers));
        
        // Remove header row
        array_shift($data);
        
        // Determine sheet type based on name or headers
        $sheetType = $this->determineSheetType($sheetName, $headers);
        
        $this->info("Detected sheet type: {$sheetType}");
        
        $imported = 0;
        $errors = 0;
        
        foreach ($data as $rowIndex => $row) {
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }
            
            try {
                $rowData = array_combine($headers, $row);
                $this->importRow($sheetType, $rowData, $rowIndex + 2); // +2 because we removed header and arrays are 0-indexed
                $imported++;
            } catch (\Exception $e) {
                $this->warn("Error importing row " . ($rowIndex + 2) . ": " . $e->getMessage());
                $errors++;
            }
        }
        
        $this->info("Sheet {$sheetName}: Imported {$imported} records, {$errors} errors");
    }
    
    private function determineSheetType($sheetName, $headers)
    {
        $sheetName = strtolower($sheetName);
        
        // Check sheet name patterns
        if (str_contains($sheetName, 'product') || str_contains($sheetName, 'inventory')) {
            return 'products';
        }
        if (str_contains($sheetName, 'sale') || str_contains($sheetName, 'revenue')) {
            return 'sales';
        }
        if (str_contains($sheetName, 'purchase') || str_contains($sheetName, 'expense')) {
            return 'purchases';
        }
        if (str_contains($sheetName, 'incubat') || str_contains($sheetName, 'egg') || str_contains($sheetName, 'hatch')) {
            return 'incubations';
        }
        if (str_contains($sheetName, 'user') || str_contains($sheetName, 'staff')) {
            return 'users';
        }
        
        // Check headers to determine type
        if (in_array('product_name', $headers) || in_array('name', $headers) && in_array('price', $headers)) {
            return 'products';
        }
        if (in_array('customer_name', $headers) || in_array('customer', $headers)) {
            return 'sales';
        }
        if (in_array('supplier_name', $headers) || in_array('supplier', $headers)) {
            return 'purchases';
        }
        if (in_array('batch_number', $headers) || in_array('eggs_count', $headers)) {
            return 'incubations';
        }
        if (in_array('email', $headers) || in_array('username', $headers)) {
            return 'users';
        }
        
        // Default fallback
        return 'general';
    }
    
    private function importRow($type, $data, $rowNumber)
    {
        switch ($type) {
            case 'products':
                $this->importProduct($data);
                break;
            case 'sales':
                $this->importSale($data);
                break;
            case 'purchases':
                $this->importPurchase($data);
                break;
            case 'incubations':
                $this->importIncubation($data);
                break;
            case 'users':
                $this->importUser($data);
                break;
            default:
                $this->warn("Unknown sheet type: {$type} for row {$rowNumber}");
        }
    }
    
    private function importProduct($data)
    {
        $name = $data['name'] ?? $data['product_name'] ?? $data['product'] ?? null;
        $price = $data['price'] ?? $data['unit_price'] ?? 0;
        $stock = $data['stock'] ?? $data['quantity'] ?? $data['stock_quantity'] ?? 0;
        $description = $data['description'] ?? $data['details'] ?? '';
        $category = $data['category'] ?? $data['type'] ?? 'General';
        
        if (!$name) {
            throw new \Exception("Product name is required");
        }
        
        Product::updateOrCreate(
            ['name' => $name],
            [
                'price' => is_numeric($price) ? (float)$price : 0,
                'stock_quantity' => is_numeric($stock) ? (int)$stock : 0,
                'description' => $description,
                'category' => $category,
            ]
        );
    }
    
    private function importSale($data)
    {
        $customerName = $data['customer_name'] ?? $data['customer'] ?? 'Walk-in Customer';
        $productName = $data['product_name'] ?? $data['product'] ?? null;
        $quantity = $data['quantity'] ?? $data['qty'] ?? 1;
        $price = $data['price'] ?? $data['unit_price'] ?? $data['total_price'] ?? 0;
        $saleDate = $data['date'] ?? $data['sale_date'] ?? now();
        
        if (!$productName) {
            throw new \Exception("Product name is required for sale");
        }
        
        // Find or create product
        $product = Product::firstOrCreate(
            ['name' => $productName],
            ['price' => is_numeric($price) ? (float)$price : 0, 'stock_quantity' => 0]
        );
        
        Sale::create([
            'product_id' => $product->id,
            'customer_name' => $customerName,
            'quantity' => is_numeric($quantity) ? (int)$quantity : 1,
            'price' => is_numeric($price) ? (float)$price : $product->price,
            'total_price' => is_numeric($price) ? (float)$price * (int)$quantity : $product->price * (int)$quantity,
            'sale_date' => $saleDate,
            'customer_address' => $data['address'] ?? $data['customer_address'] ?? '',
        ]);
    }
    
    private function importPurchase($data)
    {
        $supplierName = $data['supplier_name'] ?? $data['supplier'] ?? 'Unknown Supplier';
        $productName = $data['product_name'] ?? $data['product'] ?? $data['item'] ?? null;
        $quantity = $data['quantity'] ?? $data['qty'] ?? 1;
        $price = $data['price'] ?? $data['unit_price'] ?? $data['total_price'] ?? 0;
        $purchaseDate = $data['date'] ?? $data['purchase_date'] ?? now();
        
        if (!$productName) {
            throw new \Exception("Product name is required for purchase");
        }
        
        // Find or create product
        $product = Product::firstOrCreate(
            ['name' => $productName],
            ['price' => is_numeric($price) ? (float)$price : 0, 'stock_quantity' => 0]
        );
        
        Purchase::create([
            'product_id' => $product->id,
            'supplier_name' => $supplierName,
            'quantity' => is_numeric($quantity) ? (int)$quantity : 1,
            'price' => is_numeric($price) ? (float)$price : 0,
            'total_price' => is_numeric($price) ? (float)$price * (int)$quantity : 0,
            'purchase_date' => $purchaseDate,
        ]);
    }
    
    private function importIncubation($data)
    {
        $batchNumber = $data['batch_number'] ?? $data['batch'] ?? 'BATCH-' . time();
        $eggsCount = $data['eggs_count'] ?? $data['eggs'] ?? $data['count'] ?? 0;
        $startDate = $data['start_date'] ?? $data['date'] ?? now();
        $expectedHatchDate = $data['expected_hatch_date'] ?? $data['hatch_date'] ?? null;
        $notes = $data['notes'] ?? $data['description'] ?? '';
        
        if (!is_numeric($eggsCount) || $eggsCount <= 0) {
            throw new \Exception("Valid eggs count is required for incubation");
        }
        
        Incubation::create([
            'batch_number' => $batchNumber,
            'eggs_count' => (int)$eggsCount,
            'start_date' => $startDate,
            'expected_hatch_date' => $expectedHatchDate ?? now()->addDays(21),
            'status' => $data['status'] ?? 'active',
            'notes' => $notes,
        ]);
    }
    
    private function importUser($data)
    {
        $name = $data['name'] ?? $data['full_name'] ?? null;
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? 'password123';
        
        if (!$name || !$email) {
            throw new \Exception("Name and email are required for user");
        }
        
        User::updateOrCreate(
            ['email' => $email],
            [
                'name' => $name,
                'password' => Hash::make($password),
                'email_verified_at' => now(),
            ]
        );
    }
}
