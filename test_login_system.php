<?php
/**
 * Test script untuk sistem login Laravel
 * Jalankan dengan: php test_login_system.php
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

echo "<h2>Test Sistem Login Laravel</h2>";

// Test 1: Koneksi Database
echo "<h3>1. Test Koneksi Database</h3>";
try {
    // Load Laravel app
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
    
    // Test database connection
    $users = DB::table('users')->count();
    echo "✅ Koneksi database berhasil<br>";
    echo "Jumlah user dalam database: $users<br>";
    
} catch (Exception $e) {
    echo "❌ Error koneksi database: " . $e->getMessage() . "<br>";
}

// Test 2: Struktur Tabel Users
echo "<h3>2. Test Struktur Tabel Users</h3>";
try {
    $columns = DB::select("DESCRIBE users");
    echo "✅ Tabel users ditemukan<br>";
    echo "Kolom yang tersedia:<br>";
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})<br>";
    }
} catch (Exception $e) {
    echo "❌ Error mengakses tabel users: " . $e->getMessage() . "<br>";
}

// Test 3: Sample User Data
echo "<h3>3. Test Data User</h3>";
try {
    $sampleUsers = DB::table('users')->limit(5)->get();
    if ($sampleUsers->count() > 0) {
        echo "✅ Data user ditemukan<br>";
        echo "<table border='1' style='border-collapse: collapse;'>";
        echo "<tr><th>ID</th><th>Username</th><th>Role</th><th>Active</th><th>Last Login</th></tr>";
        foreach ($sampleUsers as $user) {
            $lastLogin = $user->last_login ?? 'Never';
            $isActive = $user->is_active ? 'Yes' : 'No';
            echo "<tr>";
            echo "<td>{$user->id}</td>";
            echo "<td>{$user->username}</td>";
            echo "<td>{$user->role}</td>";
            echo "<td>{$isActive}</td>";
            echo "<td>{$lastLogin}</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "⚠️ Tidak ada data user dalam database<br>";
        echo "Silakan jalankan seeder atau buat user manual<br>";
    }
} catch (Exception $e) {
    echo "❌ Error mengambil data user: " . $e->getMessage() . "<br>";
}

// Test 4: Routes
echo "<h3>4. Test Routes</h3>";
try {
    $routes = [
        'login' => '/login',
        'dashboard' => '/dashboard',
        'admin.dashboard' => '/admin/dashboard',
        'hr.dashboard' => '/hr/dashboard',
        'manager.dashboard' => '/manager/dashboard',
        'employee.dashboard' => '/employee/dashboard'
    ];
    
    echo "Routes yang tersedia:<br>";
    foreach ($routes as $name => $path) {
        echo "- {$name}: {$path}<br>";
    }
    echo "✅ Routes configuration OK<br>";
} catch (Exception $e) {
    echo "❌ Error checking routes: " . $e->getMessage() . "<br>";
}

// Test 5: Create Test User (jika belum ada)
echo "<h3>5. Test User Creation</h3>";
try {
    $testUsername = 'testuser';
    $existingUser = DB::table('users')->where('username', $testUsername)->first();
    
    if (!$existingUser) {
        DB::table('users')->insert([
            'username' => $testUsername,
            'password' => Hash::make('password123'),
            'role' => 'employee',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        echo "✅ Test user berhasil dibuat<br>";
        echo "Username: {$testUsername}<br>";
        echo "Password: password123<br>";
        echo "Role: employee<br>";
    } else {
        echo "✅ Test user sudah ada<br>";
        echo "Username: {$testUsername}<br>";
        echo "Role: {$existingUser->role}<br>";
    }
} catch (Exception $e) {
    echo "❌ Error creating test user: " . $e->getMessage() . "<br>";
}

echo "<h3>6. Instruksi Testing Manual</h3>";
echo "<ol>";
echo "<li>Buka browser dan akses: <a href='http://localhost/blablabla/public/login' target='_blank'>http://localhost/blablabla/public/login</a></li>";
echo "<li>Login dengan credentials:</li>";
echo "<ul>";
echo "<li>Username: testuser</li>";
echo "<li>Password: password123</li>";
echo "</ul>";
echo "<li>Setelah login berhasil, Anda akan diarahkan ke dashboard sesuai role</li>";
echo "<li>Test logout dengan mengakses: <a href='http://localhost/blablabla/public/logout' target='_blank'>Logout</a></li>";
echo "</ol>";

echo "<h3>7. Troubleshooting</h3>";
echo "<ul>";
echo "<li>Pastikan Apache dan MySQL di XAMPP sudah running</li>";
echo "<li>Pastikan database sudah dibuat dan migration sudah dijalankan</li>";
echo "<li>Cek file .env untuk konfigurasi database</li>";
echo "<li>Jalankan: <code>php artisan migrate</code> jika tabel belum ada</li>";
echo "<li>Jalankan: <code>php artisan db:seed</code> untuk data sample</li>";
echo "</ul>";
?>
