<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EmployeeJobController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\WorkLogController;
use App\Http\Controllers\JobBatchController;
use App\Http\Controllers\LeaveManagementController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocumentController;



Route::resource('employee-jobs', EmployeeJobController::class);
Route::post('employee-jobs/bulk-delete', [EmployeeJobController::class, 'bulkDelete'])->name('employee-jobs.bulk-delete');
Route::get('employee-jobs/status-counts', [EmployeeJobController::class, 'getStatusCounts'])->name('employee-jobs.status-counts');

Route::get('/', function () {
    return redirect()->route('login');
});

// Test popup route (untuk development)
Route::get('/test-popup', function () {
    return view('test-popup');
})->name('test.popup');

























// Test PDF attendance report
Route::get('/test-pdf-attendance', function () {
    try {
        // Login as admin
        $admin = App\Models\User::where('role', 'admin')->first();
        if ($admin) {
            Auth::login($admin);
        }

        // Get some attendance data
        $attendances = App\Models\Attendance::with('employee')->take(5)->get();

        $data = [
            'attendances' => $attendances,
            'summary' => [
                'total_records' => $attendances->count(),
                'present' => $attendances->where('status', 'present')->count(),
                'absent' => $attendances->where('status', 'absent')->count(),
                'late' => $attendances->where('status', 'late')->count(),
            ]
        ];

        // Test the PDF view
        return view('reports.pdf.attendance', compact('data'));
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'error' => $e->getMessage(),
            'line' => $e->getLine(),
            'file' => basename($e->getFile())
        ]);
    }
});



// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

    // Password Reset Routes
    Route::get('password/reset', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/verify-user', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'verifyUser'])->name('password.verify-user');
    Route::post('password/reset-direct', [App\Http\Controllers\Auth\ForgotPasswordController::class, 'resetPasswordDirect'])->name('password.reset-direct');
    Route::get('password/reset/{token}', [App\Http\Controllers\Auth\ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [App\Http\Controllers\Auth\ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});

// Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard')->middleware('role:admin');
    Route::get('/hr/dashboard', [DashboardController::class, 'hrDashboard'])->name('hr.dashboard')->middleware('role:hr');
    Route::get('/manager/dashboard', [DashboardController::class, 'managerDashboard'])->name('manager.dashboard')->middleware('role:manager');
    Route::get('/employee/dashboard', [DashboardController::class, 'employeeDashboard'])->name('employee.dashboard')->middleware('role:employee');

    // Dashboard API
    Route::get('/api/dashboard-stats', [DashboardController::class, 'getDashboardStats'])->name('dashboard.stats');

    // Document Management Routes
    Route::get('/management-document', [DocumentController::class, 'index'])->name('dokumen.index');
    Route::post('/management-document/store', [DocumentController::class, 'store'])->name('dokumen.store');
    Route::get('/management-document/{id}/edit', [DocumentController::class, 'edit'])->name('dokumen.edit');
    Route::get('/management-document/{id}/download', [DocumentController::class, 'download'])->name('dokumen.download');
    Route::get('/management-document/{id}', [DocumentController::class, 'show'])->name('dokumen.show');
    Route::put('/management-document/{id}', [DocumentController::class, 'update'])->name('dokumen.update');
    Route::delete('/management-document/{id}', [DocumentController::class, 'delete'])->name('dokumen.delete');
});

// Profile Routes - All authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/photo', [ProfileController::class, 'updatePhoto'])->name('profile.update-photo');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.update-password');
});


// Route untuk menampilkan foto profile
Route::get('/profile-photo/{userId}', function($userId) {
    $user = \App\Models\User::find($userId);
    if (!$user || !$user->profile_photo) {
        // Return default avatar
        $name = $user && $user->employee ? $user->employee->name : ($user ? $user->username : 'User');
        return redirect('https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF');
    }

    // Check both shared storage and local storage
    $sharedPath = base_path('../shared-uploads/profiles/' . $user->profile_photo);
    $localPath = storage_path('app/public/' . $user->profile_photo);

    $filePath = null;
    if (file_exists($sharedPath)) {
        $filePath = $sharedPath;
    } elseif (file_exists($localPath)) {
        $filePath = $localPath;
    }

    if (!$filePath) {
        // Return default avatar if file doesn't exist
        $name = $user->employee ? $user->employee->name : $user->username;
        return redirect('https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=7F9CF5&background=EBF4FF');
    }

    // Add cache headers to prevent caching
    return response()->file($filePath, [
        'Cache-Control' => 'no-cache, no-store, must-revalidate',
        'Pragma' => 'no-cache',
        'Expires' => '0'
    ]);
})->name('profile.photo');

// Route untuk mengakses shared uploads
Route::get('/shared-uploads/{path}', function($path) {
    $filePath = base_path('../shared-uploads/' . $path);

    if (!file_exists($filePath)) {
        abort(404);
    }

    return response()->file($filePath, [
        'Cache-Control' => 'public, max-age=3600',
        'Access-Control-Allow-Origin' => '*',
    ]);
})->where('path', '.*')->name('shared.uploads');

// API endpoint for photo sync (from employee-management-api)
Route::post('/api/sync-profile-photo', [ProfileController::class, 'syncProfilePhoto'])->name('api.sync-profile-photo');

// Route untuk mengakses attendance photos dari shared storage
Route::get('/attendance-photo/{filename}', function($filename) {
    // Check both shared storage and old storage
    $sharedPath = base_path('../shared-uploads/attendance/' . $filename);
    $oldPath = public_path('uploads/attendance/' . $filename);

    $filePath = null;
    if (file_exists($sharedPath)) {
        $filePath = $sharedPath;
    } elseif (file_exists($oldPath)) {
        $filePath = $oldPath;
    }

    if (!$filePath) {
        abort(404, 'Attendance photo not found');
    }

    return response()->file($filePath, [
        'Cache-Control' => 'public, max-age=3600',
        'Access-Control-Allow-Origin' => '*',
    ]);
})->name('attendance.photo');



















// Employee Management Routes - Admin and HR only
Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/employees/{employee}', [EmployeeController::class, 'show'])->name('employees.show');
    Route::get('/employees/import', [EmployeeController::class, 'showImportForm'])->name('employees.import');
    Route::post('/employees/import', [EmployeeController::class, 'import'])->name('employees.import.process');
    Route::get('/api/employee-code/next', [EmployeeController::class, 'getNextEmployeeCode'])->name('employees.next-code');
});

// Employee Edit/Delete - Admin only
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

});

Route::get('/leave-management', [LeaveManagementController::class, 'index'])->name('leavemanagement.index');


// Attendance Management Routes - Admin, HR, and Manager
Route::middleware(['auth', 'role:admin,hr,manager'])->group(function () {
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/create', [AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{attendance}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendance.edit');
    Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])->name('attendance.destroy');
    Route::get('/attendance-report', [AttendanceController::class, 'report'])->name('attendance.report');
    Route::get('/attendance/analytics/{employee}', [AttendanceController::class, 'getEmployeeAnalytics'])->name('attendance.analytics');
    Route::get('/test-analytics', function() { return view('test-analytics'); });
});



// Quick Check-in/Check-out for all authenticated users
Route::middleware('auth')->group(function () {
    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkin');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkout');
});

// Leave Management Routes - All authenticated users can view/create, Admin/HR/Manager can manage
Route::middleware('auth')->group(function () {
    Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
    Route::get('/leave/create', [LeaveController::class, 'create'])->name('leave.create');
    Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
    Route::get('/leave/{leave}', [LeaveController::class, 'show'])->name('leave.show');
    Route::get('/leave/{leave}/edit', [LeaveController::class, 'edit'])->name('leave.edit');
    Route::put('/leave/{leave}', [LeaveController::class, 'update'])->name('leave.update');
    Route::delete('/leave/{leave}', [LeaveController::class, 'destroy'])->name('leave.destroy');

    // Image management routes
    Route::delete('/leave/{leave}/images/{index}', [LeaveController::class, 'deleteImage'])->name('leave.image.delete');
});

// Leave Approval Routes - Admin/HR/Manager only
Route::middleware(['auth', 'role:admin,hr,manager'])->group(function () {
    Route::get('/leave/admin-dashboard', [LeaveController::class, 'adminDashboard'])->name('leave.admin-dashboard');
    Route::get('/leave/debug', function() {
        return view('leave.debug');
    })->name('leave.debug');
    Route::get('/leave/test-actions', function() {
        return view('leave.test-actions');
    })->name('leave.test-actions');
    Route::get('/leave/debug-actions', function() {
        return view('leave.debug-actions');
    })->name('leave.debug-actions');

    // 🧪 TEST ROUTES for debugging
    Route::get('/leave/test-approve/{leave}', function(\App\Models\Leave $leave) {
        if (!Auth::user()->hasRole(['admin', 'hr', 'manager'])) {
            return response()->json(['error' => 'Permission denied'], 403);
        }

        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => 'Test approval from route'
        ]);

        return redirect()->route('leave.index')->with('success', 'Leave approved successfully via test route!');
    })->name('leave.test-approve');

    Route::get('/leave/test-reject/{leave}', function(\App\Models\Leave $leave) {
        if (!Auth::user()->hasRole(['admin', 'hr', 'manager'])) {
            return response()->json(['error' => 'Permission denied'], 403);
        }

        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'admin_notes' => 'Test rejection from route'
        ]);

        return redirect()->route('leave.index')->with('success', 'Leave rejected successfully via test route!');
    })->name('leave.test-reject');
    Route::post('/leave/{leave}/approve', [LeaveController::class, 'approve'])->name('leave.approve');
    Route::post('/leave/{leave}/reject', [LeaveController::class, 'reject'])->name('leave.reject');
    Route::post('/leave/bulk-approve', [LeaveController::class, 'bulkApprove'])->name('leave.bulk-approve');
    Route::post('/leave/bulk-reject', [LeaveController::class, 'bulkReject'])->name('leave.bulk-reject');
    Route::post('/leave/bulk-delete', [LeaveController::class, 'bulkDelete'])->name('leave.bulk-delete');

    // Test route to verify system functionality
    Route::get('/leave/system-test', function() {
        $user = Auth::user();
        $leaves = \App\Models\Leave::with('employee')->where('status', 'pending')->take(5)->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Leave management system is working properly',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'role' => $user->role,
                'hasManagePermission' => $user->hasRole(['admin', 'hr', 'manager'])
            ],
            'pending_leaves_count' => $leaves->count(),
            'routes' => [
                'approve' => route('leave.approve', 1),
                'reject' => route('leave.reject', 1),
                'index' => route('leave.index')
            ]
        ]);
    })->name('leave.system-test');

    // Debug route for testing reject functionality
    Route::post('/leave/debug-reject/{leave}', function(Request $request, \App\Models\Leave $leave) {
        try {
            $user = Auth::user();

            return response()->json([
                'status' => 'debug',
                'leave' => [
                    'id' => $leave->id,
                    'status' => $leave->status,
                    'employee_id' => $leave->employee_id,
                    'employee_name' => $leave->employee->name ?? 'N/A',
                    'leave_type' => $leave->leave_type,
                    'leave_type_display' => $leave->leave_type_display,
                ],
                'user' => [
                    'id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'hasRole' => $user->hasRole(['admin', 'hr', 'manager'])
                ],
                'request_data' => $request->all(),
                'validation_rules' => [
                    'admin_notes' => 'required|string|max:500',
                    'alternative_suggestions' => 'nullable|string|max:500'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
        }
    })->name('leave.debug-reject');
});

// Work Logs Management Routes - All authenticated users can view/create, Admin/HR/Manager can manage all
Route::middleware('auth')->group(function () {
    Route::get('/worklogs', [WorkLogController::class, 'index'])->name('worklogs.index');
    Route::get('/worklogs/create', [WorkLogController::class, 'create'])->name('worklogs.create');
    Route::post('/worklogs', [WorkLogController::class, 'store'])->name('worklogs.store');
    Route::get('/worklogs/{worklog}', [WorkLogController::class, 'show'])->name('worklogs.show');
    Route::get('/worklogs/{worklog}/edit', [WorkLogController::class, 'edit'])->name('worklogs.edit');
    Route::put('/worklogs/{worklog}', [WorkLogController::class, 'update'])->name('worklogs.update');
    Route::delete('/worklogs/{worklog}', [WorkLogController::class, 'destroy'])->name('worklogs.destroy');
    Route::get('/worklogs-report', [WorkLogController::class, 'report'])->name('worklogs.report');
    Route::post('/worklogs/quick-add', [WorkLogController::class, 'quickAdd'])->name('worklogs.quickadd');
    Route::patch('/worklogs/{worklog}/status', [WorkLogController::class, 'updateStatus'])->name('worklogs.updatestatus');
});

// Job Batches Routes - Admin and HR only
Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::resource('job-batches', JobBatchController::class);
    Route::patch('/job-batches/{jobBatch}/cancel', [JobBatchController::class, 'cancel'])->name('job-batches.cancel');
    Route::get('/api/job-batches/employee/{employee}', [JobBatchController::class, 'getByEmployee'])->name('job-batches.by-employee');
    Route::post('/job-batches/bulk-delete', [JobBatchController::class, 'bulkDelete'])->name('job-batches.bulk-delete');
});

// Job Schedule Routes - All authenticated users (employees can view their own schedule)
Route::middleware(['auth'])->group(function () {
    Route::get('/job-schedule', [JobBatchController::class, 'schedule'])->name('job-batches.schedule');


    // Job Management Routes (using job_batches table)
    Route::post('/my-jobs', [JobBatchController::class, 'storeJob'])->name('my-jobs.store');
    Route::put('/my-jobs/{id}', [JobBatchController::class, 'updateJob'])->name('my-jobs.update');
    Route::post('/my-jobs/{id}/progress', [JobBatchController::class, 'updateJobProgress'])->name('my-jobs.progress');
    Route::delete('/my-jobs/{id}', [JobBatchController::class, 'deleteJob'])->name('my-jobs.delete');
});

// Reports Routes - Admin and HR only
Route::middleware(['auth', 'role:admin,hr'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/comprehensive', [ReportController::class, 'comprehensive'])->name('reports.comprehensive');
    Route::get('/reports/attendance', [ReportController::class, 'attendance'])->name('reports.attendance');
    Route::get('/reports/work-logs', [ReportController::class, 'workLogs'])->name('reports.work-logs');
    Route::get('/reports/jobs', [ReportController::class, 'jobs'])->name('reports.jobs');
    Route::get('/reports/leaves', [ReportController::class, 'leaves'])->name('reports.leaves');
    Route::post('/reports/clear-cache', [ReportController::class, 'clearCache'])->name('reports.clear-cache');
});

// Debug route for testing attachment URLs
Route::get('/debug/attachments', function() {
    $leaves = \App\Models\Leave::whereNotNull('attachment')->get();

    $debug = [];
    foreach ($leaves as $leave) {
        $debug[] = [
            'id' => $leave->id,
            'attachment' => $leave->attachment,
            'attachment_url' => $leave->attachment_url,
            'exists' => $leave->attachmentExists(),
            'size' => $leave->getAttachmentSize(),
        ];
    }

    return response()->json($debug);
})->middleware('auth');
