<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "booted\n";
$result = Illuminate\Support\Facades\DB::select('SELECT 1 AS ok');
var_export($result);
