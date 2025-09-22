<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

class EmployeeManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test users
        $this->adminUser = User::create([
            'username' => 'admin_test',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->hrUser = User::create([
            'username' => 'hr_test',
            'password' => Hash::make('password'),
            'role' => 'hr',
            'is_active' => true,
        ]);

        $this->employeeUser = User::create([
            'username' => 'employee_test',
            'password' => Hash::make('password'),
            'role' => 'employee',
            'is_active' => true,
        ]);
    }

    public function test_login_with_username()
    {
        $response = $this->post('/login', [
            'username' => 'admin_test',
            'password' => 'password',
        ]);

        $response->assertRedirect('/admin/dashboard');
        $this->assertAuthenticatedAs($this->adminUser);
    }

    public function test_admin_can_access_employee_list()
    {
        $response = $this->actingAs($this->adminUser)
            ->get('/employees');

        $response->assertStatus(200);
        $response->assertSee('Employee Management');
    }

    public function test_hr_can_access_employee_list()
    {
        $response = $this->actingAs($this->hrUser)
            ->get('/employees');

        $response->assertStatus(200);
        $response->assertSee('Employee Management');
    }

    public function test_employee_cannot_access_employee_list()
    {
        $response = $this->actingAs($this->employeeUser)
            ->get('/employees');

        $response->assertStatus(403);
    }

    public function test_admin_can_create_employee()
    {
        $employeeData = [
            'employee_code' => 'EMP999',
            'name' => 'Test Employee',
            'email' => 'test@example.com',
            'phone' => '1234567890',
            'department' => 'IT',
            'position' => 'Developer',
            'hire_date' => '2024-01-01',
            'status' => 'active',
        ];

        $response = $this->actingAs($this->adminUser)
            ->post('/employees', $employeeData);

        $response->assertRedirect('/employees');
        $this->assertDatabaseHas('employees', [
            'employee_code' => 'EMP999',
            'name' => 'Test Employee',
        ]);
    }

    public function test_hr_can_create_employee()
    {
        $employeeData = [
            'employee_code' => 'EMP998',
            'name' => 'HR Test Employee',
            'email' => 'hrtest@example.com',
            'phone' => '1234567891',
            'department' => 'HR',
            'position' => 'HR Assistant',
            'hire_date' => '2024-01-01',
            'status' => 'active',
        ];

        $response = $this->actingAs($this->hrUser)
            ->post('/employees', $employeeData);

        $response->assertRedirect('/employees');
        $this->assertDatabaseHas('employees', [
            'employee_code' => 'EMP998',
            'name' => 'HR Test Employee',
        ]);
    }

    public function test_admin_can_edit_employee()
    {
        $employee = Employee::create([
            'employee_code' => 'EMP997',
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'department' => 'IT',
            'position' => 'Developer',
            'hire_date' => '2024-01-01',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->put("/employees/{$employee->id}", [
                'employee_code' => 'EMP997',
                'name' => 'Updated Name',
                'email' => 'updated@example.com',
                'department' => 'IT',
                'position' => 'Senior Developer',
                'hire_date' => '2024-01-01',
                'status' => 'active',
            ]);

        $response->assertRedirect('/employees');
        $this->assertDatabaseHas('employees', [
            'id' => $employee->id,
            'name' => 'Updated Name',
            'position' => 'Senior Developer',
        ]);
    }

    public function test_hr_cannot_edit_employee()
    {
        $employee = Employee::create([
            'employee_code' => 'EMP996',
            'name' => 'Original Name',
            'email' => 'original@example.com',
            'department' => 'IT',
            'position' => 'Developer',
            'hire_date' => '2024-01-01',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->hrUser)
            ->put("/employees/{$employee->id}", [
                'name' => 'Updated Name',
            ]);

        $response->assertStatus(403);
    }

    public function test_admin_can_delete_employee()
    {
        $employee = Employee::create([
            'employee_code' => 'EMP995',
            'name' => 'To Be Deleted',
            'email' => 'delete@example.com',
            'department' => 'IT',
            'position' => 'Developer',
            'hire_date' => '2024-01-01',
            'status' => 'active',
        ]);

        $response = $this->actingAs($this->adminUser)
            ->delete("/employees/{$employee->id}");

        $response->assertRedirect('/employees');
        $this->assertDatabaseMissing('employees', [
            'id' => $employee->id,
        ]);
    }

    public function test_role_based_dashboard_redirect()
    {
        // Test admin redirect
        $response = $this->post('/login', [
            'username' => 'admin_test',
            'password' => 'password',
        ]);
        $response->assertRedirect('/admin/dashboard');

        // Test HR redirect
        $response = $this->post('/login', [
            'username' => 'hr_test',
            'password' => 'password',
        ]);
        $response->assertRedirect('/hr/dashboard');

        // Test employee redirect
        $response = $this->post('/login', [
            'username' => 'employee_test',
            'password' => 'password',
        ]);
        $response->assertRedirect('/employee/dashboard');
    }
}
