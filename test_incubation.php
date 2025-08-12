<?php

// Test file to verify Incubation model scopes
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

try {
    $count = App\Models\Incubation::active()->count();
    echo "Active incubations: " . $count . "\n";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "Class exists: " . (class_exists('App\Models\Incubation') ? 'Yes' : 'No') . "\n";
    
    if (class_exists('App\Models\Incubation')) {
        $reflection = new ReflectionClass('App\Models\Incubation');
        echo "Methods:\n";
        foreach ($reflection->getMethods() as $method) {
            if (strpos($method->getName(), 'scope') === 0) {
                echo "  - " . $method->getName() . "\n";
            }
        }
    }
}
