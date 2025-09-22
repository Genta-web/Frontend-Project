<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Employee;

class EmployeeDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Seeder ini dibuat berdasarkan data yang ada di employee_db.sql
     */
    public function run(): void
    {
        $this->command->info('🔄 Seeding data karyawan...');

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

        // Disable foreign key checks untuk truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data lama dan insert data baru
        DB::table('employees')->truncate();
        foreach ($employees as $employeeData) {
            DB::table('employees')->insert($employeeData);
        }

        // Enable foreign key checks kembali
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ Data karyawan berhasil di-seed');

        $this->command->info('🔄 Seeding data users...');

        // Data users dengan password yang mudah diingat
        $users = [
            [
                'id' => 1,
                'employee_id' => 1,
                'username' => 'admin_user',
                'password' => Hash::make('password123'), // Password mudah diingat
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
                'password' => Hash::make('password123'),
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
                'password' => Hash::make('password123'),
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
                'password' => Hash::make('password123'),
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
                'password' => Hash::make('password123'),
                'remember_token' => null,
                'role' => 'system',
                'last_login' => '2025-07-02 03:20:02',
                'is_active' => 1,
                'created_at' => '2025-07-02 03:20:02',
                'updated_at' => '2025-07-02 03:20:02',
            ],
        ];

        // Disable foreign key checks untuk truncate
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Hapus data lama dan insert data baru
        DB::table('users')->truncate();
        foreach ($users as $userData) {
            DB::table('users')->insert($userData);
        }

        // Enable foreign key checks kembali
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Reset auto increment sesuai dengan database asli
        DB::statement('ALTER TABLE employees AUTO_INCREMENT = 9');
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 6');

        $this->command->info('✅ Data users berhasil di-seed');
        $this->command->info('');
        $this->command->info('🎉 SEEDING SELESAI!');
        $this->command->info('');
        $this->command->info('📋 Akun Login yang tersedia:');
        $this->command->info('┌─────────────────────────────────────────┐');
        $this->command->info('│ Role     │ Username      │ Password    │');
        $this->command->info('├─────────────────────────────────────────┤');
        $this->command->info('│ Admin    │ admin_user    │ password123 │');
        $this->command->info('│ HR       │ hr_user       │ password123 │');
        $this->command->info('│ Manager  │ manager_user  │ password123 │');
        $this->command->info('│ Employee │ employee_user │ password123 │');
        $this->command->info('│ System   │ system_user   │ password123 │');
        $this->command->info('└─────────────────────────────────────────┘');
        $this->command->info('');
        $this->command->info('🚀 Cara menjalankan aplikasi:');
        $this->command->info('   php artisan serve');
        $this->command->info('');
        $this->command->info('🌐 Buka di browser:');
        $this->command->info('   http://localhost:8000');
        $this->command->info('');
        $this->command->info('💡 Tips: Login dengan admin_user untuk akses penuh!');
    }
}
