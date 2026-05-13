<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
// Bootstrap the application so facades and services are available
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
Illuminate\Support\Facades\Facade::setFacadeApplication($app);

use App\Mail\OneTimePassword;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

// try common seeded emails first
$candidates = [
    'admin@example.com',
    'accountant@example.com',
    'reviewer@example.com',
    'maker@example.com',
    'user1@example.com'
];

$user = null;
foreach ($candidates as $email) {
    $user = User::where('email', $email)->first();
    if ($user) { break; }
}

if (! $user) {
    echo "No seeded users found. Listing up to 10 users in DB:\n";
    $rows = User::limit(10)->get(['id','email']);
    foreach ($rows as $r) {
        echo "- ({$r->id}) {$r->email}\n";
    }
    if ($rows->isEmpty()) {
        echo "(no users found)\n";
    }
    exit(1);
}

$otp = '123456';

try {
    Mail::to($user->email)->send(new OneTimePassword($otp, $user));
    echo "Sent OTP to {$user->email}\n";
} catch (Throwable $e) {
    echo "Mail send failed: ".$e->getMessage()."\n";
    exit(2);
}

exit(0);
