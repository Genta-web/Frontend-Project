<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use App\Models\Employee;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Fix employees with empty employee codes
        $employeesWithoutCodes = Employee::where('employee_code', '')->orWhereNull('employee_code')->get();

        if ($employeesWithoutCodes->count() > 0) {
            echo "Fixing " . $employeesWithoutCodes->count() . " employees with empty codes...\n";

            // Get the highest existing employee code number
            $lastCode = Employee::where('employee_code', 'LIKE', 'EMP%')
                               ->where('employee_code', 'REGEXP', '^EMP[0-9]+$')
                               ->orderByRaw('CAST(SUBSTRING(employee_code, 4) AS UNSIGNED) DESC')
                               ->value('employee_code');

            $nextNumber = $lastCode ? (int)substr($lastCode, 3) + 1 : 1;

            foreach ($employeesWithoutCodes as $employee) {
                // Generate unique code
                do {
                    $employeeCode = 'EMP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                    $exists = Employee::where('employee_code', $employeeCode)->exists();
                    if ($exists) {
                        $nextNumber++;
                    }
                } while ($exists);

                // Update the employee
                $employee->update(['employee_code' => $employeeCode]);
                echo "Updated employee ID {$employee->id} ({$employee->name}) with code {$employeeCode}\n";

                $nextNumber++;
            }
        }

        // Fix inconsistent employee codes (like EMP00123, EMP20)
        $inconsistentCodes = Employee::where('employee_code', 'LIKE', 'EMP%')
                                   ->where('employee_code', 'NOT REGEXP', '^EMP[0-9]{3}$')
                                   ->where('employee_code', '!=', '')
                                   ->get();

        if ($inconsistentCodes->count() > 0) {
            echo "Fixing " . $inconsistentCodes->count() . " employees with inconsistent codes...\n";

            foreach ($inconsistentCodes as $employee) {
                $oldCode = $employee->employee_code;

                // Get the highest existing employee code number again
                $lastCode = Employee::where('employee_code', 'LIKE', 'EMP%')
                                   ->where('employee_code', 'REGEXP', '^EMP[0-9]{3}$')
                                   ->orderByRaw('CAST(SUBSTRING(employee_code, 4) AS UNSIGNED) DESC')
                                   ->value('employee_code');

                $nextNumber = $lastCode ? (int)substr($lastCode, 3) + 1 : 1;

                // Generate unique code
                do {
                    $employeeCode = 'EMP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                    $exists = Employee::where('employee_code', $employeeCode)->exists();
                    if ($exists) {
                        $nextNumber++;
                    }
                } while ($exists);

                // Update the employee
                $employee->update(['employee_code' => $employeeCode]);
                echo "Updated employee ID {$employee->id} ({$employee->name}) from {$oldCode} to {$employeeCode}\n";
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // This migration cannot be reversed as it fixes data integrity
        echo "This migration cannot be reversed as it fixes data integrity issues.\n";
    }
};
