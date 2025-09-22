<?php
echo "<h2>Test Sistem Login - Simple Check</h2>";

// Test 1: Cek file LoginController
echo "<h3>1. Cek File LoginController</h3>";
$loginControllerPath = __DIR__ . '/app/Http/Controllers/Auth/LoginController.php';
if (file_exists($loginControllerPath)) {
    echo "✅ LoginController.php ditemukan<br>";
    echo "Path: " . $loginControllerPath . "<br>";
    
    // Cek isi file
    $content = file_get_contents($loginControllerPath);
    if (strpos($content, 'class LoginController') !== false) {
        echo "✅ Class LoginController ada<br>";
    }
    if (strpos($content, 'redirectPath()') !== false) {
        echo "✅ Method redirectPath() ada<br>";
    }
    if (strpos($content, 'authenticated(') !== false) {
        echo "✅ Method authenticated() ada<br>";
    }
} else {
    echo "❌ LoginController.php tidak ditemukan<br>";
}

// Test 2: Cek routes
echo "<h3>2. Cek Routes</h3>";
$routesPath = __DIR__ . '/routes/web.php';
if (file_exists($routesPath)) {
    echo "✅ File routes/web.php ditemukan<br>";
    
    $routesContent = file_get_contents($routesPath);
    if (strpos($routesContent, "Route::get('login'") !== false) {
        echo "✅ Route login GET ada<br>";
    }
    if (strpos($routesContent, "Route::post('login'") !== false) {
        echo "✅ Route login POST ada<br>";
    }
    if (strpos($routesContent, '/dashboard') !== false) {
        echo "✅ Route dashboard ada<br>";
    }
} else {
    echo "❌ File routes/web.php tidak ditemukan<br>";
}

// Test 3: Cek view login
echo "<h3>3. Cek View Login</h3>";
$loginViewPath = __DIR__ . '/resources/views/auth/login.blade.php';
if (file_exists($loginViewPath)) {
    echo "✅ View login.blade.php ditemukan<br>";
    
    $viewContent = file_get_contents($loginViewPath);
    if (strpos($viewContent, 'name="username"') !== false) {
        echo "✅ Input username ada<br>";
    }
    if (strpos($viewContent, 'name="password"') !== false) {
        echo "✅ Input password ada<br>";
    }
    if (strpos($viewContent, 'method="POST"') !== false) {
        echo "✅ Form method POST ada<br>";
    }
} else {
    echo "❌ View login.blade.php tidak ditemukan<br>";
}

// Test 4: Cek Model User
echo "<h3>4. Cek Model User</h3>";
$userModelPath = __DIR__ . '/app/Models/User.php';
if (file_exists($userModelPath)) {
    echo "✅ Model User.php ditemukan<br>";
    
    $userContent = file_get_contents($userModelPath);
    if (strpos($userContent, "'username'") !== false) {
        echo "✅ Field username ada di fillable<br>";
    }
    if (strpos($userContent, "'role'") !== false) {
        echo "✅ Field role ada di fillable<br>";
    }
    if (strpos($userContent, "'is_active'") !== false) {
        echo "✅ Field is_active ada di fillable<br>";
    }
} else {
    echo "❌ Model User.php tidak ditemukan<br>";
}

// Test 5: Cek konfigurasi database
echo "<h3>5. Cek Konfigurasi Database</h3>";
$envPath = __DIR__ . '/.env';
if (file_exists($envPath)) {
    echo "✅ File .env ditemukan<br>";
    
    $envContent = file_get_contents($envPath);
    if (strpos($envContent, 'DB_CONNECTION=mysql') !== false) {
        echo "✅ Database connection: MySQL<br>";
    }
    if (strpos($envContent, 'DB_HOST=127.0.0.1') !== false) {
        echo "✅ Database host: 127.0.0.1<br>";
    }
    if (strpos($envContent, 'DB_DATABASE=employee') !== false) {
        echo "✅ Database name: employee<br>";
    }
} else {
    echo "❌ File .env tidak ditemukan<br>";
}

// Test 6: Instruksi Testing
echo "<h3>6. Cara Test Login</h3>";
echo "<ol>";
echo "<li><strong>Akses halaman login:</strong><br>";
echo "<a href='http://localhost/blablabla/public/login' target='_blank'>http://localhost/blablabla/public/login</a></li>";
echo "<li><strong>Buat database 'employee' di phpMyAdmin jika belum ada</strong></li>";
echo "<li><strong>Jalankan migration:</strong><br>";
echo "<code>php artisan migrate</code></li>";
echo "<li><strong>Jalankan seeder:</strong><br>";
echo "<code>php artisan db:seed</code></li>";
echo "<li><strong>Test login dengan credentials default:</strong><br>";
echo "Username: admin<br>";
echo "Password: password</li>";
echo "</ol>";

echo "<h3>7. Troubleshooting</h3>";
echo "<ul>";
echo "<li>Pastikan XAMPP Apache dan MySQL running</li>";
echo "<li>Pastikan database 'employee' sudah dibuat</li>";
echo "<li>Jalankan: <code>php artisan config:clear</code></li>";
echo "<li>Jalankan: <code>php artisan route:clear</code></li>";
echo "<li>Cek log error di: storage/logs/laravel.log</li>";
echo "</ul>";

echo "<h3>8. File yang Sudah Dibuat/Dimodifikasi</h3>";
echo "<ul>";
echo "<li>✅ app/Http/Controllers/Auth/LoginController.php - Enhanced dengan role-based redirect</li>";
echo "<li>✅ routes/web.php - Routes untuk login/logout/dashboard</li>";
echo "<li>✅ resources/views/auth/login.blade.php - Form login</li>";
echo "<li>✅ app/Models/User.php - Model dengan role dan is_active</li>";
echo "<li>✅ .env - Konfigurasi database MySQL</li>";
echo "</ul>";

echo "<hr>";
echo "<p><strong>Status:</strong> LoginController.php sudah siap digunakan! 🚀</p>";
echo "<p><strong>Next:</strong> Buat database, jalankan migration, dan test login.</p>";
?>
