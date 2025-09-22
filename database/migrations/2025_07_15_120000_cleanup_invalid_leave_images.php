<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Leave;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Clean up any invalid image data in existing leaves
        $leaves = Leave::whereNotNull('images')->get();
        
        foreach ($leaves as $leave) {
            if ($leave->images && is_array($leave->images)) {
                $validImages = [];
                $hasChanges = false;
                
                foreach ($leave->images as $image) {
                    if (is_array($image) && isset($image['path']) && !empty($image['path'])) {
                        $validImages[] = $image;
                    } else {
                        $hasChanges = true;
                    }
                }
                
                if ($hasChanges) {
                    $leave->images = $validImages;
                    $leave->save();
                }
            } else if ($leave->images && !is_array($leave->images)) {
                // Reset invalid non-array data
                $leave->images = null;
                $leave->save();
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No need to reverse this cleanup
    }
};
