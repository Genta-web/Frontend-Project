<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\WorkLog;
use App\Models\Employee;
use Carbon\Carbon;

class WorkLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some employees
        $employees = Employee::take(3)->get();

        if ($employees->count() > 0) {
            $workLogs = [
                [
                    'employee_id' => $employees[0]->id,
                    'work_date' => Carbon::today(),
                    'start_time' => '09:00:00',
                    'end_time' => '12:00:00',
                    'task_summary' => 'Working on user authentication module. Implementing login and registration functionality with proper validation.',
                    'status' => 'in_progress',
                    'action_details' => 'Completed login form validation. Next: implement password reset functionality.',
                    'attachment_image' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ],
                [
                    'employee_id' => $employees[0]->id,
                    'work_date' => Carbon::yesterday(),
                    'start_time' => '08:30:00',
                    'end_time' => '17:30:00',
                    'task_summary' => 'Database design and migration setup for the new project. Created tables for users, employees, and work logs.',
                    'status' => 'done',
                    'action_details' => 'All database tables created successfully. Seeders implemented and tested.',
                    'attachment_image' => null,
                    'created_at' => Carbon::yesterday(),
                    'updated_at' => Carbon::yesterday(),
                ],
                [
                    'employee_id' => $employees[1]->id,
                    'work_date' => Carbon::today(),
                    'start_time' => '10:00:00',
                    'end_time' => '15:00:00',
                    'task_summary' => 'Frontend development for dashboard interface. Creating responsive layouts and implementing Bootstrap components.',
                    'status' => 'ongoing',
                    'action_details' => 'Started with sidebar navigation. Need to complete main content area and responsive design.',
                    'attachment_image' => null,
                    'created_at' => Carbon::now()->subHours(2),
                    'updated_at' => Carbon::now()->subHours(2),
                ],
                [
                    'employee_id' => $employees[1]->id,
                    'work_date' => Carbon::today()->subDays(2),
                    'start_time' => '09:15:00',
                    'end_time' => '16:45:00',
                    'task_summary' => 'API development for employee management system. Implementing CRUD operations and data validation.',
                    'status' => 'done',
                    'action_details' => 'All API endpoints completed and tested. Documentation updated.',
                    'attachment_image' => null,
                    'created_at' => Carbon::today()->subDays(2),
                    'updated_at' => Carbon::today()->subDays(2),
                ],
            ];

            // Add more work logs if we have more employees
            if ($employees->count() > 2) {
                $workLogs[] = [
                    'employee_id' => $employees[2]->id,
                    'work_date' => Carbon::today(),
                    'start_time' => '08:00:00',
                    'end_time' => '12:30:00',
                    'task_summary' => 'Testing and quality assurance for the leave management module. Running automated tests and manual testing.',
                    'status' => 'in_progress',
                    'action_details' => 'Found 3 bugs in leave approval workflow. Currently fixing validation issues.',
                    'attachment_image' => null,
                    'created_at' => Carbon::now()->subHour(),
                    'updated_at' => Carbon::now()->subHour(),
                ];
            }

            foreach ($workLogs as $workLogData) {
                WorkLog::create($workLogData);
            }

            $this->command->info('Work log sample data created successfully!');
        } else {
            $this->command->warn('No employees found. Please run employee seeder first.');
        }
    }
}
