<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Incubation;
use Carbon\Carbon;

class ImportHarvestInnData extends Command
{
    protected $signature = 'import:harvestinn {file=Harvest-Inn Farm Mgt.xlsx}';
    protected $description = 'Import HarvestInn Excel data into database';

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
            $spreadsheet = IOFactory::load($filepath);
            
            // Import Purchase Orders
            $this->importPurchaseOrders($spreadsheet);
            
            // Import Sales Records
            $this->importSalesRecords($spreadsheet);
            
            // Import Poultry Records (Incubations)
            $this->importPoultryRecords($spreadsheet);
            
            $this->info("Import completed successfully!");
            
        } catch (\Exception $e) {
            $this->error("Import failed: " . $e->getMessage());
            $this->error($e->getTraceAsString());
            return 1;
        }
        
        return 0;
    }
    
    private function importPurchaseOrders($spreadsheet)
    {
        $this->info("Importing Purchase Orders...");
        
        $worksheet = $spreadsheet->getSheetByName('Purchase Order');
        $data = $worksheet->toArray();
        
        $imported = 0;
        $errors = 0;
        
        // Skip header row and empty rows
        for ($i = 1; $i < count($data); $i++) {
            $row = $data[$i];
            
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }
            
            try {
                $priority = $row[0] ?? '';
                $productName = $row[1] ?? '';
                $category = $row[2] ?? 'General';
                $status = $row[3] ?? 'Pending';
                $orderDate = $this->parseDate($row[4] ?? null);
                $arriveBy = $this->parseDate($row[5] ?? null);
                $cost = $this->parseNumber($row[6] ?? 0);
                $supplier = $row[7] ?? 'Unknown Supplier';
                $notes = $row[8] ?? '';
                
                if (empty($productName)) {
                    continue;
                }
                
                // Create or find product
                $sku = $this->generateSku($productName);
                $product = Product::where('name', trim($productName))->first();
                
                if (!$product) {
                    $product = Product::create([
                        'name' => trim($productName),
                        'sku' => $sku,
                        'price' => $cost,
                        'quantity' => 0,
                        'quantity_unit' => 'units',
                        'description' => $notes,
                        'category' => $category,
                        'status' => 'out_of_stock',
                    ]);
                }
                
                // Create purchase record
                Purchase::create([
                    'supplier_name' => $supplier,
                    'item_name' => trim($productName),
                    'item_description' => $notes,
                    'category' => $category,
                    'quantity' => 1, // Default quantity since it's not in the sheet
                    'quantity_unit' => 'units',
                    'unit_price' => $cost,
                    'total_amount' => $cost,
                    'purchase_date' => $orderDate ?: now(),
                    'status' => strtolower($status),
                ]);
                
                $imported++;
                
            } catch (\Exception $e) {
                $this->warn("Error importing purchase row " . ($i + 1) . ": " . $e->getMessage());
                $errors++;
            }
        }
        
        $this->info("Purchase Orders: Imported {$imported} records, {$errors} errors");
    }
    
    private function importSalesRecords($spreadsheet)
    {
        $this->info("Importing Sales Records...");
        
        $worksheet = $spreadsheet->getSheetByName('Sales-Records');
        $data = $worksheet->toArray();
        
        $imported = 0;
        $errors = 0;
        
        // Find the actual header row (should be row 2 based on inspection)
        $headerRowIndex = 1; // Row 2 in the inspection
        $headers = $data[$headerRowIndex];
        
        for ($i = $headerRowIndex + 1; $i < count($data); $i++) {
            $row = $data[$i];
            
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }
            
            try {
                $orderNumber = $row[0] ?? '';
                $productName = $row[1] ?? '';
                $status = $row[2] ?? 'Pending';
                $orderDate = $this->parseDate($row[3] ?? null);
                $unitPrice = $this->parseNumber($row[4] ?? 0);
                $quantity = $this->parseNumber($row[5] ?? 1);
                $totalAmount = $this->parseNumber($row[6] ?? 0);
                $paymentMethod = $row[7] ?? 'Cash';
                
                // Map payment methods
                $paymentMethodMap = [
                    'momo' => 'mobile_money',
                    'mobile money' => 'mobile_money',
                    'mobile_money' => 'mobile_money',
                    'bank' => 'bank_transfer',
                    'transfer' => 'bank_transfer',
                    'cash' => 'cash',
                    'credit' => 'credit',
                ];
                
                $paymentMethod = $paymentMethodMap[strtolower($paymentMethod)] ?? 'cash';
                $customerName = $row[8] ?? 'Walk-in Customer';
                
                if (empty($productName)) {
                    continue;
                }
                
                // Create or find product
                $sku = $this->generateSku($productName);
                $product = Product::where('name', trim($productName))->first();
                
                if (!$product) {
                    $product = Product::create([
                        'name' => trim($productName),
                        'sku' => $sku,
                        'price' => $unitPrice,
                        'quantity' => 0,
                        'quantity_unit' => 'units',
                        'description' => '',
                        'category' => 'General',
                        'status' => 'out_of_stock',
                    ]);
                }
                
                // Create sale record
                Sale::create([
                    'product_id' => $product->id,
                    'customer_name' => $customerName,
                    'quantity_sold' => $quantity,
                    'quantity_unit' => 'units',
                    'unit_price' => $unitPrice,
                    'total_amount' => $totalAmount ?: ($unitPrice * $quantity),
                    'final_amount' => $totalAmount ?: ($unitPrice * $quantity),
                    'sale_date' => $orderDate ?: now(),
                    'customer_address' => '', // Not in the sheet
                    'payment_method' => $paymentMethod,
                    'payment_status' => 'completed',
                    'status' => 'completed',
                ]);
                
                $imported++;
                
            } catch (\Exception $e) {
                $this->warn("Error importing sales row " . ($i + 1) . ": " . $e->getMessage());
                $errors++;
            }
        }
        
        $this->info("Sales Records: Imported {$imported} records, {$errors} errors");
    }
    
    private function importPoultryRecords($spreadsheet)
    {
        $this->info("Importing Poultry Records...");
        
        $worksheet = $spreadsheet->getSheetByName('Poultry Records ');
        $data = $worksheet->toArray();
        
        $imported = 0;
        $errors = 0;
        
        // Find the incubation data (should start around row 4 based on inspection)
        $headerRowIndex = 3; // Row 4 in the inspection
        
        for ($i = $headerRowIndex + 1; $i < count($data); $i++) {
            $row = $data[$i];
            
            // Skip empty rows
            if (empty(array_filter($row))) {
                continue;
            }
            
            try {
                $batchNumber = $row[0] ?? '';
                $birdType = $row[1] ?? 'Quail';
                $incubationPeriod = $row[2] ?? '21';
                $quantityPlaced = $this->parseNumber($row[3] ?? 0);
                $status = $row[4] ?? 'Active';
                $startDate = $this->parseDate($row[5] ?? null);
                $hatchDate = $this->parseDate($row[6] ?? null);
                $quantityHatched = $this->parseNumber($row[7] ?? 0);
                $notes = $row[8] ?? '';
                
                // Only import if there's actual data
                if (empty($batchNumber) || $quantityPlaced <= 0) {
                    continue;
                }
                
                // Create incubation record
                Incubation::create([
                    'batch_number' => $batchNumber,
                    'eggs_count' => $quantityPlaced,
                    'start_date' => $startDate ?: now(),
                    'expected_hatch_date' => $hatchDate ?: now()->addDays(21),
                    'status' => strtolower($status),
                    'notes' => $notes . ' | Bird Type: ' . $birdType,
                ]);
                
                $imported++;
                
            } catch (\Exception $e) {
                $this->warn("Error importing poultry row " . ($i + 1) . ": " . $e->getMessage());
                $errors++;
            }
        }
        
        $this->info("Poultry Records: Imported {$imported} records, {$errors} errors");
    }
    
    private function parseDate($value)
    {
        if (empty($value)) {
            return null;
        }
        
        try {
            // Handle different date formats
            if (is_numeric($value)) {
                // Excel date serial number
                return Carbon::createFromFormat('Y-m-d', '1900-01-01')->addDays($value - 2);
            }
            
            // Try parsing common date formats
            $formats = ['d/m/Y', 'm/d/Y', 'Y-m-d', 'd-m-Y'];
            
            foreach ($formats as $format) {
                try {
                    return Carbon::createFromFormat($format, $value);
                } catch (\Exception $e) {
                    continue;
                }
            }
            
            // Last resort - try Carbon's parser
            return Carbon::parse($value);
            
        } catch (\Exception $e) {
            return null;
        }
    }
    
    private function parseNumber($value)
    {
        if (empty($value)) {
            return 0;
        }
        
        // Remove formatting characters
        $cleaned = preg_replace('/[#,##0]/', '', $value);
        $cleaned = str_replace(['#', ','], '', $cleaned);
        
        if (is_numeric($cleaned)) {
            return (float) $cleaned;
        }
        
        return 0;
    }
    
    private function generateSku($productName)
    {
        // Generate SKU from product name
        $base = strtoupper(substr(preg_replace('/[^A-Za-z0-9]/', '', $productName), 0, 6));
        $counter = 1;
        
        do {
            $sku = $base . str_pad($counter, 3, '0', STR_PAD_LEFT);
            $exists = Product::where('sku', $sku)->exists();
            $counter++;
        } while ($exists && $counter < 1000);
        
        return $sku;
    }
}
