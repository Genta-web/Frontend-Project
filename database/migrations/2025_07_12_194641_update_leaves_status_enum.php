<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // First, expand the enum to include all possible values
        DB::statement("ALTER TABLE leaves MODIFY COLUMN status ENUM('pending', 'waiting', 'approved', 'rejected', 'accept', 'reject') DEFAULT 'pending'");

        // Then fix existing invalid status values
        DB::table('leaves')->where('status', 'accept')->update(['status' => 'approved']);
        DB::table('leaves')->where('status', 'reject')->update(['status' => 'rejected']);

        // Finally, set the correct enum values
        DB::statement("ALTER TABLE leaves MODIFY COLUMN status ENUM('pending', 'waiting', 'approved', 'rejected') DEFAULT 'pending'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum
        DB::statement("ALTER TABLE leaves MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    }
};
