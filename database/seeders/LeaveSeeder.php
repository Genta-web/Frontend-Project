<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\User;
use Carbon\Carbon;

class LeaveSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get some employees
        $employees = Employee::take(4)->get();
        $adminUser = User::where('role', 'admin')->first();

        if ($employees->count() > 0 && $adminUser) {
            $leaves = [
                [
                    'employee_id' => $employees[0]->id,
                    'leave_type' => 'annual',
                    'start_date' => Carbon::now()->addDays(5),
                    'end_date' => Carbon::now()->addDays(7),
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
                    'employee_id' => $employees[1]->id,
                    'leave_type' => 'sick',
                    'start_date' => Carbon::now()->subDays(1),
                    'end_date' => Carbon::now()->addDays(1),
                    'total_days' => 3,
                    'reason' => 'Flu and fever. Doctor recommended rest for 3 days.',
                    'status' => 'approved',
                    'admin_notes' => null,
                    'attachment' => null,
                    'approved_by' => $adminUser->id,
                    'approved_at' => Carbon::now()->subHours(6),
                    'created_at' => Carbon::now()->subDays(2),
                    'updated_at' => Carbon::now()->subHours(6),
                ],
                [
                    'employee_id' => $employees[2]->id,
                    'leave_type' => 'emergency',
                    'start_date' => Carbon::now()->subDays(3),
                    'end_date' => Carbon::now()->subDays(3),
                    'total_days' => 1,
                    'reason' => 'Family emergency - need to attend to sick parent.',
                    'status' => 'approved',
                    'admin_notes' => null,
                    'attachment' => null,
                    'approved_by' => $adminUser->id,
                    'approved_at' => Carbon::now()->subDays(3),
                    'created_at' => Carbon::now()->subDays(4),
                    'updated_at' => Carbon::now()->subDays(3),
                ],
                [
                    'employee_id' => $employees[0]->id,
                    'leave_type' => 'annual',
                    'start_date' => Carbon::now()->addDays(15),
                    'end_date' => Carbon::now()->addDays(20),
                    'total_days' => 6,
                    'reason' => 'Wedding anniversary celebration. Planned trip to Japan.',
                    'status' => 'rejected',
                    'admin_notes' => 'Too many employees on leave during that period. Please reschedule.',
                    'attachment' => null,
                    'approved_by' => $adminUser->id,
                    'approved_at' => Carbon::now()->subHours(12),
                    'created_at' => Carbon::now()->subDays(5),
                    'updated_at' => Carbon::now()->subHours(12),
                ],
            ];

            // Add more leaves if we have more employees
            if ($employees->count() > 3) {
                $leaves[] = [
                    'employee_id' => $employees[3]->id,
                    'leave_type' => 'maternity',
                    'start_date' => Carbon::now()->addDays(30),
                    'end_date' => Carbon::now()->addDays(120),
                    'total_days' => 91,
                    'reason' => 'Maternity leave for childbirth and newborn care.',
                    'status' => 'pending',
                    'admin_notes' => null,
                    'attachment' => null,
                    'approved_by' => null,
                    'approved_at' => null,
                    'created_at' => Carbon::now()->subDays(1),
                    'updated_at' => Carbon::now()->subDays(1),
                ];
            }

            foreach ($leaves as $leaveData) {
                Leave::create($leaveData);
            }

            $this->command->info('Leave sample data created successfully!');
        } else {
            $this->command->warn('No employees or admin user found. Please run employee seeder first.');
        }
    }
}
