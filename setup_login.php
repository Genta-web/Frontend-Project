<?php
/**
 * Script untuk setup database dan user untuk testing login
 */

echo "<h2>Setup Login System</h2>";

// Test koneksi database
echo "<h3>1. Test Koneksi Database</h3>";
try {
    $host = '127.0.0.1';
    $username = 'root';
    $password = '';
    $database = 'employee';
    
    $pdo = new PDO("mysql:host=$host", $username, $password);
    echo "✅ Koneksi MySQL berhasil<br>";
    
    // Cek apakah database exists
    $stmt = $pdo->query("SHOW DATABASES LIKE '$database'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Database '$database' sudah ada<br>";
    } else {
        // Buat database
        $pdo->exec("CREATE DATABASE IF NOT EXISTS $database");
        echo "✅ Database '$database' berhasil dibuat<br>";
    }
    
    // Connect ke database
    $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
    
} catch (PDOException $e) {
    echo "❌ Error koneksi database: " . $e->getMessage() . "<br>";
    echo "<p><strong>Solusi:</strong></p>";
    echo "<ul>";
    echo "<li>Pastikan XAMPP MySQL sudah running</li>";
    echo "<li>Buka phpMyAdmin dan buat database 'employee'</li>";
    echo "</ul>";
    exit;
}

// Cek tabel users
echo "<h3>2. Cek Tabel Users</h3>";
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        echo "✅ Tabel 'users' sudah ada<br>";
        
        // Cek struktur tabel
        $stmt = $pdo->query("DESCRIBE users");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $requiredColumns = ['id', 'username', 'password', 'role', 'is_active'];
        $existingColumns = array_column($columns, 'Field');
        
        foreach ($requiredColumns as $col) {
            if (in_array($col, $existingColumns)) {
                echo "✅ Kolom '$col' ada<br>";
            } else {
                echo "❌ Kolom '$col' tidak ada<br>";
            }
        }
        
    } else {
        echo "❌ Tabel 'users' belum ada<br>";
        echo "<p><strong>Solusi:</strong> Jalankan <code>php artisan migrate</code></p>";
    }
} catch (PDOException $e) {
    echo "❌ Error cek tabel: " . $e->getMessage() . "<br>";
}

// Buat user test jika tabel ada
echo "<h3>3. Buat User Test</h3>";
try {
    $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
    if ($stmt->rowCount() > 0) {
        
        // Cek apakah sudah ada user
        $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] == 0) {
            // Insert user test
            $users = [
                [
                    'username' => 'admin',
                    'password' => password_hash('password', PASSWORD_DEFAULT),
                    'role' => 'admin',
                    'is_active' => 1
                ],
                [
                    'username' => 'testuser',
                    'password' => password_hash('password123', PASSWORD_DEFAULT),
                    'role' => 'employee',
                    'is_active' => 1
                ]
            ];
            
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role, is_active, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())");
            
            foreach ($users as $user) {
                $stmt->execute([$user['username'], $user['password'], $user['role'], $user['is_active']]);
            }
            
            echo "✅ User test berhasil dibuat<br>";
            echo "<ul>";
            foreach ($users as $user) {
                $pass = $user['username'] === 'admin' ? 'password' : 'password123';
                echo "<li>Username: {$user['username']}, Password: $pass, Role: {$user['role']}</li>";
            }
            echo "</ul>";
            
        } else {
            echo "✅ User sudah ada ($result[count] users)<br>";
            
            // Tampilkan user yang ada
            $stmt = $pdo->query("SELECT username, role, is_active FROM users LIMIT 5");
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            echo "<table border='1' style='border-collapse: collapse;'>";
            echo "<tr><th>Username</th><th>Role</th><th>Active</th></tr>";
            foreach ($users as $user) {
                $active = $user['is_active'] ? 'Yes' : 'No';
                echo "<tr><td>{$user['username']}</td><td>{$user['role']}</td><td>$active</td></tr>";
            }
            echo "</table>";
        }
        
    } else {
        echo "❌ Tabel users belum ada, tidak bisa membuat user test<br>";
    }
    
} catch (PDOException $e) {
    echo "❌ Error membuat user test: " . $e->getMessage() . "<br>";
}

echo "<h3>4. Test Login</h3>";
echo "<p>Jika semua langkah di atas berhasil, Anda bisa test login:</p>";
echo "<ol>";
echo "<li><a href='http://localhost/blablabla/public/login' target='_blank'>Buka halaman login</a></li>";
echo "<li>Login dengan:</li>";
echo "<ul>";
echo "<li>Username: <strong>admin</strong>, Password: <strong>password</strong></li>";
echo "<li>Username: <strong>testuser</strong>, Password: <strong>password123</strong></li>";
echo "</ul>";
echo "</ol>";

echo "<h3>5. Troubleshooting</h3>";
echo "<ul>";
echo "<li>Jika error 'middleware': LoginController sudah diperbaiki</li>";
echo "<li>Jika error 'database not found': Buat database 'employee' di phpMyAdmin</li>";
echo "<li>Jika error 'table not found': Jalankan <code>php artisan migrate</code></li>";
echo "<li>Jika login gagal: Pastikan user ada dan is_active = 1</li>";
echo "</ul>";

echo "<hr>";
echo "<p><strong>Status:</strong> Setup selesai! Silakan test login. 🚀</p>";
?>
