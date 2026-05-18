<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

echo 'SESSION_DRIVER=' . config('session.driver') . PHP_EOL;
echo 'DB_CONNECTION=' . config('database.default') . PHP_EOL;

if (Schema::hasTable('sessions')) {
    echo "sessions table: exists\n";
    try {
        $count = DB::table('sessions')->count();
        echo "sessions rows: $count\n";
    } catch (\Exception $e) {
        echo "sessions query failed: " . $e->getMessage() . "\n";
    }
} else {
    echo "sessions table: missing\n";
}
