<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        try {
            // Update last login timestamp
            $user->update(['last_login' => now()]);

            // Log successful login
            Log::info('User logged in successfully', [
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);

            // Return to login page with success data for popup
            return back()->with([
                'login_success' => true,
                'user_name' => $user->display_name ?? $user->username,
                'redirect_url' => $this->redirectPath()
            ]);

        } catch (\Exception $e) {
            Log::error('Error during post-login processing', [
                'user_id' => $user->id,
                'error' => $e->getMessage()
            ]);

            // Still redirect even if update fails
            return redirect()->intended($this->redirectPath())->with('success', 'Login berhasil!');
        }
    }

    /**
     * Get the post-login redirect path based on user role.
     *
     * @return string
     */
    public function redirectPath()
    {
        $user = Auth::user();

        if (!$user) {
            return '/login';
        }

        // Role-based redirection
        switch ($user->role) {
            case 'admin':
                return route('admin.dashboard');
            case 'hr':
                return route('hr.dashboard');
            case 'manager':
                return route('manager.dashboard');
            case 'employee':
                return route('employee.dashboard');
            default:
                return route('dashboard');
        }
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $user = \App\Models\User::whereRaw('BINARY username = ?', [$request->username])
            ->where('is_active', true)
            ->first();

        if ($user && \Hash::check($request->password, $user->password)) {
            return Auth::login($user, $request->boolean('remember'));
        }

        return false;
    }


    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $username = $request->input($this->username());
        $user = \App\Models\User::where('username', $username)->first();


        $errorField = $this->username();
        $message = '';

        if (!$user) {
            $message = 'Username not found in the system.';
            Log::warning('Login failed - User not found', [
                'username' => $username,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        } elseif (!$user->is_active) {
            $message = 'Your account is inactive. Please contact the administrator.';
            Log::warning('Login failed - Inactive account', [
                'username' => $username,
                'user_id' => $user->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        } else {
            $message = 'Your password is incorrect.';
            $errorField = 'password';
            Log::warning('Login failed - Wrong password', [
                'username' => $username,
                'user_id' => $user->id,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }

        throw ValidationException::withMessages([
            $errorField => [$message], // Gunakan variabel $errorField yang dinamis
        ]);
    }



    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->id,
                'username' => $user->username,
                'ip' => $request->ip()
            ]);
        }

        $this->guard()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/login')->with('success', 'You have successfully logged out.');
    }

}
