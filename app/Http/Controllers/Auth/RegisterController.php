<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:employees'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'department' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        try {
            // Use database transaction to ensure data consistency
            return \DB::transaction(function () use ($data) {
                // Generate unique employee code
                $employeeCode = $this->generateEmployeeCode();

                // Double-check uniqueness before creating
                $maxRetries = 5;
                $retries = 0;

                while (Employee::where('employee_code', $employeeCode)->exists() && $retries < $maxRetries) {
                    $employeeCode = $this->generateEmployeeCode();
                    $retries++;
                }

                if ($retries >= $maxRetries) {
                    throw new \Exception('Unable to generate unique employee code after multiple attempts.');
                }

                // Create employee record
                $employee = Employee::create([
                    'employee_code' => $employeeCode,
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'department' => $data['department'],
                    'position' => $data['position'],
                    'hire_date' => now(),
                    'status' => 'active',
                ]);

                // Create user account linked to employee
                return User::create([
                    'employee_id' => $employee->id,
                    'username' => $data['username'],
                    'password' => Hash::make($data['password']),
                    'role' => 'employee',
                    'is_active' => true,
                ]);
            });

        } catch (\Exception $e) {
            \Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'data' => array_except($data, ['password']), // Don't log password
                'trace' => $e->getTraceAsString()
            ]);

            throw $e;
        }
    }

    /**
     * Generate next employee code with proper uniqueness check.
     */
    private function generateEmployeeCode()
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
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        try {
            $this->validator($request->all())->validate();

            $user = $this->create($request->all());

            $this->guard()->login($user);

            return $this->registered($request, $user)
                            ?: redirect($this->redirectPath())
                                ->with('login_success', true)
                                ->with('user_name', $user->display_name ?? $user->username)
                                ->with('redirect_url', $this->redirectPath());

        } catch (\Illuminate\Database\QueryException $e) {
            // Handle database constraint violations
            if ($e->getCode() == 23000) {
                if (strpos($e->getMessage(), 'employee_code_unique') !== false) {
                    return redirect()->back()
                                   ->withInput($request->except('password', 'password_confirmation'))
                                   ->withErrors(['employee_code' => 'Employee code already exists. Please try again.']);
                } elseif (strpos($e->getMessage(), 'employees_email_unique') !== false) {
                    return redirect()->back()
                                   ->withInput($request->except('password', 'password_confirmation'))
                                   ->withErrors(['email' => 'Email address is already registered.']);
                } elseif (strpos($e->getMessage(), 'users_username_unique') !== false) {
                    return redirect()->back()
                                   ->withInput($request->except('password', 'password_confirmation'))
                                   ->withErrors(['username' => 'Username is already taken.']);
                }
            }

            \Log::error('Registration database error', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'user_data' => array_except($request->all(), ['password', 'password_confirmation'])
            ]);

            return redirect()->back()
                           ->withInput($request->except('password', 'password_confirmation'))
                           ->withErrors(['general' => 'Registration failed due to a database error. Please try again.']);

        } catch (\Exception $e) {
            \Log::error('Registration general error', [
                'error' => $e->getMessage(),
                    'user_data' => array_except($request->all(), ['password', 'password_confirmation'])
            ]);

            return redirect()->back()
                           ->withInput($request->except('password', 'password_confirmation'))
                           ->withErrors(['general' => 'Registration failed. Please try again or contact support.']);
        }
    }
}
