<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

$prodConfig = [
    'driver' => 'mysql',
    'host' => 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com',
    'port' => '4000',
    'database' => 'test', // Wait, DB_DATABASE=test in .env
    'username' => '2bi65SYGEB6zc7j.root',
    'password' => 'Pa9m4KfHugowDp4p',
    'options' => [
        PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/ca.pem',
    ],
];

Config::set('database.connections.prod', $prodConfig);

try {
    DB::connection('prod')->getPdo();
    echo "CONNECTION_SUCCESS\n";
    $userCount = DB::connection('prod')->table('users')->count();
    echo "USER_COUNT: " . $userCount . "\n";
    $user = DB::connection('prod')->table('users')->where('email', 'vanduyho717@gmail.com')->first();
    echo "USER_FOUND: " . ($user ? 'YES' : 'NO') . "\n";
} catch (\Exception $e) {
    echo "CONNECTION_FAILED: " . $e->getMessage() . "\n";
}
