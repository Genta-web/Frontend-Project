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
        // First, check if the table has the correct structure
        // The original Laravel job_batches table should have string ID
        // If it's not, we need to recreate it

        // Drop and recreate the job_batches table with correct structure
        Schema::dropIfExists('job_batches');

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->foreignId('employee_id')->nullable()->constrained('employees')->onDelete('set null');
            $table->string('batch_type')->nullable()->comment('Type of batch job');
            $table->text('description')->nullable()->comment('Description of the job batch');
            $table->json('metadata')->nullable()->comment('Additional metadata');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();

            // Add indexes
            $table->index('employee_id');
            $table->index('batch_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore original job_batches table structure
        Schema::dropIfExists('job_batches');

        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });
    }
};
