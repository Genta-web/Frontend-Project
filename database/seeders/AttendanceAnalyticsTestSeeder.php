<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Employee;
use App\Models\Attendance;
use Carbon\Carbon;

class AttendanceAnalyticsTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a test employee if not exists
        $employee = Employee::firstOrCreate([
            'employee_code' => 'EMP001'
        ], [
            'name' => 'John Smith',
            'email' => 'john.smith@company.com',
            'phone' => '+1234567890',
            'department' => 'IT',
            'position' => 'Software Developer',
            'hire_date' => Carbon::now()->subMonths(6),
            'status' => 'active'
        ]);

        // Clear existing attendance for this employee
        Attendance::where('employee_id', $employee->id)->delete();

        // Generate attendance data for the last 8 weeks
        $startDate = Carbon::now()->subWeeks(8)->startOfWeek();

        for ($week = 0; $week < 8; $week++) {
            $weekStart = $startDate->copy()->addWeeks($week);

            // Generate 5 days of attendance for each week (Monday to Friday)
            for ($day = 0; $day < 5; $day++) {
                $date = $weekStart->copy()->addDays($day);

                // Skip if date is in the future
                if ($date->isFuture()) {
                    continue;
                }

                // Randomly skip some days to simulate absences (10% chance)
                if (rand(1, 10) === 1) {
                    continue;
                }

                // Generate realistic check-in times (8:00 - 9:30)
                $checkInHour = rand(8, 9);
                $checkInMinute = $checkInHour === 9 ? rand(0, 30) : rand(0, 59);
                $checkIn = sprintf('%02d:%02d:00', $checkInHour, $checkInMinute);

                // Generate realistic check-out times (17:00 - 18:30)
                $checkOutHour = rand(17, 18);
                $checkOutMinute = $checkOutHour === 18 ? rand(0, 30) : rand(0, 59);
                $checkOut = sprintf('%02d:%02d:00', $checkOutHour, $checkOutMinute);

                Attendance::create([
                    'employee_id' => $employee->id,
                    'date' => $date->format('Y-m-d'),
                    'check_in' => $checkIn,
                    'check_out' => $checkOut,
                    'status' => 'present',
                    'notes' => 'Regular attendance'
                ]);
            }
        }

        $this->command->info("Created test attendance data for employee: {$employee->name} (ID: {$employee->id})");
    }
}
