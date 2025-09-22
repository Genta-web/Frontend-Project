<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobBatch;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;

class JobBatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        // Admin/HR can see all employee jobs, others see none
        if ($user->hasRole('admin') || $user->hasRole('hr')) {
            $employeeJobQuery = JobBatch::with(['employee', 'reviewedBy'])
                                       ->whereNull('batch_type'); // Only individual jobs

            // Filter by employee if specified
            if ($request->has('employee_id') && $request->employee_id) {
                $employeeJobQuery->where('employee_id', $request->employee_id);
            }

            // Filter by status if specified
            if ($request->has('job_status') && $request->job_status) {
                $employeeJobQuery->withJobStatus($request->job_status);
            }

            // Filter by priority if specified
            if ($request->has('job_priority') && $request->job_priority) {
                $employeeJobQuery->withPriority($request->job_priority);
            }

            // Search by name or description
            if ($request->has('job_search') && $request->job_search) {
                $search = $request->job_search;
                $employeeJobQuery->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%");
                });
            }

            // Date range filter
            if ($request->has('date_from') && $request->date_from) {
                $employeeJobQuery->where('start_date', '>=', $request->date_from);
            }

            if ($request->has('date_to') && $request->date_to) {
                $employeeJobQuery->where('due_date', '<=', $request->date_to);
            }

            $employeeJobs = $employeeJobQuery->orderBy('due_date', 'asc')->paginate(15);
        } else {
            // Non-admin users see no jobs in this view
            $employeeJobs = collect()->paginate(15);
        }

        $employees = Employee::where('status', 'active')->get();

        return view('job-batches.index', compact('employeeJobs', 'employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::where('status', 'active')->get();
        return view('job-batches.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'nullable|exists:employees,id',
            'batch_type' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'metadata' => 'nullable|json',
            'total_jobs' => 'required|integer|min:1',
            'options' => 'nullable|json',
        ]);

        $validated['id'] = \Illuminate\Support\Str::uuid()->toString();
        $validated['pending_jobs'] = $validated['total_jobs'];
        $validated['failed_jobs'] = 0;
        $validated['failed_job_ids'] = '[]';
        $validated['created_at'] = now()->timestamp;

        JobBatch::create($validated);

        return redirect()->route('job-batches.index')
                        ->with('success', 'Job batch created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $jobBatch = JobBatch::with('employee')->findOrFail($id);
        return view('job-batches.show', compact('jobBatch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jobBatch = JobBatch::findOrFail($id);
        $employees = Employee::where('status', 'active')->get();
        return view('job-batches.edit', compact('jobBatch', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $jobBatch = JobBatch::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'employee_id' => 'nullable|exists:employees,id',
            'batch_type' => 'required|string|max:100',
            'description' => 'nullable|string|max:1000',
            'metadata' => 'nullable|json',
            'total_jobs' => 'required|integer|min:1',
            'pending_jobs' => 'required|integer|min:0',
            'failed_jobs' => 'required|integer|min:0',
            'options' => 'nullable|json',
        ]);

        $jobBatch->update($validated);

        return redirect()->route('job-batches.index')
                        ->with('success', 'Job batch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $jobBatch = JobBatch::findOrFail($id);
        $jobBatch->delete();

        return redirect()->route('job-batches.index')
                        ->with('success', 'Job batch deleted successfully.');
    }

    /**
     * Cancel a job batch.
     */
    public function cancel(string $id)
    {
        $jobBatch = JobBatch::findOrFail($id);

        if ($jobBatch->isCancelled() || $jobBatch->isCompleted()) {
            return redirect()->back()
                           ->with('error', 'Cannot cancel a job batch that is already completed or cancelled.');
        }

        $jobBatch->update(['cancelled_at' => now()->timestamp]);

        return redirect()->back()
                        ->with('success', 'Job batch cancelled successfully.');
    }

    /**
     * Get job batches for a specific employee (API endpoint).
     */
    public function getByEmployee(Request $request, $employeeId)
    {
        $jobBatches = JobBatch::forEmployee($employeeId)
                             ->orderBy('created_at', 'desc')
                             ->get();

        return response()->json($jobBatches);
    }

    /**
     * Show schedule view for employees to see their assigned jobs and job batches.
     */
    public function schedule(Request $request)
    {
        $user = auth()->user();
        $employee = $user->employee;

        // For admin users, allow viewing without employee record
        if (!$employee && !$user->hasRole('admin')) {
            return redirect()->route('dashboard')
                           ->with('error', 'Employee record not found. Please contact administrator.');
        }

        // If admin and no employee record, we'll handle this differently
        if ($user->hasRole('admin') && !$employee) {
            // Admin can view all jobs or filter by employee
            $targetEmployeeId = $request->get('employee_filter');
            if ($targetEmployeeId) {
                $targetEmployee = Employee::find($targetEmployeeId);
                if ($targetEmployee) {
                    $employee = $targetEmployee;
                }
            }
        }

        // Initialize queries - handle case where employee might be null for admin
        if ($employee) {
            // Get Job Batches for this employee (system batches)
            $jobBatchQuery = JobBatch::forEmployee($employee->id)
                                     ->with('employee')
                                     ->whereNotNull('batch_type'); // Only system job batches

            // Get Employee Jobs for this employee (individual jobs from job_batches table)
            $employeeJobQuery = JobBatch::forEmployee($employee->id)
                                       ->with(['employee', 'reviewedBy'])
                                       ->whereNull('batch_type'); // Individual jobs (no batch_type)
        } else {
            // Admin viewing all jobs
            $jobBatchQuery = JobBatch::with('employee')->whereNotNull('batch_type');
            $employeeJobQuery = JobBatch::with(['employee', 'reviewedBy'])->whereNull('batch_type');
        }

        // Filter Employee Jobs by status if specified
        if ($request->has('job_status') && $request->job_status) {
            $employeeJobQuery->withJobStatus($request->job_status);
        }

        // Filter Employee Jobs by priority if specified
        if ($request->has('job_priority') && $request->job_priority) {
            $employeeJobQuery->withPriority($request->job_priority);
        }

        // Search Employee Jobs by title or description
        if ($request->has('job_search') && $request->job_search) {
            $search = $request->job_search;
            $employeeJobQuery->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter Job Batches by status if specified
        if ($request->has('batch_status') && $request->batch_status) {
            switch ($request->batch_status) {
                case 'pending':
                    $jobBatchQuery->where('pending_jobs', '>', 0)
                          ->whereNull('finished_at')
                          ->whereNull('cancelled_at');
                    break;
                case 'in_progress':
                    $jobBatchQuery->inProgress();
                    break;
                case 'completed':
                    $jobBatchQuery->completed();
                    break;
                case 'cancelled':
                    $jobBatchQuery->whereNotNull('cancelled_at');
                    break;
            }
        }

        // Filter Job Batches by batch type if specified
        if ($request->has('batch_type') && $request->batch_type) {
            $jobBatchQuery->where('batch_type', $request->batch_type);
        }

        // Get data with pagination
        $employeeJobs = $employeeJobQuery->orderBy('due_date', 'asc')->paginate(10, ['*'], 'jobs_page');
        $jobBatches = $jobBatchQuery->orderBy('created_at', 'desc')->paginate(5, ['*'], 'batches_page');

        // Get unique batch types for filter
        if ($employee) {
            $batchTypes = JobBatch::forEmployee($employee->id)
                                  ->select('batch_type')
                                  ->whereNotNull('batch_type')
                                  ->distinct()
                                  ->pluck('batch_type');

            // Statistics for Employee Jobs
            $jobStats = [
                'total' => JobBatch::forEmployee($employee->id)->whereNull('batch_type')->count(),
                'pending' => JobBatch::forEmployee($employee->id)->whereNull('batch_type')->withJobStatus('pending')->count(),
                'in_progress' => JobBatch::forEmployee($employee->id)->whereNull('batch_type')->withJobStatus('in_progress')->count(),
                'completed' => JobBatch::forEmployee($employee->id)->whereNull('batch_type')->withJobStatus('completed')->count(),
                'overdue' => JobBatch::forEmployee($employee->id)->whereNull('batch_type')->overdue()->count(),
            ];

            // Statistics for Job Batches
            $batchStats = [
                'total' => JobBatch::forEmployee($employee->id)->count(),
                'pending' => JobBatch::forEmployee($employee->id)
                                    ->where('pending_jobs', '>', 0)
                                    ->whereNull('finished_at')
                                    ->whereNull('cancelled_at')
                                    ->count(),
                'in_progress' => JobBatch::forEmployee($employee->id)->inProgress()->count(),
                'completed' => JobBatch::forEmployee($employee->id)->completed()->count(),
            ];
        } else {
            // Admin viewing all - get all batch types and stats
            $batchTypes = JobBatch::select('batch_type')
                                  ->whereNotNull('batch_type')
                                  ->distinct()
                                  ->pluck('batch_type');

            $jobStats = [
                'total' => JobBatch::whereNull('batch_type')->count(),
                'pending' => JobBatch::whereNull('batch_type')->withJobStatus('pending')->count(),
                'in_progress' => JobBatch::whereNull('batch_type')->withJobStatus('in_progress')->count(),
                'completed' => JobBatch::whereNull('batch_type')->withJobStatus('completed')->count(),
                'overdue' => JobBatch::whereNull('batch_type')->overdue()->count(),
            ];

            $batchStats = [
                'total' => JobBatch::count(),
                'pending' => JobBatch::where('pending_jobs', '>', 0)
                                    ->whereNull('finished_at')
                                    ->whereNull('cancelled_at')
                                    ->count(),
                'in_progress' => JobBatch::inProgress()->count(),
                'completed' => JobBatch::completed()->count(),
            ];
        }

        // Get employees list for admin
        $employees = collect();
        if ($user->hasRole('admin') || $user->hasRole('hr')) {
            $employees = Employee::where('status', 'active')->get();
        }

        return view('job-batches.schedule', compact('employeeJobs', 'jobBatches', 'batchTypes', 'jobStats', 'batchStats', 'employee', 'employees'));
    }

    /**
     * Store a new job for employee.
     */
    public function storeJob(Request $request)
    {
        $user = auth()->user();
        $employee = $user->employee;

        // Validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'start_date' => 'required|date|after_or_equal:today',
            'due_date' => 'required|date|after_or_equal:start_date',
            'notes' => 'nullable|string',
        ];

        // If admin or hr, allow employee_id selection
        if ($user->hasRole('admin') || $user->hasRole('hr')) {
            $rules['employee_id'] = 'required|exists:employees,id';
        }

        $validated = $request->validate($rules);

        // Determine target employee
        $targetEmployeeId = null;
        if ($user->hasRole('admin') || $user->hasRole('hr')) {
            // Admin/HR can assign to any employee
            $targetEmployeeId = $validated['employee_id'];
        } else {
            // Regular employee can only create for themselves
            if (!$employee) {
                return response()->json(['success' => false, 'message' => 'Employee record not found.'], 403);
            }
            $targetEmployeeId = $employee->id;
        }

        // Create job as JobBatch without batch_type (individual job)
        $job = JobBatch::create([
            'id' => \Illuminate\Support\Str::uuid(),
            'name' => $validated['name'],
            'employee_id' => $targetEmployeeId,
            'description' => $validated['description'],
            'priority' => $validated['priority'],
            'start_date' => $validated['start_date'],
            'due_date' => $validated['due_date'],
            'notes' => $validated['notes'],
            'job_status' => 'pending',
            'progress_percentage' => 0,
            'total_jobs' => 1,
            'pending_jobs' => 1,
            'failed_jobs' => 0,
            'failed_job_ids' => [],
            'created_at' => time(),
            // batch_type is null for individual jobs
        ]);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Job created successfully.', 'job' => $job]);
        }

        return redirect()->route('job-batches.schedule')->with('success', 'Job created successfully.');
    }

    /**
     * Update a job.
     */
    public function updateJob(Request $request, $id)
    {
        $user = auth()->user();
        $employee = $user->employee;

        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee record not found.'], 403);
        }

        $job = JobBatch::where('id', $id)
                      ->where('employee_id', $employee->id)
                      ->whereNull('batch_type')
                      ->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high,urgent',
            'job_status' => 'required|in:pending,in_progress,completed,cancelled',
            'start_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:start_date',
            'progress_percentage' => 'required|integer|min:0|max:100',
            'notes' => 'nullable|string',
        ]);

        // Auto-set completed_date if status is completed
        if ($validated['job_status'] === 'completed') {
            $validated['completed_date'] = now()->toDateString();
            $validated['progress_percentage'] = 100;
            $validated['finished_at'] = time();
            $validated['pending_jobs'] = 0;
        } else {
            $validated['completed_date'] = null;
            $validated['finished_at'] = null;
            $validated['pending_jobs'] = $validated['job_status'] === 'pending' ? 1 : 0;
        }

        $job->update($validated);

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Job updated successfully.', 'job' => $job->fresh()]);
        }

        return redirect()->route('job-batches.schedule')->with('success', 'Job updated successfully.');
    }

    /**
     * Update job progress.
     */
    public function updateJobProgress(Request $request, $id)
    {
        $user = auth()->user();
        $employee = $user->employee;

        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee record not found.'], 403);
        }

        $job = JobBatch::where('id', $id)
                      ->where('employee_id', $employee->id)
                      ->whereNull('batch_type')
                      ->firstOrFail();

        $validated = $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'job_status' => 'required|in:pending,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        // Auto-set completed_date if status is completed
        if ($validated['job_status'] === 'completed') {
            $validated['completed_date'] = now()->toDateString();
            $validated['progress_percentage'] = 100;
            $validated['finished_at'] = time();
            $validated['pending_jobs'] = 0;
        } else {
            $validated['completed_date'] = null;
            $validated['finished_at'] = null;
            $validated['pending_jobs'] = $validated['job_status'] === 'pending' ? 1 : 0;
        }

        $job->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Progress updated successfully.',
            'job' => $job->fresh()
        ]);
    }

    /**
     * Delete a job.
     */
    public function deleteJob($id)
    {
        $user = auth()->user();

        // Only admin can delete jobs
        if (!$user->hasRole('admin')) {
            return response()->json(['success' => false, 'message' => 'Only administrators can delete jobs.'], 403);
        }

        $job = JobBatch::where('id', $id)->whereNull('batch_type')->firstOrFail();

        // Delete attachment file if exists
        if ($job->attachment && \Storage::disk('public')->exists($job->attachment)) {
            \Storage::disk('public')->delete($job->attachment);
        }

        $job->delete();

        return response()->json(['success' => true, 'message' => 'Job deleted successfully.']);
    }



    /**
     * Bulk delete job batches.
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

            switch ($type) {
                case 'selected':
                    $ids = $request->input('ids', []);
                    if (empty($ids)) {
                        return response()->json([
                            'success' => false,
                            'message' => 'No jobs selected for deletion.'
                        ], 400);
                    }

                    $deletedCount = JobBatch::whereIn('id', $ids)->count();
                    JobBatch::whereIn('id', $ids)->delete();

                    \Log::info('Bulk delete selected job batches', [
                        'user_id' => Auth::id(),
                        'deleted_ids' => $ids,
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip()
                    ]);
                    break;

                case 'completed':
                    $deletedCount = JobBatch::where('job_status', 'completed')->count();
                    JobBatch::where('job_status', 'completed')->delete();

                    \Log::info('Bulk delete completed job batches', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip()
                    ]);
                    break;

                case 'cancelled':
                    $deletedCount = JobBatch::where('job_status', 'cancelled')->count();
                    JobBatch::where('job_status', 'cancelled')->delete();

                    \Log::info('Bulk delete cancelled job batches', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip()
                    ]);
                    break;

                case 'all':
                    $deletedCount = JobBatch::count();
                    JobBatch::truncate(); // More efficient for deleting all records

                    \Log::warning('Bulk delete ALL job batches', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip(),
                        'warning' => 'ALL JOB BATCHES DELETED'
                    ]);
                    break;

                default:
                    return response()->json([
                        'success' => false,
                        'message' => 'Invalid delete type specified.'
                    ], 400);
            }

            // Set session success message for Bootstrap alert
            session()->flash('success', "Successfully deleted {$deletedCount} job(s).");

            return response()->json([
                'success' => true,
                'message' => "Successfully deleted {$deletedCount} job(s).",
                'deleted_count' => $deletedCount,
                'type' => $type
            ]);

        } catch (\Exception $e) {
            \Log::error('Bulk delete job batches failed', [
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
