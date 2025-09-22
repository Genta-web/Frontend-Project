<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('employee_code', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('position', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by department
        if ($request->has('department') && $request->department) {
            $query->where('department', $request->department);
        }

        // Get per_page parameter with default value of 10
        $perPage = $request->get('per_page', 10);
        $perPage = in_array($perPage, [10, 25, 50, 100]) ? $perPage : 10;

        $employees = $query->with('user')->orderBy('created_at', 'desc')->paginate($perPage);

        // Get unique departments for filter dropdown
        $departments = Employee::distinct()->pluck('department')->filter();

        return view('employees.index', compact('employees', 'departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_code' => 'required|string|max:255|unique:employees',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:employees',
            'phone' => 'nullable|string|max:255',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,inactive',
            'create_user_account' => 'boolean',
            'username' => 'required_if:create_user_account,1|string|max:255|unique:users',
            'password' => 'required_if:create_user_account,1|string|min:8',
            'role' => 'required_if:create_user_account,1|in:admin,hr,manager,employee',
        ]);

        $employee = Employee::create($validated);

        // Create user account if requested
        if ($request->boolean('create_user_account')) {
            User::create([
                'employee_id' => $employee->id,
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'role' => $validated['role'],
                'is_active' => true,
            ]);
        }

        return redirect()->route('employees.index')
            ->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        $employee->load(['user', 'attendance', 'workLogs']);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $employee->load('user');
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'employee_code' => [
                'required',
                'string',
                'max:255',
                Rule::unique('employees')->ignore($employee->id),
            ],
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('employees')->ignore($employee->id),
            ],
            'phone' => 'nullable|string|max:255',
            'department' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'hire_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $employee->update($validated);

        return redirect()->route('employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employee $employee)
    {
        // Delete associated user account if exists
        if ($employee->user) {
            $employee->user->delete();
        }

        $employee->delete();

        return redirect()->route('employees.index')
            ->with('success', 'Employee deleted successfully.');
    }

    /**
     * Generate next employee code with proper uniqueness check.
     */
    public function generateEmployeeCode()
    {
        $maxAttempts = 100;
        $attempt = 0;

        do {
            // Get the highest existing employee code number
            $lastCode = Employee::where('employee_code', 'LIKE', 'EMP%')
                               ->where('employee_code', 'REGEXP', '^EMP[0-9]+$')
                               ->orderByRaw('CAST(SUBSTRING(employee_code, 4) AS UNSIGNED) DESC')
                               ->value('employee_code');

            if ($lastCode) {
                $lastNumber = (int)substr($lastCode, 3);
                $nextNumber = $lastNumber + 1;
            } else {
                $nextNumber = 1;
            }

            $employeeCode = 'EMP' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            // Check if this code already exists
            $exists = Employee::where('employee_code', $employeeCode)->exists();

            if (!$exists) {
                return $employeeCode;
            }

            // If it exists, try the next number
            $attempt++;

        } while ($attempt < $maxAttempts);

        // Fallback: use timestamp-based code if all attempts fail
        return 'EMP' . time();
    }

    /**
     * Get next employee code via AJAX.
     */
    public function getNextEmployeeCode()
    {
        return response()->json(['code' => $this->generateEmployeeCode()]);
    }

    /**
     * Show the import form.
     */
    public function showImportForm()
    {
        return view('employees.import');
    }

    /**
     * Process the import.
     */
    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required|file|mimes:csv,xlsx,xls|max:2048'
        ]);

        // For now, just return success message
        // TODO: Implement actual import logic
        return redirect()->route('employees.index')
            ->with('success', 'Import functionality will be implemented soon.');
    }
}


