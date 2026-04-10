<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$exists = class_exists('App\\Models\\Product');
echo "class_exists:" . ($exists ? 'true' : 'false') . PHP_EOL;

echo "before_count" . PHP_EOL;
$count = App\Models\Product::count();
echo "after_count" . PHP_EOL;
echo "count:" . $count . PHP_EOL;

echo "before_products" . PHP_EOL;
$products = App\Models\Product::with('subcategory.category')->take(2)->get();
echo "after_products" . PHP_EOL;
var_export($products->toArray());
