<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WorkLog;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class WorkLogController extends Controller
{
    /**
     * Create a new controller instance.
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
        $query = WorkLog::with('employee');

        // Filter by employee
        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('work_date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('work_date', '<=', $request->date_to);
        }

        // If user is employee, only show their own work logs
        if (Auth::user()->hasRole('employee')) {
            $query->where('employee_id', Auth::user()->employee->id ?? 0);
        }

        $workLogs = $query->orderBy('work_date', 'desc')
                         ->orderBy('start_time', 'desc')
                         ->paginate(15);

        // Get employees for filter dropdown (only for admin/hr/manager)
        $employees = collect();
        if (!Auth::user()->hasRole('employee')) {
            $employees = Employee::where('status', 'active')->orderBy('name')->get();
        }

        // Statistics
        $stats = [
            'total_logs' => WorkLog::count(),
            'logs_today' => WorkLog::whereDate('work_date', today())->count(),
            'logs_this_week' => WorkLog::whereBetween('work_date', [
                Carbon::now()->startOfWeek(),
                Carbon::now()->endOfWeek()
            ])->count(),
            'logs_this_month' => WorkLog::whereMonth('work_date', now()->month)
                                      ->whereYear('work_date', now()->year)
                                      ->count(),
        ];

        // If employee, show only their stats
        if (Auth::user()->hasRole('employee') && Auth::user()->employee) {
            $employeeId = Auth::user()->employee->id;
            $stats = [
                'total_logs' => WorkLog::where('employee_id', $employeeId)->count(),
                'logs_today' => WorkLog::where('employee_id', $employeeId)->whereDate('work_date', today())->count(),
                'logs_this_week' => WorkLog::where('employee_id', $employeeId)->whereBetween('work_date', [
                    Carbon::now()->startOfWeek(),
                    Carbon::now()->endOfWeek()
                ])->count(),
                'logs_this_month' => WorkLog::where('employee_id', $employeeId)
                                          ->whereMonth('work_date', now()->month)
                                          ->whereYear('work_date', now()->year)
                                          ->count(),
            ];
        }

        return view('worklogs.index', compact('workLogs', 'employees', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        // If user is employee, only allow creating work log for themselves
        if (Auth::user()->hasRole('employee')) {
            $employees = collect([Auth::user()->employee])->filter();
        }

        return view('worklogs.create', compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'work_date' => 'required|date|before_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'task_summary' => 'required|string|max:2000',
            'status' => 'required|in:ongoing,in_progress,done',
            'action_details' => 'nullable|string|max:1000',
            'attachment_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('attachment_image')) {
            $file = $request->file('attachment_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/worklogs'), $filename);
            $validated['attachment_image'] = $filename;
        }

        // If user is employee, ensure they can only create work log for themselves
        if (Auth::user()->hasRole('employee')) {
            $validated['employee_id'] = Auth::user()->employee->id ?? 0;
        }

        WorkLog::create($validated);

        return redirect()->route('worklogs.index')
                        ->with('success', 'Work log created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WorkLog $worklog)
    {
        // Check if user can view this work log
        if (Auth::user()->hasRole('employee') && $worklog->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized access to work log.');
        }

        $worklog->load('employee');
        return view('worklogs.show', compact('worklog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WorkLog $worklog)
    {
        // Check if user can edit this work log
        if (Auth::user()->hasRole('employee') && $worklog->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized access to work log.');
        }

        $employees = Employee::where('status', 'active')->orderBy('name')->get();

        // If user is employee, only allow editing their own work log
        if (Auth::user()->hasRole('employee')) {
            $employees = collect([Auth::user()->employee])->filter();
        }

        return view('worklogs.edit', compact('worklog', 'employees'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, WorkLog $worklog)
    {
        // Check if user can update this work log
        if (Auth::user()->hasRole('employee') && $worklog->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized access to work log.');
        }

        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'work_date' => 'required|date|before_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'task_summary' => 'required|string|max:2000',
            'status' => 'required|in:ongoing,in_progress,done',
            'action_details' => 'nullable|string|max:1000',
            'attachment_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('attachment_image')) {
            // Delete old file if exists
            if ($worklog->attachment_image && file_exists(public_path('uploads/worklogs/' . $worklog->attachment_image))) {
                unlink(public_path('uploads/worklogs/' . $worklog->attachment_image));
            }

            $file = $request->file('attachment_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/worklogs'), $filename);
            $validated['attachment_image'] = $filename;
        }

        // If user is employee, ensure they can only update their own work log
        if (Auth::user()->hasRole('employee')) {
            $validated['employee_id'] = Auth::user()->employee->id ?? 0;
        }

        $worklog->update($validated);

        return redirect()->route('worklogs.index')
                        ->with('success', 'Work log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkLog $worklog)
    {
        // Check if user can delete this work log
        if (Auth::user()->hasRole('employee') && $worklog->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized access to work log.');
        }

        // Delete attachment file if exists
        if ($worklog->attachment_image && file_exists(public_path('uploads/worklogs/' . $worklog->attachment_image))) {
            unlink(public_path('uploads/worklogs/' . $worklog->attachment_image));
        }

        $worklog->delete();

        return redirect()->route('worklogs.index')
                        ->with('success', 'Work log deleted successfully.');
    }

    /**
     * Get work logs report.
     */
    public function report(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $query = WorkLog::with('employee')
                       ->whereMonth('work_date', $month)
                       ->whereYear('work_date', $year);

        // If employee, only show their own logs
        if (Auth::user()->hasRole('employee') && Auth::user()->employee) {
            $query->where('employee_id', Auth::user()->employee->id);
        }

        $workLogs = $query->orderBy('work_date', 'desc')->get();

        // Calculate total hours
        $totalHours = $workLogs->sum(function ($log) {
            if ($log->start_time && $log->end_time) {
                $start = Carbon::parse($log->start_time);
                $end = Carbon::parse($log->end_time);
                return $end->diffInHours($start);
            }
            return 0;
        });

        $summary = [
            'total_logs' => $workLogs->count(),
            'total_hours' => $totalHours,
            'average_hours_per_day' => $workLogs->count() > 0 ? round($totalHours / $workLogs->count(), 2) : 0,
            'days_worked' => $workLogs->groupBy('work_date')->count(),
        ];

        return view('worklogs.report', compact('workLogs', 'summary', 'month', 'year'));
    }

    /**
     * Quick add work log for current user.
     */
    public function quickAdd(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'No employee record found for your account.');
        }

        $validated = $request->validate([
            'work_date' => 'required|date|before_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'task_summary' => 'required|string|max:500',
        ]);

        WorkLog::create([
            'employee_id' => $employee->id,
            'work_date' => $validated['work_date'],
            'start_time' => $validated['start_time'],
            'end_time' => $validated['end_time'],
            'task_summary' => $validated['task_summary'],
        ]);

        return redirect()->back()->with('success', 'Work log added successfully!');
    }

    /**
     * Update work log status.
     */
    public function updateStatus(Request $request, WorkLog $worklog)
    {
        // Check if user can update this work log
        if (Auth::user()->hasRole('employee') && $worklog->employee_id !== Auth::user()->employee->id) {
            abort(403, 'Unauthorized access to work log.');
        }

        $validated = $request->validate([
            'status' => 'required|in:ongoing,in_progress,done',
            'action_details' => 'nullable|string|max:1000',
            'status_update_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle status update image upload
        if ($request->hasFile('status_update_image')) {
            // Delete old status update image if exists
            if ($worklog->status_update_image && file_exists(public_path('uploads/worklogs/status/' . $worklog->status_update_image))) {
                unlink(public_path('uploads/worklogs/status/' . $worklog->status_update_image));
            }

            $file = $request->file('status_update_image');
            $filename = time() . '_status_' . $file->getClientOriginalName();

            // Create directory if it doesn't exist
            if (!file_exists(public_path('uploads/worklogs/status'))) {
                mkdir(public_path('uploads/worklogs/status'), 0755, true);
            }

            $file->move(public_path('uploads/worklogs/status'), $filename);
            $validated['status_update_image'] = $filename;
        }

        // Set status update timestamp
        $validated['status_updated_at'] = now();

        $worklog->update($validated);

        return redirect()->route('worklogs.index')
                        ->with('success', 'Work log status updated successfully.');
    }
}
