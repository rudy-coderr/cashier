<?php
// scripts/run_maker_store_test.php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Http\Request;

// Build a request with minimal required fields
$data = [
    'transaction_type' => 'test',
    'amount' => 123.45,
    'name' => 'Test User',
    'contact' => '09171234567',
    'address' => '123 Test St',
    'email' => 'test@example.com',
    'agree_terms' => '1',
    'fund_type' => 'F01',
    'payment_mode' => 'cash',
];

$request = Request::create('/maker', 'POST', $data);

$controller = new App\Http\Controllers\MakerController();
try {
    $response = $controller->store($request);
    echo "Controller executed.\n";
} catch (Throwable $e) {
    echo "Controller threw: " . $e->getMessage() . "\n";
}

echo "Done.\n";
