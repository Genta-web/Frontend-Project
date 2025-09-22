<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmployeeJob;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EmployeeJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = EmployeeJob::with(['employee', 'assignedBy', 'reviewedBy']);

        // If user is employee, show only their jobs
        if ($user->hasRole('employee') && $user->employee) {
            $query->forEmployee($user->employee->id);
        }

        // Admin/HR can see all jobs, but can filter by employee
        if ($user->hasRole('admin') || $user->hasRole('hr')) {
            if ($request->has('employee_id') && $request->employee_id) {
                $query->forEmployee($request->employee_id);
            }
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->withStatus($request->status);
        }

        // Filter by priority
        if ($request->has('priority') && $request->priority) {
            $query->withPriority($request->priority);
        }

        // Search by title or description
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Date filters
        if ($request->has('due_date_filter')) {
            switch ($request->due_date_filter) {
                case 'overdue':
                    $query->overdue();
                    break;
                case 'today':
                    $query->dueToday();
                    break;
                case 'this_week':
                    $query->dueThisWeek();
                    break;
            }
        }

        $employeeJobs = $query->orderBy('due_date', 'asc')
                             ->orderBy('priority', 'desc')
                             ->paginate(15);

        // Get employees for filter (admin/hr only)
        $employees = collect();
        if ($user->hasRole('admin') || $user->hasRole('hr')) {
            $employees = Employee::where('status', 'active')->get();
        }

        // Get status counts for bulk actions (create a fresh query to get accurate counts)
        $baseQuery = EmployeeJob::query();

        // Apply same user restrictions for counts
        if ($user->hasRole('employee') && $user->employee) {
            $baseQuery->forEmployee($user->employee->id);
        }

        $statusCounts = [
            'total' => $baseQuery->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
            'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
        ];

        return view('employee-jobs.index', compact('employeeJobs', 'employees', 'statusCounts'));
    }

    /**
     * Get status counts for AJAX requests
     */
    public function getStatusCounts(Request $request)
    {
        $user = Auth::user();
        $baseQuery = EmployeeJob::query();

        // Apply same user restrictions for counts
        if ($user->hasRole('employee') && $user->employee) {
            $baseQuery->forEmployee($user->employee->id);
        }

        $statusCounts = [
            'total' => $baseQuery->count(),
            'pending' => (clone $baseQuery)->where('status', 'pending')->count(),
            'in_progress' => (clone $baseQuery)->where('status', 'in_progress')->count(),
            'completed' => (clone $baseQuery)->where('status', 'completed')->count(),
            'cancelled' => (clone $baseQuery)->where('status', 'cancelled')->count(),
        ];

        return response()->json([
            'success' => true,
            'statusCounts' => $statusCounts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // Get employees for assignment (admin/hr can assign to anyone, employee can only create for themselves)
        $employees = collect();
        if ($user->hasRole('admin') || $user->hasRole('hr')) {
            $employees = Employee::where('status', 'active')->get();
        } elseif ($user->hasRole('employee') && $user->employee) {
            $employees = collect([$user->employee]);
        }

        return view('employee-jobs.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'required|date|after_or_equal:today',
            'due_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // Employee can only create jobs for themselves
        if ($user->hasRole('employee') && $user->employee) {
            $validated['employee_id'] = $user->employee->id;
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('employee-jobs', $filename, 'public');
            $validated['attachment'] = $path;
        }

        $validated['assigned_by'] = $user->id;

        EmployeeJob::create($validated);

        return redirect()->route('employee-jobs.index')
                        ->with('success', 'Job created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(EmployeeJob $employeeJob)
    {
        $user = Auth::user();

        // Check permission
        if ($user->hasRole('employee') && $user->employee && $employeeJob->employee_id !== $user->employee->id) {
            abort(403, 'Unauthorized access to this job.');
        }

        $employeeJob->load(['employee', 'assignedBy', 'reviewedBy']);

        return view('employee-jobs.show', compact('employeeJob'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EmployeeJob $employeeJob)
    {
        $user = Auth::user();

        // Check permission
        if ($user->hasRole('employee') && $user->employee && $employeeJob->employee_id !== $user->employee->id) {
            abort(403, 'Unauthorized access to this job.');
        }

        $employees = collect();
        if ($user->hasRole('admin') || $user->hasRole('hr')) {
            $employees = Employee::where('status', 'active')->get();
        } elseif ($user->hasRole('employee') && $user->employee) {
            $employees = collect([$user->employee]);
        }

        return view('employee-jobs.edit', compact('employeeJob', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EmployeeJob $employeeJob)
    {
        $user = Auth::user();

        // Check permission
        if ($user->hasRole('employee') && $user->employee && $employeeJob->employee_id !== $user->employee->id) {
            abort(403, 'Unauthorized access to this job.');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'completed_date' => 'nullable|date',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        // Employee can only update their own jobs
        if ($user->hasRole('employee') && $user->employee) {
            $validated['employee_id'] = $user->employee->id;
        }

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file
            if ($employeeJob->attachment) {
                Storage::disk('public')->delete($employeeJob->attachment);
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('employee-jobs', $filename, 'public');
            $validated['attachment'] = $path;
        }

        // Auto-set completed_date if status is completed
        if ($validated['status'] === 'completed' && !$validated['completed_date']) {
            $validated['completed_date'] = now()->toDateString();
            $validated['progress_percentage'] = 100;
        }

        $employeeJob->update($validated);

        return redirect()->route('employee-jobs.index')
                        ->with('success', 'Job updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EmployeeJob $employeeJob)
    {
        $user = Auth::user();

        // Only admin can delete jobs
        if (!$user->hasRole('admin')) {
            abort(403, 'Only administrators can delete jobs.');
        }

        // Delete attachment file
        if ($employeeJob->attachment) {
            Storage::disk('public')->delete($employeeJob->attachment);
        }

        $employeeJob->delete();

        return redirect()->route('employee-jobs.index')
                        ->with('success', 'Job deleted successfully.');
    }

    /**
     * Update job progress.
     */
    public function updateProgress(Request $request, $id)
    {
        $employeeJob = EmployeeJob::findOrFail($id);
        $user = Auth::user();

        // Check permission
        if ($user->hasRole('employee') && $user->employee && $employeeJob->employee_id !== $user->employee->id) {
            abort(403, 'Unauthorized access to this job.');
        }

        $validated = $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Auto-set completed_date if status is completed
        if ($validated['status'] === 'completed') {
            $validated['completed_date'] = now()->toDateString();
            $validated['progress_percentage'] = 100;
        }

        $employeeJob->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully.',
            'job' => $employeeJob->fresh()
        ]);
    }
    /**
     * Review a job (admin/hr only).
     */


    /**
     * Bulk delete employee jobs.
     */
    public function bulkDelete(Request $request)
    {
        // Check if user has permission to delete jobs
        if (!Auth::user()->hasRole(['admin', 'hr'])) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to delete jobs.'
            ], 403);
        }

        try {
            $type = $request->input('type');
            $deletedCount = 0;
            $user = Auth::user();

            // Create base query with user restrictions
            $baseQuery = EmployeeJob::query();

            // If user is employee, restrict to their jobs only (though employees shouldn't access bulk delete)
            if ($user->hasRole('employee') && $user->employee) {
                $baseQuery->forEmployee($user->employee->id);
            }

            switch ($type) {
                case 'selected':
                    $ids = $request->input('ids', []);
                    if (empty($ids)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No jobs selected for deletion.'
                        ], 400);
                    }

                    // Get jobs and delete their attachments
                    $jobs = EmployeeJob::whereIn('id', $ids)->get();
                    foreach ($jobs as $job) {
                        if ($job->attachment) {
                            Storage::disk('public')->delete($job->attachment);
                        }
                    }

                    $deletedCount = EmployeeJob::whereIn('id', $ids)->count();
                    EmployeeJob::whereIn('id', $ids)->delete();

                    \Log::info('Bulk delete selected employee jobs', [
                        'user_id' => Auth::id(),
                        'deleted_ids' => $ids,
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip()
                    ]);
                    break;

                case 'pending':
                    // Get pending jobs with user restrictions and delete their attachments
                    $jobs = (clone $baseQuery)->where('status', 'pending')->get();
                    if ($jobs->isEmpty()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No pending jobs found to delete.'
                        ], 400);
                    }

                    foreach ($jobs as $job) {
                        if ($job->attachment) {
                            Storage::disk('public')->delete($job->attachment);
                        }
                    }

                    $deletedCount = (clone $baseQuery)->where('status', 'pending')->count();
                    (clone $baseQuery)->where('status', 'pending')->delete();

                    \Log::info('Bulk delete pending employee jobs', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip(),
                        'user_role' => $user->roles->pluck('name')->toArray()
                    ]);
                    break;

                case 'in_progress':
                    // Get in progress jobs with user restrictions and delete their attachments
                    $jobs = (clone $baseQuery)->where('status', 'in_progress')->get();
                    if ($jobs->isEmpty()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No in progress jobs found to delete.'
                        ], 400);
                    }

                    foreach ($jobs as $job) {
                        if ($job->attachment) {
                            Storage::disk('public')->delete($job->attachment);
                        }
                    }

                    $deletedCount = (clone $baseQuery)->where('status', 'in_progress')->count();
                    (clone $baseQuery)->where('status', 'in_progress')->delete();

                    \Log::info('Bulk delete in progress employee jobs', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip(),
                        'user_role' => $user->roles->pluck('name')->toArray()
                    ]);
                    break;

                case 'completed':
                    // Get completed jobs with user restrictions and delete their attachments
                    $jobs = (clone $baseQuery)->where('status', 'completed')->get();
                    if ($jobs->isEmpty()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No completed jobs found to delete.'
                        ], 400);
                    }

                    foreach ($jobs as $job) {
                        if ($job->attachment) {
                            Storage::disk('public')->delete($job->attachment);
                        }
                    }

                    $deletedCount = (clone $baseQuery)->where('status', 'completed')->count();
                    (clone $baseQuery)->where('status', 'completed')->delete();

                    \Log::info('Bulk delete completed employee jobs', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip(),
                        'user_role' => $user->roles->pluck('name')->toArray()
                    ]);
                    break;

                case 'cancelled':
                    // Get cancelled jobs with user restrictions and delete their attachments
                    $jobs = (clone $baseQuery)->where('status', 'cancelled')->get();
                    if ($jobs->isEmpty()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No cancelled jobs found to delete.'
                        ], 400);
                    }

                    foreach ($jobs as $job) {
                        if ($job->attachment) {
                            Storage::disk('public')->delete($job->attachment);
                        }
                    }

                    $deletedCount = (clone $baseQuery)->where('status', 'cancelled')->count();
                    (clone $baseQuery)->where('status', 'cancelled')->delete();

                    \Log::info('Bulk delete cancelled employee jobs', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip(),
                        'user_role' => $user->roles->pluck('name')->toArray()
                    ]);
                    break;

                case 'all':
                    // Get all jobs with user restrictions and delete their attachments
                    $jobs = (clone $baseQuery)->get();
                    if ($jobs->isEmpty()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No jobs found to delete.'
                        ], 400);
                    }

                    foreach ($jobs as $job) {
                        if ($job->attachment) {
                            Storage::disk('public')->delete($job->attachment);
                        }
                    }

                    $deletedCount = (clone $baseQuery)->count();

                    // Use delete() instead of truncate() to respect user restrictions
                    (clone $baseQuery)->delete();

                    \Log::warning('Bulk delete ALL employee jobs', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip(),
                        'user_role' => $user->roles->pluck('name')->toArray(),
                        'warning' => 'ALL ACCESSIBLE EMPLOYEE JOBS DELETED'
                    ]);
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid delete type specified.'
                    ], 400);
            }

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} job(s).",
                'deleted_count' => $deletedCount,
                'type' => $type
            ]);

        } catch (\Exception $e) {
            \Log::error('Bulk delete employee jobs failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'type' => $request->input('type'),
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete jobs. Please try again.'
            ], 500);
        }
    }
}
