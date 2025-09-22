<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmployeeJob;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;

class EmployeeJobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some employees and admin user
        $employees = Employee::take(5)->get();
        $adminUser = User::where('role', 'admin')->first();

        if ($employees->count() > 0 && $adminUser) {
            $jobs = [
                [
                    'employee_id' => $employees[0]->id,
                    'title' => 'Develop User Authentication Module',
                    'description' => 'Create a comprehensive user authentication system with login, registration, password reset, and email verification features.',
                    'priority' => 'high',
                    'status' => 'in_progress',
                    'start_date' => Carbon::today()->subDays(3),
                    'due_date' => Carbon::today()->addDays(7),
                    'progress_percentage' => 65,
                    'notes' => 'Login and registration completed. Working on password reset functionality.',
                    'assigned_by' => $adminUser->id,
                ],
                [
                    'employee_id' => $employees[1]->id,
                    'title' => 'Design Database Schema',
                    'description' => 'Design and implement database schema for the new project including all necessary tables, relationships, and indexes.',
                    'priority' => 'urgent',
                    'status' => 'completed',
                    'start_date' => Carbon::today()->subDays(10),
                    'due_date' => Carbon::today()->subDays(2),
                    'completed_date' => Carbon::today()->subDays(1),
                    'progress_percentage' => 100,
                    'notes' => 'Database schema completed and tested successfully.',
                    'assigned_by' => $adminUser->id,
                    'reviewed_at' => Carbon::today()->subDays(1),
                    'reviewed_by' => $adminUser->id,
                    'review_notes' => 'Excellent work! Database design is well structured and optimized.',
                ],
                [
                    'employee_id' => $employees[2]->id,
                    'title' => 'Create API Documentation',
                    'description' => 'Write comprehensive API documentation for all endpoints including request/response examples and authentication details.',
                    'priority' => 'medium',
                    'status' => 'pending',
                    'start_date' => Carbon::today()->addDays(1),
                    'due_date' => Carbon::today()->addDays(14),
                    'progress_percentage' => 0,
                    'notes' => 'Waiting for API development to be completed first.',
                    'assigned_by' => $adminUser->id,
                ],
                [
                    'employee_id' => $employees[3]->id,
                    'title' => 'Implement Frontend Dashboard',
                    'description' => 'Create responsive dashboard interface with charts, statistics, and user management features using modern frontend technologies.',
                    'priority' => 'high',
                    'status' => 'in_progress',
                    'start_date' => Carbon::today()->subDays(5),
                    'due_date' => Carbon::today()->addDays(10),
                    'progress_percentage' => 40,
                    'notes' => 'Basic layout completed. Working on charts and statistics integration.',
                    'assigned_by' => $adminUser->id,
                ],
                [
                    'employee_id' => $employees[4]->id,
                    'title' => 'Setup CI/CD Pipeline',
                    'description' => 'Configure continuous integration and deployment pipeline using GitHub Actions for automated testing and deployment.',
                    'priority' => 'medium',
                    'status' => 'pending',
                    'start_date' => Carbon::today()->addDays(3),
                    'due_date' => Carbon::today()->addDays(20),
                    'progress_percentage' => 0,
                    'notes' => 'Scheduled to start after main development phase.',
                    'assigned_by' => $adminUser->id,
                ],
                [
                    'employee_id' => $employees[0]->id,
                    'title' => 'Code Review and Testing',
                    'description' => 'Perform comprehensive code review and write unit tests for the authentication module.',
                    'priority' => 'high',
                    'status' => 'pending',
                    'start_date' => Carbon::today()->addDays(8),
                    'due_date' => Carbon::today()->addDays(12),
                    'progress_percentage' => 0,
                    'notes' => 'Will start after authentication module development is completed.',
                    'assigned_by' => $adminUser->id,
                ],
                [
                    'employee_id' => $employees[1]->id,
                    'title' => 'Performance Optimization',
                    'description' => 'Optimize database queries and implement caching strategies to improve application performance.',
                    'priority' => 'low',
                    'status' => 'cancelled',
                    'start_date' => Carbon::today()->subDays(7),
                    'due_date' => Carbon::today()->addDays(5),
                    'progress_percentage' => 20,
                    'notes' => 'Cancelled due to change in project priorities.',
                    'assigned_by' => $adminUser->id,
                ],
                [
                    'employee_id' => $employees[2]->id,
                    'title' => 'Security Audit',
                    'description' => 'Conduct security audit of the application including vulnerability assessment and penetration testing.',
                    'priority' => 'urgent',
                    'status' => 'pending',
                    'start_date' => Carbon::today()->addDays(15),
                    'due_date' => Carbon::today()->addDays(25),
                    'progress_percentage' => 0,
                    'notes' => 'Critical security review before production deployment.',
                    'assigned_by' => $adminUser->id,
                ],
            ];

            foreach ($jobs as $jobData) {
                EmployeeJob::create($jobData);
            }

            $this->command->info('Employee job sample data created successfully!');
            $this->command->info('Created ' . count($jobs) . ' employee jobs with various statuses and priorities.');
        } else {
            $this->command->warn('No employees or admin user found. Please run employee and user seeders first.');
        }
    }
}
