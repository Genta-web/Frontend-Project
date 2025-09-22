<?php

require_once 'vendor/autoload.php';

// Load Laravel app
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;

echo "🔧 Fixing Laravel Photo Sync...\n";

try {
    // Find user ID 1
    $user = User::find(1);
    if (!$user) {
        echo "❌ User ID 1 not found!\n";
        exit(1);
    }
    
    echo "👤 Current user data:\n";
    echo "   Username: {$user->username}\n";
    echo "   Current profile_photo: " . ($user->profile_photo ?: 'NULL') . "\n";
    
    // Check shared storage
    $sharedDir = base_path('../shared-uploads/profiles');
    echo "📁 Checking shared directory: {$sharedDir}\n";
    
    if (!is_dir($sharedDir)) {
        echo "❌ Shared directory does not exist!\n";
        exit(1);
    }
    
    $files = array_filter(scandir($sharedDir), function($file) {
        return $file !== '.' && $file !== '..';
    });
    
    echo "📄 Files in shared storage: " . implode(', ', $files) . "\n";
    
    // Find files for user 1
    $userFiles = array_filter($files, function($file) {
        return strpos($file, 'profile_1_') === 0;
    });
    
    echo "📄 Files for user 1: " . implode(', ', $userFiles) . "\n";
    
    if (count($userFiles) > 0) {
        // Get the latest file
        $userFiles = array_values($userFiles);
        sort($userFiles);
        $latestFile = end($userFiles);
        
        echo "📄 Latest file: {$latestFile}\n";
        
        // Update database
        $user->update([
            'profile_photo' => $latestFile
        ]);
        
        echo "✅ Updated user 1 profile_photo to: {$latestFile}\n";
        
        // Verify update
        $user->refresh();
        echo "✅ Verification - profile_photo is now: {$user->profile_photo}\n";
    } else {
        echo "❌ No files found for user 1\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    exit(1);
}
