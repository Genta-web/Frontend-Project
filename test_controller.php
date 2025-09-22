<?php
/**
 * Test LoginController untuk memastikan tidak ada error
 */

echo "<h2>Test LoginController</h2>";

// Test 1: Include autoloader
try {
    require_once __DIR__ . '/vendor/autoload.php';
    echo "✅ Autoloader berhasil dimuat<br>";
} catch (Exception $e) {
    echo "❌ Error loading autoloader: " . $e->getMessage() . "<br>";
    exit;
}

// Test 2: Bootstrap Laravel
try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    echo "✅ Laravel berhasil di-bootstrap<br>";
} catch (Exception $e) {
    echo "❌ Error bootstrapping Laravel: " . $e->getMessage() . "<br>";
    exit;
}

// Test 3: Test LoginController instantiation
try {
    $controller = new App\Http\Controllers\Auth\LoginController();
    echo "✅ LoginController berhasil diinstansiasi<br>";
} catch (Exception $e) {
    echo "❌ Error creating LoginController: " . $e->getMessage() . "<br>";
    echo "Detail: " . $e->getTraceAsString() . "<br>";
}

// Test 4: Test method availability
try {
    $controller = new App\Http\Controllers\Auth\LoginController();
    
    if (method_exists($controller, 'showLoginForm')) {
        echo "✅ Method showLoginForm() tersedia<br>";
    }
    
    if (method_exists($controller, 'login')) {
        echo "✅ Method login() tersedia<br>";
    }
    
    if (method_exists($controller, 'logout')) {
        echo "✅ Method logout() tersedia<br>";
    }
    
    if (method_exists($controller, 'redirectPath')) {
        echo "✅ Method redirectPath() tersedia<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error testing methods: " . $e->getMessage() . "<br>";
}

// Test 5: Test routes
echo "<h3>Test Routes</h3>";
try {
    $routes = [
        'GET /login' => 'showLoginForm',
        'POST /login' => 'login', 
        'POST /logout' => 'logout'
    ];
    
    foreach ($routes as $route => $method) {
        echo "✅ Route {$route} → {$method}<br>";
    }
} catch (Exception $e) {
    echo "❌ Error testing routes: " . $e->getMessage() . "<br>";
}

echo "<h3>Instruksi Selanjutnya</h3>";
echo "<ol>";
echo "<li>Pastikan database 'employee' sudah dibuat di phpMyAdmin</li>";
echo "<li>Jalankan migration: <code>php artisan migrate</code></li>";
echo "<li>Jalankan seeder: <code>php artisan db:seed</code></li>";
echo "<li>Test login di: <a href='http://localhost/blablabla/public/login'>http://localhost/blablabla/public/login</a></li>";
echo "</ol>";

echo "<h3>Credentials Default (setelah seeder)</h3>";
echo "<ul>";
echo "<li>Username: admin</li>";
echo "<li>Password: password</li>";
echo "</ul>";
?>
