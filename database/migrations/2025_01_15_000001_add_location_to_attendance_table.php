<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->decimal('check_in_latitude', 10, 8)->nullable()->after('check_in');
            $table->decimal('check_in_longitude', 11, 8)->nullable()->after('check_in_latitude');
            $table->string('check_in_location')->nullable()->after('check_in_longitude');
            $table->decimal('check_out_latitude', 10, 8)->nullable()->after('check_out');
            $table->decimal('check_out_longitude', 11, 8)->nullable()->after('check_out_latitude');
            $table->string('check_out_location')->nullable()->after('check_out_longitude');
        });
    }

    public function down(): void
    {
        Schema::table('attendance', function (Blueprint $table) {
            $table->dropColumn([
                'check_in_latitude', 'check_in_longitude', 'check_in_location',
                'check_out_latitude', 'check_out_longitude', 'check_out_location'
            ]);
        });
    }
};