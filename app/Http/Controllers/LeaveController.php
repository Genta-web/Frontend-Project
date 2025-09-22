<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\Employee;
use App\Models\User;

use App\Helpers\LeavePermissionHelper;
use App\Services\ImageService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon; // <--- PASTIKAN BARIS INI ADA

class LeaveController extends Controller
{
    protected $imageService;

    /**
     * Create a new controller instance.
     */
    public function __construct(ImageService $imageService)
    {
        $this->middleware('auth');
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of leave requests.
     */
    public function index(Request $request)
    {
        $query = Leave::with(['employee', 'approvedBy']);

        // Filter leaves based on user permissions
        $query = LeavePermissionHelper::filterLeavesForUser(Auth::user(), $query);

        // Apply filters
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        if ($request->filled('employee_id') && !Auth::user()->isEmployee()) {
            $query->where('employee_id', $request->employee_id);
        }

        if ($request->filled('date_from')) {
            $query->where('start_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->where('end_date', '<=', $request->date_to);
        }

        $leaves = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get employees for filter (admin only)
        $employees = Auth::user()->isEmployee() ? collect() : Employee::where('status', 'active')->orderBy('name')->get();

        // Calculate statistics
        $statsQuery = Leave::query();
        if (Auth::user()->isEmployee()) {
            $statsQuery->where('employee_id', Auth::user()->employee->id);
        }

        $stats = [
            'total_leaves' => $statsQuery->count(),
            'pending_leaves' => (clone $statsQuery)->where('status', 'pending')->count(),
            'approved_leaves' => (clone $statsQuery)->where('status', 'approved')->count(),
            'rejected_leaves' => (clone $statsQuery)->where('status', 'rejected')->count(),
        ];

        // Additional statistics for admin
        if (!Auth::user()->isEmployee()) {
            $stats['today_requests'] = Leave::whereDate('created_at', today())->count();
            $stats['this_week_requests'] = Leave::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();
            $stats['this_month_requests'] = Leave::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
            $stats['urgent_pending'] = Leave::where('status', 'pending')
                ->where('start_date', '<=', now()->addDays(3))
                ->count();
        }

        // Handle AJAX requests for real-time updates
        if ($request->ajax()) {
            return response()->json([
                'pending_count' => $stats['pending_leaves'],
                'total_count' => $stats['total_leaves'],
                'approved_count' => $stats['approved_leaves'],
                'rejected_count' => $stats['rejected_leaves'],
            ]);
        }

        // Get user context for permissions
        $userContext = LeavePermissionHelper::getUserContext(Auth::user());

        return view('leave.index', compact('leaves', 'employees', 'stats', 'userContext'));
    }







    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        // If user is employee, only allow creating leave for themselves
        if (Auth::user()->isEmployee()) {
            if (!Auth::user()->employee) {
                return redirect()->route('dashboard')->with('error', 'Employee record not found for your account.');
            }
            $employees = collect([Auth::user()->employee]);
        }

        return view('leave.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|in:annual,sick,emergency,maternity,paternity,personal',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp|max:5120',
            'images' => 'nullable|array|max:5',
            'images.*' => 'file|mimes:jpg,jpeg,png,gif,webp|max:5120'
        ]);

        // Calculate total days
        $validated['total_days'] = Leave::calculateTotalDays($validated['start_date'], $validated['end_date']);

        // Handle legacy attachment upload (for backward compatibility)
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $path = $file->storeAs('leaves', time() . '_' . $file->getClientOriginalName(), 'public');
            $validated['attachment'] = $path;
        }

        // If user is employee, ensure they can only create leave for themselves
        if (Auth::user()->isEmployee()) {
            if (!Auth::user()->employee) {
                return redirect()->back()->with('error', 'Employee record not found for your account.');
            }
            $validated['employee_id'] = Auth::user()->employee->id;
        }

        $leave = Leave::create($validated);

        // Handle multiple image uploads
        if ($request->hasFile('images')) {
            $this->imageService->storeLeaveImages($request->file('images'), $leave);
        }

        return redirect()->route('leave.index')
                            ->with('success', 'Leave request submitted successfully. Your request is now pending approval.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Leave $leave)
    {
        // Check permission using helper
        LeavePermissionHelper::validateAction(Auth::user(), $leave, 'view');

        $leave->load(['employee', 'approvedBy']);

        // Get available actions for this user and leave
        $availableActions = LeavePermissionHelper::getAvailableActions(Auth::user(), $leave);
        $userContext = LeavePermissionHelper::getUserContext(Auth::user());

        return view('leave.show', compact('leave', 'availableActions', 'userContext'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Leave $leave)
    {
        // Only pending leaves can be edited
        if ($leave->status !== 'pending') {
            return redirect()->route('leave.index')
                             ->with('error', 'Only pending leaves can be edited.');
        }

        // Check if user can edit this leave
        if (Auth::user()->hasRole('employee') && ($leave->employee_id !== (Auth::user()->employee->id ?? 0))) {
            abort(403, 'Unauthorized access to leave record.');
        }

        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        // If user is employee, only allow editing their own leave
        if (Auth::user()->hasRole('employee')) {
            $employees = collect([Auth::user()->employee])->filter();
        }

        return view('leave.edit', compact('leave', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Leave $leave)
    {
        // Only pending leaves can be updated
        if ($leave->status !== 'pending') {
            return redirect()->route('leave.index')
                             ->with('error', 'Only pending leaves can be updated.');
        }

        // Check if user can update this leave
        if (Auth::user()->hasRole('employee') && ($leave->employee_id !== (Auth::user()->employee->id ?? 0))) {
            abort(403, 'Unauthorized access to leave record.');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'leave_type' => 'required|in:annual,sick,emergency,maternity,paternity,personal',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png,gif,webp|max:5120',
            'images' => 'nullable|array|max:5',
            'images.*' => 'file|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'remove_images' => 'nullable|array',
            'remove_images.*' => 'integer'
        ]);

        // Calculate total days
        $validated['total_days'] = Leave::calculateTotalDays($validated['start_date'], $validated['end_date']);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists (handle both old and new systems)
            if ($leave->attachment) {
                if (strpos($leave->attachment, 'leaves/') === 0) {
                    // New storage system
                    if (Storage::disk('public')->exists($leave->attachment)) {
                        Storage::disk('public')->delete($leave->attachment);
                    }
                } else {
                    // Old system
                    $oldPath = public_path('uploads/leaves/' . $leave->attachment);
                    if (file_exists($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }

            $file = $request->file('attachment');
            $path = $file->storeAs('leaves', time() . '_' . $file->getClientOriginalName(), 'public');
            $validated['attachment'] = $path;
        }

        // If user is employee, ensure they can only update their own leave
        if (Auth::user()->hasRole('employee')) {
            $validated['employee_id'] = Auth::user()->employee->id ?? 0;
        }

        $leave->update($validated);

        // Handle image removal
        if ($request->has('remove_images')) {
            foreach ($request->remove_images as $index) {
                $this->imageService->deleteImageByIndex($leave, (int)$index);
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $this->imageService->storeLeaveImages($request->file('images'), $leave);
        }

        return redirect()->route('leave.index')
                         ->with('success', 'Leave request updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Leave $leave)
    {
        // Check permission using helper
        LeavePermissionHelper::validateAction(Auth::user(), $leave, 'delete');

        // Delete attachment file if exists (handle both old and new systems)
        if ($leave->attachment) {
            if (strpos($leave->attachment, 'leaves/') === 0) {
                // New storage system
                if (Storage::disk('public')->exists($leave->attachment)) {
                    Storage::disk('public')->delete($leave->attachment);
                }
            } else {
                // Old system
                $oldPath = public_path('uploads/leaves/' . $leave->attachment);
                if (file_exists($oldPath)) {
                    unlink($oldPath);
                }
            }
        }

        $leave->delete();

        return redirect()->route('leave.index')
                         ->with('success', 'Leave request deleted successfully.');
    }

    /**
     * Approve a leave request.
     */
    public function approve(Request $request, Leave $leave)
    {
        try {
            // Check permission using helper
            LeavePermissionHelper::validateAction(Auth::user(), $leave, 'approve');

            // Validate that leave can be approved (pending or waiting status)
            if (!in_array($leave->status, ['pending', 'waiting'])) {
                return redirect()->back()
                                ->with('error', "❌ Cannot approve this leave request. Current status: " . ucfirst($leave->status));
            }

            // Get admin message from request
            $adminMessage = $request->input('admin_message', '');
            $adminNotes = 'Approved by ' . Auth::user()->username . ' on ' . now()->format('d M Y H:i');

            if (!empty($adminMessage)) {
                $adminNotes .= "\n\nAdmin Message: " . $adminMessage;
            }

            $leave->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now(),
                'admin_notes' => $adminNotes
            ]);

            // Log audit trail
            \Log::info('Leave request approved', [
                'leave_id' => $leave->id,
                'employee_id' => $leave->employee_id,
                'employee_name' => $leave->employee->name ?? 'N/A',
                'leave_type' => $leave->leave_type,
                'start_date' => $leave->start_date,
                'end_date' => $leave->end_date,
                'total_days' => $leave->total_days,
                'approved_by' => Auth::id(),
                'approved_by_name' => Auth::user()->username,
                'approved_at' => now(),
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'admin_message' => $adminMessage
            ]);

            // Create notification message
            $employeeName = $leave->employee->name ?? 'Employee';
            $leaveType = $leave->leave_type_display;
            $duration = $leave->start_date->format('d M Y') . ' to ' . $leave->end_date->format('d M Y');

            return redirect()->back()
                            ->with('success', "Leave request approved successfully! {$employeeName}'s {$leaveType} leave ({$leave->total_days} days, {$duration}) has been approved.")
                            ->with('employee_notification', [
                                'employee_id' => $leave->employee_id,
                                'type' => 'success',
                                'title' => 'Leave Request Approved!',
                                'message' => "Your {$leaveType} request for {$duration} has been approved by " . Auth::user()->username . ".",
                                'leave_id' => $leave->id
                            ]);

        } catch (\Exception $e) {
            \Log::error('Error approving leave', [
                'leave_id' => $leave->id,
                'leave_status' => $leave->status,
                'employee_id' => $leave->employee_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // Return more specific error information in development
            $errorMessage = app()->environment('local')
                ? "❌ Error: {$e->getMessage()} (Line: {$e->getLine()})"
                : '❌ An error occurred while approving the leave request. Please try again or contact support.';

            return redirect()->back()
                            ->with('error', $errorMessage);
        }
    }

    /**
     * Reject a leave request.
     */
    public function reject(Request $request, Leave $leave)
    {
        try {
            // Debug logging
            \Log::info('Reject method called', [
                'leave_id' => $leave->id,
                'leave_status' => $leave->status,
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);

            // Check permission using helper
            LeavePermissionHelper::validateAction(Auth::user(), $leave, 'reject');

            // Validate that leave can be rejected (pending or waiting status)
            if (!in_array($leave->status, ['pending', 'waiting'])) {
                \Log::warning('Attempted to reject non-rejectable leave', [
                    'leave_id' => $leave->id,
                    'current_status' => $leave->status
                ]);
                return redirect()->back()
                                ->with('error', "❌ Cannot reject this leave request. Current status: " . ucfirst($leave->status));
            }

            // Simplified validation - just check for admin_notes
            $adminNotes = $request->input('admin_notes');
            if (empty($adminNotes)) {
                return redirect()->back()
                                ->with('error', '❌ Please provide a rejection reason.');
            }

            // Build admin notes with rejection details
            $fullAdminNotes = 'Rejected by ' . Auth::user()->username . ' on ' . now()->format('d M Y H:i');
            $fullAdminNotes .= "\n\nReason: " . $adminNotes;

            // Update the leave record
            $leave->update([
                'status' => 'rejected',
                'admin_notes' => $fullAdminNotes,
                'approved_by' => Auth::id(),
                'approved_at' => now()
            ]);

            \Log::info('Leave successfully rejected', [
                'leave_id' => $leave->id,
                'rejected_by' => Auth::id()
            ]);

            // Create simple success message
            $employeeName = $leave->employee->name ?? 'Employee';
            $leaveType = ucfirst($leave->leave_type);

            return redirect()->back()
                            ->with('success', "Leave request rejected successfully. {$employeeName}'s {$leaveType} leave has been rejected.");

        } catch (\Exception $e) {
            \Log::error('Error rejecting leave', [
                'leave_id' => $leave->id,
                'leave_status' => $leave->status,
                'employee_id' => $leave->employee_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            // Return more specific error information in development
            $errorMessage = app()->environment('local')
                ? "❌ Error: {$e->getMessage()} (File: " . basename($e->getFile()) . ", Line: {$e->getLine()})"
                : '❌ An error occurred while rejecting the leave request. Please try again or contact support.';

            return redirect()->back()
                            ->with('error', $errorMessage);
        }
    }

    /**
     * Export leave data
     */
    private function exportLeaveData($query, $format = 'excel')
    {
        $leaves = $query->get();

        $data = $leaves->map(function($leave) {
            return [
                'ID' => $leave->id,
                'Employee Name' => $leave->employee->name ?? 'N/A',
                'Employee Code' => $leave->employee->employee_code ?? 'N/A',
                'Leave Type' => $leave->leave_type_display,
                'Start Date' => $leave->start_date->format('Y-m-d'),
                'End Date' => $leave->end_date->format('Y-m-d'),
                'Total Days' => $leave->total_days,
                'Reason' => $leave->reason,
                'Status' => ucfirst($leave->status),
                'Applied Date' => $leave->created_at->format('Y-m-d H:i:s'),
                'Approved By' => $leave->approvedBy->username ?? '',
                'Approved Date' => $leave->approved_at ? $leave->approved_at->format('Y-m-d H:i:s') : '',
                'Admin Notes' => $leave->admin_notes ?? '',
            ];
        });

        $filename = 'leave_requests_' . now()->format('Y-m-d_H-i-s');

        if ($format === 'csv') {
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}.csv\"",
            ];

            $callback = function() use ($data) {
                $file = fopen('php://output', 'w');

                // Add CSV headers
                if ($data->isNotEmpty()) {
                    fputcsv($file, array_keys($data->first()));
                }

                // Add data rows
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        // Default to JSON export if Excel is not available
        $headers = [
            'Content-Type' => 'application/json',
            'Content-Disposition' => "attachment; filename=\"{$filename}.json\"",
        ];

        return response()->json($data, 200, $headers);
    }

    /**
     * Bulk approve leaves
     */
    public function bulkApprove(Request $request)
    {
        // Check bulk action permission
        if (!LeavePermissionHelper::canBulkAction(Auth::user())) {
            abort(403, LeavePermissionHelper::getPermissionErrorMessage('bulk'));
        }

        $validated = $request->validate([
            'leave_ids' => 'required|array',
            'leave_ids.*' => 'exists:leaves,id'
        ]);

        $leaves = Leave::whereIn('id', $validated['leave_ids'])
                      ->where('status', 'pending')
                      ->get();

        $approved = 0;
        foreach ($leaves as $leave) {
            $leave->update([
                'status' => 'approved',
                'approved_by' => Auth::id(),
                'approved_at' => now()
            ]);
            $approved++;
        }

        return redirect()->back()
                         ->with('success', "✅ {$approved} leave request(s) have been approved successfully.");
    }

    /**
     * Bulk reject leaves
     */
    public function bulkReject(Request $request)
    {
        // Only admin/hr/manager can bulk reject
        if (!Auth::user()->hasRole(['admin', 'hr', 'manager'])) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'leave_ids' => 'required|array',
            'leave_ids.*' => 'exists:leaves,id',
            'admin_notes' => 'required|string|max:500'
        ]);

        $leaves = Leave::whereIn('id', $validated['leave_ids'])
                      ->where('status', 'pending')
                      ->get();

        $rejected = 0;
        foreach ($leaves as $leave) {
            $leave->update([
                'status' => 'rejected',
                'admin_notes' => $validated['admin_notes'],
                'approved_by' => Auth::id(),
                'approved_at' => now()
            ]);
            $rejected++;
        }

        return redirect()->back()
                         ->with('success', "❌ {$rejected} leave request(s) have been rejected.");
    }

    /**
     * Bulk delete leave requests.
     */
    public function bulkDelete(Request $request)
    {
        // Check if user has permission to delete leave requests
        if (!Auth::user()->hasRole(['admin', 'hr'])) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to delete leave requests.'
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
                            'message' => 'No leave requests selected for deletion.'
                        ], 400);
                    }

                    $deletedCount = Leave::whereIn('id', $ids)->count();
                    Leave::whereIn('id', $ids)->delete();

                    \Log::info('Bulk delete selected leave requests', [
                        'user_id' => Auth::id(),
                        'deleted_ids' => $ids,
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip()
                    ]);
                    break;

                case 'approved':
                    $deletedCount = Leave::where('status', 'approved')->count();
                    Leave::where('status', 'approved')->delete();

                    \Log::info('Bulk delete approved leave requests', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip()
                    ]);
                    break;

                case 'rejected':
                    $deletedCount = Leave::where('status', 'rejected')->count();
                    Leave::where('status', 'rejected')->delete();

                    \Log::info('Bulk delete rejected leave requests', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip()
                    ]);
                    break;

                case 'all':
                    $deletedCount = Leave::count();
                    Leave::truncate(); // More efficient for deleting all records

                    \Log::warning('Bulk delete ALL leave requests', [
                        'user_id' => Auth::id(),
                        'deleted_count' => $deletedCount,
                        'ip_address' => $request->ip(),
                        'warning' => 'ALL LEAVE REQUESTS DELETED'
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
                'message' => "Successfully deleted {$deletedCount} leave request(s).",
                'deleted_count' => $deletedCount,
                'type' => $type
            ]);

        } catch (\Exception $e) {
            \Log::error('Bulk delete leave requests failed', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'type' => $request->input('type'),
                'ip_address' => $request->ip()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to delete leave requests. Please try again.'
            ], 500);
        }
    }

    /**
     * Delete a specific image from a leave request by index.
     */
    public function deleteImage(Request $request, Leave $leave, int $index)
    {
        // Check if user can modify this leave
        if (Auth::user()->hasRole('employee') && ($leave->employee_id !== (Auth::user()->employee->id ?? 0))) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $deleted = $this->imageService->deleteImageByIndex($leave, $index);

        if ($deleted) {
            return response()->json(['message' => 'Image deleted successfully']);
        } else {
            return response()->json(['error' => 'Failed to delete image'], 500);
        }
    }
}
