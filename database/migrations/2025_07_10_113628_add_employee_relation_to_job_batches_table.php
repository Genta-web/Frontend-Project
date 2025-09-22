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
        Schema::table('job_batches', function (Blueprint $table) {
            // Add employee_id column to track which employee initiated the job batch
            $table->foreignId('employee_id')->nullable()->after('name')->constrained('employees')->onDelete('set null');

            // Add additional columns for better job batch tracking
            $table->string('batch_type')->nullable()->after('employee_id')->comment('Type of batch job (e.g., report_generation, data_export, bulk_update)');
            $table->text('description')->nullable()->after('batch_type')->comment('Description of what this batch job does');
            $table->json('metadata')->nullable()->after('description')->comment('Additional metadata for the job batch');

            // Add index for better query performance
            $table->index('employee_id');
            $table->index('batch_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_batches', function (Blueprint $table) {
            // Drop foreign key constraint first
            $table->dropForeign(['employee_id']);

            // Drop indexes
            $table->dropIndex(['employee_id']);
            $table->dropIndex(['batch_type']);

            // Drop columns
            $table->dropColumn(['employee_id', 'batch_type', 'description', 'metadata']);
        });
    }
};
