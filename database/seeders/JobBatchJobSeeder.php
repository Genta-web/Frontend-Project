<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\JobBatch;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;

class JobBatchJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some employees
        $employees = Employee::take(5)->get();

        if ($employees->count() > 0) {
            $jobs = [
                [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'name' => 'Develop User Authentication Module',
                    'employee_id' => $employees[0]->id,
                    'description' => 'Create a comprehensive user authentication system with login, registration, password reset, and email verification features.',
                    'priority' => 'high',
                    'job_status' => 'in_progress',
                    'start_date' => Carbon::today()->subDays(3),
                    'due_date' => Carbon::today()->addDays(7),
                    'progress_percentage' => 65,
                    'notes' => 'Login and registration completed. Working on password reset functionality.',
                    'total_jobs' => 1,
                    'pending_jobs' => 0,
                    'failed_jobs' => 0,
                    'failed_job_ids' => [],
                    'created_at' => Carbon::today()->subDays(3)->timestamp,
                    // batch_type is null for individual jobs
                ],
                [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'name' => 'Design Database Schema',
                    'employee_id' => $employees[1]->id,
                    'description' => 'Design and implement database schema for the new project including all necessary tables, relationships, and indexes.',
                    'priority' => 'urgent',
                    'job_status' => 'completed',
                    'start_date' => Carbon::today()->subDays(10),
                    'due_date' => Carbon::today()->subDays(2),
                    'completed_date' => Carbon::today()->subDays(1),
                    'progress_percentage' => 100,
                    'notes' => 'Database schema completed and tested successfully.',
                    'total_jobs' => 1,
                    'pending_jobs' => 0,
                    'failed_jobs' => 0,
                    'failed_job_ids' => [],
                    'created_at' => Carbon::today()->subDays(10)->timestamp,
                    'finished_at' => Carbon::today()->subDays(1)->timestamp,
                ],
                [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'name' => 'Create API Documentation',
                    'employee_id' => $employees[2]->id,
                    'description' => 'Write comprehensive API documentation for all endpoints including request/response examples and authentication details.',
                    'priority' => 'medium',
                    'job_status' => 'pending',
                    'start_date' => Carbon::today()->addDays(1),
                    'due_date' => Carbon::today()->addDays(14),
                    'progress_percentage' => 0,
                    'notes' => 'Waiting for API development to be completed first.',
                    'total_jobs' => 1,
                    'pending_jobs' => 1,
                    'failed_jobs' => 0,
                    'failed_job_ids' => [],
                    'created_at' => Carbon::today()->timestamp,
                ],
                [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'name' => 'Implement Frontend Dashboard',
                    'employee_id' => $employees[3]->id,
                    'description' => 'Create responsive dashboard interface with charts, statistics, and user management features using modern frontend technologies.',
                    'priority' => 'high',
                    'job_status' => 'in_progress',
                    'start_date' => Carbon::today()->subDays(5),
                    'due_date' => Carbon::today()->addDays(10),
                    'progress_percentage' => 40,
                    'notes' => 'Basic layout completed. Working on charts and statistics integration.',
                    'total_jobs' => 1,
                    'pending_jobs' => 0,
                    'failed_jobs' => 0,
                    'failed_job_ids' => [],
                    'created_at' => Carbon::today()->subDays(5)->timestamp,
                ],
                [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'name' => 'Setup CI/CD Pipeline',
                    'employee_id' => $employees[4]->id,
                    'description' => 'Configure continuous integration and deployment pipeline using GitHub Actions for automated testing and deployment.',
                    'priority' => 'medium',
                    'job_status' => 'pending',
                    'start_date' => Carbon::today()->addDays(3),
                    'due_date' => Carbon::today()->addDays(20),
                    'progress_percentage' => 0,
                    'notes' => 'Scheduled to start after main development phase.',
                    'total_jobs' => 1,
                    'pending_jobs' => 1,
                    'failed_jobs' => 0,
                    'failed_job_ids' => [],
                    'created_at' => Carbon::today()->timestamp,
                ],
                [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'name' => 'Code Review and Testing',
                    'employee_id' => $employees[0]->id,
                    'description' => 'Perform comprehensive code review and write unit tests for the authentication module.',
                    'priority' => 'high',
                    'job_status' => 'pending',
                    'start_date' => Carbon::today()->addDays(8),
                    'due_date' => Carbon::today()->addDays(12),
                    'progress_percentage' => 0,
                    'notes' => 'Will start after authentication module development is completed.',
                    'total_jobs' => 1,
                    'pending_jobs' => 1,
                    'failed_jobs' => 0,
                    'failed_job_ids' => [],
                    'created_at' => Carbon::today()->timestamp,
                ],
                [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'name' => 'Security Audit',
                    'employee_id' => $employees[2]->id,
                    'description' => 'Conduct security audit of the application including vulnerability assessment and penetration testing.',
                    'priority' => 'urgent',
                    'job_status' => 'pending',
                    'start_date' => Carbon::today()->addDays(15),
                    'due_date' => Carbon::today()->addDays(25),
                    'progress_percentage' => 0,
                    'notes' => 'Critical security review before production deployment.',
                    'total_jobs' => 1,
                    'pending_jobs' => 1,
                    'failed_jobs' => 0,
                    'failed_job_ids' => [],
                    'created_at' => Carbon::today()->timestamp,
                ],
                [
                    'id' => \Illuminate\Support\Str::uuid(),
                    'name' => 'Performance Optimization',
                    'employee_id' => $employees[1]->id,
                    'description' => 'Optimize database queries and implement caching strategies to improve application performance.',
                    'priority' => 'low',
                    'job_status' => 'cancelled',
                    'start_date' => Carbon::today()->subDays(7),
                    'due_date' => Carbon::today()->addDays(5),
                    'progress_percentage' => 20,
                    'notes' => 'Cancelled due to change in project priorities.',
                    'total_jobs' => 1,
                    'pending_jobs' => 0,
                    'failed_jobs' => 0,
                    'failed_job_ids' => [],
                    'created_at' => Carbon::today()->subDays(7)->timestamp,
                    'cancelled_at' => Carbon::today()->subDays(2)->timestamp,
                ],
            ];

            foreach ($jobs as $jobData) {
                JobBatch::create($jobData);
            }

            $this->command->info('Individual job sample data created successfully!');
            $this->command->info('Created ' . count($jobs) . ' individual jobs with various statuses and priorities.');
        } else {
            $this->command->warn('No employees found. Please run employee seeder first.');
        }
    }
}
