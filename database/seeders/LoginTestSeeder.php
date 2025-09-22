<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing users
        DB::table('users')->truncate();

        // Create test users
        $users = [
            [
                'username' => 'admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'hr_user',
                'password' => Hash::make('password'),
                'role' => 'hr',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'manager1',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'employee1',
                'password' => Hash::make('password'),
                'role' => 'employee',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'testuser',
                'password' => Hash::make('password123'),
                'role' => 'employee',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);

        $this->command->info('Login test users created successfully!');
        $this->command->info('Available users:');
        foreach ($users as $user) {
            $this->command->info("- {$user['username']} ({$user['role']}) - password: password" . ($user['username'] === 'testuser' ? '123' : ''));
        }
    }
}
