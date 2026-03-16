<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

$devConfig = [
    'driver' => 'mysql',
    'host' => 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com',
    'port' => '4000',
    'database' => 'test',
    'username' => '3nxAqGWBLJ8X8HN.root',
    'password' => 'wbfznvAST28eVzSM',
    'options' => [
        PDO::MYSQL_ATTR_SSL_CA => __DIR__ . '/ca.pem',
    ],
];

Config::set('database.connections.dev', $devConfig);

try {
    $user = DB::connection('dev')->table('users')->where('email', 'vanduyho717@gmail.com')->first();
    if ($user) {
        echo "USER_FOUND: " . $user->email . "\n";
        echo "PASSWORD_HASH: " . $user->password . "\n";
        echo "VERIFY_12345678: " . (password_verify('12345678', $user->password) ? 'YES' : 'NO') . "\n";
    } else {
        echo "USER_NOT_FOUND\n";
    }
} catch (\Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
