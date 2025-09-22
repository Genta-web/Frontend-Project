<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the existing users table and recreate with custom structure
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
        
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // Auto-incrementing primary key
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null')->onUpdate('cascade');
            $table->string('username')->unique();
            $table->string('password');
            $table->string('remember_token')->nullable();
            $table->enum('role', ['admin', 'hr', 'manager', 'employee', 'system'])->default('employee');
            $table->datetime('last_login')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps(); // created_at and updated_at with proper defaults
            
            // Add indexes for better query performance
            $table->index('employee_id');
            $table->index('username');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        
        // Recreate the original Laravel users table structure
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });
    }
};
