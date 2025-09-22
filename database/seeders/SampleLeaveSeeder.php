<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leave;
use App\Models\Employee;
use Carbon\Carbon;

class SampleLeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get employees
        $employees = Employee::take(3)->get();
        
        if ($employees->count() > 0) {
            // Sample leave requests
            $leaves = [
                [
                    'employee_id' => $employees[0]->id,
                    'leave_type' => 'annual',
                    'start_date' => Carbon::now()->addDays(7),
                    'end_date' => Carbon::now()->addDays(9),
                    'total_days' => 3,
                    'reason' => 'Family vacation to Bali. Need to spend quality time with family.',
                    'status' => 'pending',
                    'admin_notes' => null,
                    'attachment' => null,
                    'approved_by' => null,
                    'approved_at' => null,
                    'created_at' => Carbon::now()->subDays(2),
                    'updated_at' => Carbon::now()->subDays(2),
                ],
                [
                    'employee_id' => $employees[1]->id ?? $employees[0]->id,
                    'leave_type' => 'sick',
                    'start_date' => Carbon::now()->subDays(1),
                    'end_date' => Carbon::now()->addDays(1),
                    'total_days' => 3,
                    'reason' => 'Flu and fever. Doctor recommended rest.',
                    'status' => 'approved',
                    'admin_notes' => 'Approved. Get well soon!',
                    'attachment' => null,
                    'approved_by' => 1, // Admin user
                    'approved_at' => Carbon::now()->subHours(2),
                    'created_at' => Carbon::now()->subDays(3),
                    'updated_at' => Carbon::now()->subHours(2),
                ],
                [
                    'employee_id' => $employees[2]->id ?? $employees[0]->id,
                    'leave_type' => 'emergency',
                    'start_date' => Carbon::now()->addDays(1),
                    'end_date' => Carbon::now()->addDays(2),
                    'total_days' => 2,
                    'reason' => 'Family emergency - need to attend to urgent family matter.',
                    'status' => 'rejected',
                    'admin_notes' => 'Insufficient notice period. Please apply at least 3 days in advance.',
                    'attachment' => null,
                    'approved_by' => 1, // Admin user
                    'approved_at' => Carbon::now()->subHours(1),
                    'created_at' => Carbon::now()->subDays(1),
                    'updated_at' => Carbon::now()->subHours(1),
                ]
            ];

            foreach ($leaves as $leaveData) {
                Leave::create($leaveData);
            }

            $this->command->info('Sample leave requests created successfully!');
        } else {
            $this->command->warn('No employees found. Please run employee seeder first.');
        }
    }
}
