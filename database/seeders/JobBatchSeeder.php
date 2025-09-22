<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobBatch;
use App\Models\Employee;
use Illuminate\Support\Str;

class JobBatchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some employees to associate with job batches
        $employees = Employee::take(5)->get();

        if ($employees->count() > 0) {
            $jobBatches = [
                [
                    'id' => Str::uuid()->toString(),
                    'name' => 'Monthly Report Generation',
                    'employee_id' => $employees[0]->id,
                    'batch_type' => 'report_generation',
                    'description' => 'Generate monthly attendance and work log reports for all employees',
                    'metadata' => [
                        'report_type' => 'monthly',
                        'period' => '2025-07',
                        'format' => 'pdf',
                        'recipients' => ['hr@company.com', 'manager@company.com']
                    ],
                    'total_jobs' => 10,
                    'pending_jobs' => 0,
                    'failed_jobs' => 0,
                    'failed_job_ids' => '[]',
                    'options' => json_encode(['timeout' => 300]),
                    'cancelled_at' => null,
                    'created_at' => now()->subDays(5)->timestamp,
                    'finished_at' => now()->subDays(5)->addHours(2)->timestamp,
                ],
                [
                    'id' => Str::uuid()->toString(),
                    'name' => 'Employee Data Export',
                    'employee_id' => $employees[1]->id,
                    'batch_type' => 'data_export',
                    'description' => 'Export employee data to Excel format for HR department',
                    'metadata' => [
                        'export_type' => 'employee_data',
                        'format' => 'xlsx',
                        'filters' => ['status' => 'active', 'department' => 'all']
                    ],
                    'total_jobs' => 5,
                    'pending_jobs' => 2,
                    'failed_jobs' => 0,
                    'failed_job_ids' => '[]',
                    'options' => json_encode(['timeout' => 180]),
                    'cancelled_at' => null,
                    'created_at' => now()->subHours(3)->timestamp,
                    'finished_at' => null,
                ],
                [
                    'id' => Str::uuid()->toString(),
                    'name' => 'Bulk Email Notification',
                    'employee_id' => $employees[2]->id,
                    'batch_type' => 'email_notification',
                    'description' => 'Send reminder emails to employees about pending leave requests',
                    'metadata' => [
                        'email_type' => 'leave_reminder',
                        'template' => 'leave_reminder_template',
                        'recipients_count' => 25
                    ],
                    'total_jobs' => 25,
                    'pending_jobs' => 0,
                    'failed_jobs' => 2,
                    'failed_job_ids' => json_encode([23, 24]),
                    'options' => json_encode(['retry_attempts' => 3]),
                    'cancelled_at' => null,
                    'created_at' => now()->subDays(2)->timestamp,
                    'finished_at' => now()->subDays(2)->addMinutes(45)->timestamp,
                ],
                [
                    'id' => Str::uuid()->toString(),
                    'name' => 'Database Cleanup',
                    'employee_id' => $employees[0]->id,
                    'batch_type' => 'maintenance',
                    'description' => 'Clean up old log files and temporary data',
                    'metadata' => [
                        'cleanup_type' => 'logs_and_temp',
                        'retention_days' => 90,
                        'tables' => ['logs', 'temp_files', 'cache']
                    ],
                    'total_jobs' => 3,
                    'pending_jobs' => 0,
                    'failed_jobs' => 0,
                    'failed_job_ids' => '[]',
                    'options' => json_encode(['timeout' => 600]),
                    'cancelled_at' => now()->subDays(1)->timestamp,
                    'created_at' => now()->subDays(1)->timestamp,
                    'finished_at' => null,
                ],
                [
                    'id' => Str::uuid()->toString(),
                    'name' => 'Payroll Processing',
                    'employee_id' => $employees[1]->id,
                    'batch_type' => 'payroll_processing',
                    'description' => 'Process monthly payroll for all active employees',
                    'metadata' => [
                        'payroll_period' => '2025-07',
                        'employee_count' => 50,
                        'includes_overtime' => true,
                        'includes_bonuses' => false
                    ],
                    'total_jobs' => 50,
                    'pending_jobs' => 15,
                    'failed_jobs' => 0,
                    'failed_job_ids' => '[]',
                    'options' => json_encode(['timeout' => 900, 'priority' => 'high']),
                    'cancelled_at' => null,
                    'created_at' => now()->subHours(1)->timestamp,
                    'finished_at' => null,
                ],
            ];

            foreach ($jobBatches as $batchData) {
                JobBatch::create($batchData);
            }

            $this->command->info('Job batch sample data created successfully!');
            $this->command->info('Created ' . count($jobBatches) . ' job batches with employee relations.');
        } else {
            $this->command->warn('No employees found. Please run employee seeder first.');
        }
    }
}
