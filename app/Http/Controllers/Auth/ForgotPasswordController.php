<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Verify user by username and show account information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function verifyUser(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
        ], [
            'username.required' => 'Username is required.',
        ]);

        // Find user by username
        $user = \App\Models\User::where('username', $request->username)->first();

        if (!$user) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'We could not find a user with that username.']);
        }

        // Check if user is active
        if (!$user->is_active) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'This account is currently inactive. Please contact support.']);
        }

        // Check if user has employee record
        if (!$user->employee) {
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Account information is incomplete. Please contact support.']);
        }

        \Log::info('Password reset user verification', [
            'username' => $request->username,
            'user_id' => $user->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Show account verification page
        return view('auth.passwords.verify', compact('user'));
    }

    /**
     * Reset password directly without email verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPasswordDirect(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'password.required' => 'Password is required.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.min' => 'Password must be at least 8 characters.',
            'user_id.required' => 'User ID is required.',
            'user_id.exists' => 'Invalid user.',
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);

        // Check if user is still active
        if (!$user->is_active) {
            return back()->withErrors(['general' => 'This account is currently inactive. Please contact support.']);
        }

        // Update password
        $user->update([
            'password' => \Hash::make($request->password),
            'remember_token' => \Str::random(60),
        ]);

        \Log::info('Password reset completed', [
            'user_id' => $user->id,
            'username' => $user->username,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent()
        ]);

        // Log the user in
        \Auth::login($user);

        return redirect()->route('dashboard')
                        ->with('login_success', true)
                        ->with('user_name', $user->employee->name ?? $user->username)
                        ->with('success_message', 'Your password has been reset successfully! Welcome back.');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', 'We have emailed your password reset link! Please check your email and follow the instructions to reset your password.');
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'Unable to send password reset link. Please try again later or contact support.']);
    }

    /**
     * Get the needed authentication credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        // Since we're using employee email, we need to get the user's email
        $user = \App\Models\User::whereHas('employee', function($query) use ($request) {
            $query->where('email', $request->email);
        })->first();

        return $user ? ['email' => $user->employee->email] : ['email' => $request->email];
    }
}
