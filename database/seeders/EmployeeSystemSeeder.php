<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class EmployeeSystemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seed employees table
        DB::table('employees')->insert([
            [
                'id' => 1,
                'employee_code' => 'EMP001',
                'name' => 'John Admin',
                'email' => 'john.admin@example.com',
                'phone' => '081234567890',
                'department' => 'IT',
                'position' => 'Administrator',
                'hire_date' => '2020-01-15',
                'status' => 'active',
                'created_at' => '2025-07-02 03:19:52',
                'updated_at' => '2025-07-02 03:19:52',
            ],
            [
                'id' => 2,
                'employee_code' => 'EMP002',
                'name' => 'Sarah HR',
                'email' => 'sarah.hr@example.com',
                'phone' => '081234567891',
                'department' => 'HR',
                'position' => 'HR Officer',
                'hire_date' => '2021-05-10',
                'status' => 'active',
                'created_at' => '2025-07-02 03:19:52',
                'updated_at' => '2025-07-02 03:19:52',
            ],
            [
                'id' => 3,
                'employee_code' => 'EMP003',
                'name' => 'Michael Manager',
                'email' => 'michael.manager@example.com',
                'phone' => '081234567892',
                'department' => 'Sales',
                'position' => 'Sales Manager',
                'hire_date' => '2019-03-20',
                'status' => 'active',
                'created_at' => '2025-07-02 03:19:52',
                'updated_at' => '2025-07-02 03:19:52',
            ],
            [
                'id' => 4,
                'employee_code' => 'EMP004',
                'name' => 'Lisa Employee',
                'email' => 'lisa.employee@example.com',
                'phone' => '081234567893',
                'department' => 'Support',
                'position' => 'Customer Support',
                'hire_date' => '2022-02-01',
                'status' => 'active',
                'created_at' => '2025-07-02 03:19:52',
                'updated_at' => '2025-07-02 03:19:52',
            ],
        ]);

        // Seed users table
        DB::table('users')->insert([
            [
                'id' => 1,
                'employee_id' => 1,
                'username' => 'admin_user',
                'password' => Hash::make('password'), // Using Laravel's Hash instead of bcrypt
                'remember_token' => null,
                'role' => 'admin',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => true,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
            [
                'id' => 2,
                'employee_id' => 2,
                'username' => 'hr_user',
                'password' => Hash::make('password'),
                'remember_token' => null,
                'role' => 'hr',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => true,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
            [
                'id' => 3,
                'employee_id' => 3,
                'username' => 'manager_user',
                'password' => Hash::make('password'),
                'remember_token' => null,
                'role' => 'manager',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => true,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
            [
                'id' => 4,
                'employee_id' => 4,
                'username' => 'employee_user',
                'password' => Hash::make('password'),
                'remember_token' => null,
                'role' => 'employee',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => true,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
            [
                'id' => 5,
                'employee_id' => null,
                'username' => 'system_user',
                'password' => Hash::make('password'),
                'remember_token' => null,
                'role' => 'system',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => true,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
        ]);
    }
}
