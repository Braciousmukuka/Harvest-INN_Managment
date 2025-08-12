<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\IOFactory;

class InspectExcel extends Command
{
    protected $signature = 'inspect:excel {file=Harvest-Inn Farm Mgt.xlsx}';
    protected $description = 'Inspect Excel file structure';

    public function handle()
    {
        $filename = $this->argument('file');
        $filepath = base_path($filename);
        
        if (!file_exists($filepath)) {
            $this->error("File not found: {$filepath}");
            return 1;
        }
        
        try {
            $spreadsheet = IOFactory::load($filepath);
            $worksheetNames = $spreadsheet->getSheetNames();
            
            $this->info("Excel File: {$filename}");
            $this->info("Found " . count($worksheetNames) . " worksheets");
            
            foreach ($worksheetNames as $index => $sheetName) {
                $this->line("");
                $this->info("=== Worksheet " . ($index + 1) . ": {$sheetName} ===");
                
                $worksheet = $spreadsheet->getSheetByName($sheetName);
                $data = $worksheet->toArray();
                
                if (empty($data)) {
                    $this->warn("Sheet is empty");
                    continue;
                }
                
                $this->info("Total rows: " . count($data));
                
                // Show first few rows
                $this->info("First 5 rows:");
                for ($i = 0; $i < min(5, count($data)); $i++) {
                    $row = $data[$i];
                    $this->line("Row " . ($i + 1) . ": " . json_encode($row));
                }
                
                // Show headers if identifiable
                if (count($data) > 0) {
                    $headers = array_filter($data[0]);
                    if (!empty($headers)) {
                        $this->info("Headers: " . implode(', ', $headers));
                    } else {
                        $this->warn("No clear headers found in first row");
                    }
                }
            }
            
        } catch (\Exception $e) {
            $this->error("Error reading Excel file: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
