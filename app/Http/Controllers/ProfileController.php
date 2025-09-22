<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\User;
use App\Models\Employee;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user's profile.
     */
    public function show()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->route('dashboard')
                ->with('error', 'Employee profile not found. Please contact administrator.');
        }

        return view('profile.show', compact('user', 'employee'));
    }

    /**
     * Show the form for editing the user's profile.
     */
    public function edit()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->route('dashboard')
                ->with('error', 'Employee profile not found. Please contact administrator.');
        }

        return view('profile.edit', compact('user', 'employee'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        // Update employee information
        if ($employee) {
            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'department' => $request->department,
                'position' => $request->position,
            ]);
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Update the user's profile photo.
     */
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'profile_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        // Delete old photo if exists (check both shared and local storage)
        if ($user->profile_photo) {
            $sharedPath = 'profiles/' . $user->profile_photo;
            $localPath = $user->profile_photo;

            // Try to delete from shared storage first
            if (Storage::disk('shared')->exists($sharedPath)) {
                Storage::disk('shared')->delete($sharedPath);
            } elseif (Storage::disk('public')->exists($localPath)) {
                Storage::disk('public')->delete($localPath);
            }
        }

        // Store new photo with unique name in shared storage
        $file = $request->file('profile_photo');
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('profiles', $filename, 'shared');

        // Update user record with just the filename
        $user->update([
            'profile_photo' => $filename,
        ]);

        // Clear any potential cache
        $user->refresh();

        Log::info('Profile photo updated', [
            'user_id' => $user->id,
            'filename' => $filename,
            'path' => $path,
            'full_path' => base_path('../shared-uploads/' . $path),
            'file_exists' => file_exists(base_path('../shared-uploads/' . $path)),
        ]);

        // Notify API about the photo update
        $this->notifyApiPhotoUpdate($user->id, $filename);

        // Check if request is AJAX
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Profile photo updated successfully!',
                'photo_url' => route('profile.photo', $user->id) . '?v=' . time(),
                'user_id' => $user->id
            ]);
        }

        return redirect()->route('profile.show')
            ->with('success', 'Profile photo updated successfully!');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('profile.show')
            ->with('success', 'Password updated successfully.');
    }

    /**
     * Notify API about photo update
     */
    private function notifyApiPhotoUpdate($userId, $filename)
    {
        try {
            $apiUrl = env('API_URL', 'http://localhost:3000');

            Log::info('Notifying API about photo update', [
                'user_id' => $userId,
                'filename' => $filename,
                'api_url' => $apiUrl
            ]);

            $response = Http::timeout(5)->post($apiUrl . '/api/sync-profile-photo', [
                'user_id' => $userId,
                'filename' => $filename,
                'source' => 'backoffice'
            ]);

            if ($response->successful()) {
                Log::info('API notification successful', ['response' => $response->json()]);
            } else {
                Log::warning('API notification failed', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::warning('Failed to notify API about photo update', [
                'error' => $e->getMessage(),
                'user_id' => $userId,
                'filename' => $filename
            ]);
        }
    }

    /**
     * Sync profile photo from API
     */
    public function syncProfilePhoto(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|integer',
                'filename' => 'required|string',
                'source' => 'required|string'
            ]);

            $userId = $request->input('user_id');
            $filename = $request->input('filename');
            $source = $request->input('source');

            Log::info('Received photo sync from API', [
                'user_id' => $userId,
                'filename' => $filename,
                'source' => $source
            ]);

            $user = User::find($userId);
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            // Update user record
            $user->update([
                'profile_photo' => $filename
            ]);

            Log::info('Profile photo synced successfully', [
                'user_id' => $userId,
                'filename' => $filename
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Profile photo synced successfully',
                'data' => [
                    'user_id' => $userId,
                    'filename' => $filename,
                    'source' => $source
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Error syncing profile photo', [
                'error' => $e->getMessage(),
                'request' => $request->all()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Internal server error',
                'error' => app()->environment('local') ? $e->getMessage() : null
            ], 500);
        }
    }
}
