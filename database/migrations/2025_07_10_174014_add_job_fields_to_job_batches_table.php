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
            // Add fields for job management
            $table->enum('priority', ['low', 'medium', 'high', 'urgent'])->default('medium')->after('batch_type');
            $table->date('start_date')->nullable()->after('description');
            $table->date('due_date')->nullable()->after('start_date');
            $table->date('completed_date')->nullable()->after('due_date');
            $table->text('notes')->nullable()->after('completed_date');
            $table->string('attachment')->nullable()->after('notes');
            $table->integer('progress_percentage')->default(0)->after('attachment');
            $table->enum('job_status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending')->after('progress_percentage');
            $table->timestamp('reviewed_at')->nullable()->after('job_status');
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null')->after('reviewed_at');
            $table->text('review_notes')->nullable()->after('reviewed_by');

            // Add indexes for better performance
            $table->index(['employee_id', 'job_status']);
            $table->index(['start_date', 'due_date']);
            $table->index('priority');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('job_batches', function (Blueprint $table) {
            $table->dropIndex(['employee_id', 'job_status']);
            $table->dropIndex(['start_date', 'due_date']);
            $table->dropIndex('priority');

            $table->dropForeign(['reviewed_by']);
            $table->dropColumn([
                'priority',
                'start_date',
                'due_date',
                'completed_date',
                'notes',
                'attachment',
                'progress_percentage',
                'job_status',
                'reviewed_at',
                'reviewed_by',
                'review_notes'
            ]);
        });
    }
};
