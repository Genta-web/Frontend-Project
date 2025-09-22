<?php

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Employee;

echo "🔍 Laravel Database Check:\n";
echo str_repeat('=', 80) . "\n";

try {
    $users = User::with('employee')->limit(10)->get();
    
    foreach ($users as $user) {
        echo "ID: {$user->id}\n";
        echo "Username: {$user->username}\n";
        echo "Role: {$user->role}\n";
        echo "Profile Photo: " . ($user->profile_photo ?: 'NULL') . "\n";
        echo "Employee Name: " . ($user->employee->name ?? 'N/A') . "\n";
        echo "Active: " . ($user->is_active ? 'true' : 'false') . "\n";
        echo str_repeat('-', 40) . "\n";
    }
    
    // Check storage directories
    echo "\n📁 Storage Directories:\n";
    echo str_repeat('=', 80) . "\n";
    
    $publicPath = storage_path('app/public/profile-photos');
    echo "Public Storage: {$publicPath}\n";
    if (is_dir($publicPath)) {
        $files = scandir($publicPath);
        $files = array_filter($files, function($file) { return $file !== '.' && $file !== '..'; });
        echo "Files found: " . count($files) . "\n";
        foreach ($files as $file) {
            $filePath = $publicPath . '/' . $file;
            $size = filesize($filePath);
            $mtime = date('Y-m-d H:i:s', filemtime($filePath));
            echo "- {$file} ({$size} bytes, {$mtime})\n";
        }
    } else {
        echo "❌ Directory does not exist!\n";
    }
    
    $sharedPath = base_path('../shared-uploads/profiles');
    echo "\nShared Storage: {$sharedPath}\n";
    if (is_dir($sharedPath)) {
        $files = scandir($sharedPath);
        $files = array_filter($files, function($file) { return $file !== '.' && $file !== '..'; });
        echo "Files found: " . count($files) . "\n";
        foreach ($files as $file) {
            $filePath = $sharedPath . '/' . $file;
            $size = filesize($filePath);
            $mtime = date('Y-m-d H:i:s', filemtime($filePath));
            echo "- {$file} ({$size} bytes, {$mtime})\n";
        }
    } else {
        echo "❌ Directory does not exist!\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
