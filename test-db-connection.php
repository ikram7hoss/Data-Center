<?php

require_once __DIR__ . '/bootstrap/app.php';

try {
    $pdo = DB::connection()->getPdo();
    echo "✓ Database connection successful!\n";
    echo "Database: " . config('database.connections.mysql.database') . "\n";
    echo "Host: " . config('database.connections.mysql.host') . "\n";
} catch (\Exception $e) {
    echo "✗ Database connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
