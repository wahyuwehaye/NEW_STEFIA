<?php

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

// Bootstrap Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Test DataTables functionality
echo "Testing DataTables functionality...\n";

// Test 1: Check if Student model works
$studentCount = App\Models\Student::count();
echo "✓ Student model works: {$studentCount} students found\n";

// Test 2: Test DataTables class
try {
    $dataTable = new App\DataTables\StudentsDataTable();
    echo "✓ StudentsDataTable class instantiated successfully\n";
} catch (Exception $e) {
    echo "✗ StudentsDataTable class error: " . $e->getMessage() . "\n";
}

// Test 3: Test query method
try {
    $query = $dataTable->query();
    $count = $query->count();
    echo "✓ Query method works: {$count} records accessible\n";
} catch (Exception $e) {
    echo "✗ Query method error: " . $e->getMessage() . "\n";
}

// Test 4: Test controller method
try {
    $controller = new App\Http\Controllers\StudentController();
    echo "✓ StudentController instantiated successfully\n";
} catch (Exception $e) {
    echo "✗ StudentController error: " . $e->getMessage() . "\n";
}

echo "\nAll tests completed!\n";
