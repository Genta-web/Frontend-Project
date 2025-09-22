<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Employee;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding employees data...');

        // Data employees sesuai dengan employee_db.sql
        $employees = [
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
        ];

        // Truncate table terlebih dahulu untuk memastikan data fresh
        DB::table('employees')->truncate();

        // Insert employees dengan ID yang spesifik
        foreach ($employees as $employeeData) {
            DB::table('employees')->insert($employeeData);
        }

        $this->command->info('Seeding users data...');

        // Data users sesuai dengan employee_db.sql
        // Password hash dari database: $2b$10$... (bcrypt dengan cost 10)
        $users = [
            [
                'id' => 1,
                'employee_id' => 1,
                'username' => 'admin_user',
                'password' => '$2b$10$03bNPdQ3RRz3kfwdiBk4iezq1AAIriYZv5DHdrl3YU/v6sZ.WcSq6', // password: admin123
                'remember_token' => null,
                'role' => 'admin',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => 1,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
            [
                'id' => 2,
                'employee_id' => 2,
                'username' => 'hr_user',
                'password' => '$2b$10$Qij1XZG5iXVQlCu5BS03C.Ztk.bZR3bNIMUh3LzjwQ0w5ynZMepcC', // password: hr123
                'remember_token' => null,
                'role' => 'hr',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => 1,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
            [
                'id' => 3,
                'employee_id' => 3,
                'username' => 'manager_user',
                'password' => '$2b$10$wz5BGVoBwnBK6B/RIcHrg.7RIq9LOZ9bL29U022pmYdP9qtQoVbMq', // password: manager123
                'remember_token' => null,
                'role' => 'manager',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => 1,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
            [
                'id' => 4,
                'employee_id' => 4,
                'username' => 'employee_user',
                'password' => '$2b$10$nb6aNQ2l4cxIo9dsOYj2su/F1qUS9cPOMKlEEKcyux0/VMIdE5Sk6', // password: employee123
                'remember_token' => null,
                'role' => 'employee',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => 1,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
            [
                'id' => 5,
                'employee_id' => null,
                'username' => 'system_user',
                'password' => '$2b$10$4z6BIMJI8TnOXvWqm.OOauxqQjuqLX4ttxKVuj0MbSfDgIqA5ksIa', // password: system123
                'remember_token' => null,
                'role' => 'system',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => 1,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
        ];

        // Truncate table users
        DB::table('users')->truncate();

        // Insert users dengan ID yang spesifik
        foreach ($users as $userData) {
            DB::table('users')->insert($userData);
        }

        // Reset auto increment untuk kedua tabel
        DB::statement('ALTER TABLE employees AUTO_INCREMENT = 9');
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 6');

        $this->command->info('✅ Data seeded successfully!');
        $this->command->info('');
        $this->command->info('📋 Login credentials (sesuai employee_db.sql):');
        $this->command->info('👤 Admin: admin_user / admin123');
        $this->command->info('👤 HR: hr_user / hr123');
        $this->command->info('👤 Manager: manager_user / manager123');
        $this->command->info('👤 Employee: employee_user / employee123');
        $this->command->info('👤 System: system_user / system123');
        $this->command->info('');
        $this->command->info('🚀 Jalankan: php artisan serve');
        $this->command->info('🌐 Buka: http://localhost:8000');
    }
}
