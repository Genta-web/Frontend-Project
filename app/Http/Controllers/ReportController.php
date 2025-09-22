<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\WorkLog;
use App\Models\JobBatch;
use App\Models\EmployeeJob;
use App\Models\Leave;
use App\Models\Employee;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;

class ReportController extends Controller
{
    /**
     * Display the main reports dashboard.
     */
    public function index()
    {
        try {
            $user = Auth::user();

            // Only admin and HR can access reports
            if (!$user->hasRole('admin') && !$user->hasRole('hr')) {
                abort(403, 'Unauthorized access to reports.');
            }

            $currentMonth = now()->month;
            $currentYear = now()->year;
            $cacheKey = "reports_dashboard_stats_{$currentMonth}_{$currentYear}";

            // Cache statistics for 10 minutes to improve performance
            $stats = Cache::remember($cacheKey, 600, function () use ($currentMonth, $currentYear) {
                return [
                    'attendance' => $this->getAttendanceStats($currentMonth, $currentYear),
                    'work_logs' => $this->getWorkLogStats($currentMonth, $currentYear),
                    'jobs' => $this->getJobStats($currentMonth, $currentYear),
                    'leaves' => $this->getLeaveStats($currentMonth, $currentYear),
                ];
            });

            // Cache employees list for 30 minutes
            $employees = Cache::remember('active_employees_list', 1800, function () {
                return Employee::select('id', 'name', 'employee_code')
                    ->where('status', 'active')
                    ->orderBy('name')
                    ->get();
            });

            return view('reports.index', compact('stats', 'employees'));

        } catch (\Exception $e) {
            Log::error('Reports dashboard error: ' . $e->getMessage());

            // Return with default stats if error occurs
            $stats = [
                'attendance' => ['total' => 0, 'present' => 0, 'absent' => 0, 'late' => 0],
                'work_logs' => ['total' => 0, 'completed' => 0, 'in_progress' => 0],
                'jobs' => ['total' => 0, 'completed' => 0, 'in_progress' => 0],
                'leaves' => ['total' => 0, 'approved' => 0, 'pending' => 0, 'rejected' => 0],
            ];

            $employees = collect();

            return view('reports.index', compact('stats', 'employees'))
                ->with('error', 'Unable to load some statistics. Please try again.');
        }
    }

    /**
     * Get optimized attendance statistics
     */
    private function getAttendanceStats($month, $year)
    {
        $stats = DB::table('attendance')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present,
                SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent,
                SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late
            ')
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->first();

        return [
            'total' => $stats->total ?? 0,
            'present' => $stats->present ?? 0,
            'absent' => $stats->absent ?? 0,
            'late' => $stats->late ?? 0,
        ];
    }

    /**
     * Get optimized work log statistics
     */
    private function getWorkLogStats($month, $year)
    {
        $stats = DB::table('work_logs')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "done" THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN status = "in_progress" THEN 1 ELSE 0 END) as in_progress
            ')
            ->whereMonth('work_date', $month)
            ->whereYear('work_date', $year)
            ->first();

        return [
            'total' => $stats->total ?? 0,
            'completed' => $stats->completed ?? 0,
            'in_progress' => $stats->in_progress ?? 0,
        ];
    }

    /**
     * Get optimized job statistics
     */
    private function getJobStats($month, $year)
    {
        $stats = DB::table('job_batches')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN job_status = "completed" THEN 1 ELSE 0 END) as completed,
                SUM(CASE WHEN job_status = "in_progress" THEN 1 ELSE 0 END) as in_progress,
                SUM(CASE WHEN job_status = "pending" THEN 1 ELSE 0 END) as pending
            ')
            ->whereNull('batch_type')
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->first();

        return [
            'total' => $stats->total ?? 0,
            'completed' => $stats->completed ?? 0,
            'in_progress' => $stats->in_progress ?? 0,
            'pending' => $stats->pending ?? 0,
        ];
    }

    /**
     * Get optimized leave statistics
     */
    private function getLeaveStats($month, $year)
    {
        $stats = DB::table('leaves')
            ->selectRaw('
                COUNT(*) as total,
                SUM(CASE WHEN status = "approved" THEN 1 ELSE 0 END) as approved,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected
            ')
            ->whereMonth('start_date', $month)
            ->whereYear('start_date', $year)
            ->first();

        return [
            'total' => $stats->total ?? 0,
            'approved' => $stats->approved ?? 0,
            'pending' => $stats->pending ?? 0,
            'rejected' => $stats->rejected ?? 0,
        ];
    }

    /**
     * Generate comprehensive report.
     */
    public function comprehensive(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'employee_id' => 'nullable|exists:employees,id',
                'format' => 'required|in:web,pdf',
            ]);

            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $employeeId = $request->employee_id;

            // Create cache key for this specific report
            $cacheKey = "comprehensive_report_" .
                       $startDate->format('Y-m-d') . "_" .
                       $endDate->format('Y-m-d') . "_" .
                       ($employeeId ?? 'all');

            if ($request->format === 'pdf') {
                return $this->generateOptimizedPDF($startDate, $endDate, $employeeId, 'comprehensive');
            }

            // Cache report data for 5 minutes for web view
            $data = Cache::remember($cacheKey, 300, function () use ($startDate, $endDate, $employeeId) {
                return $this->getOptimizedReportData($startDate, $endDate, $employeeId);
            });

            return view('reports.comprehensive', compact('data', 'startDate', 'endDate'));

        } catch (\Exception $e) {
            Log::error('Comprehensive report error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate comprehensive report. Please try again.');
        }
    }

    /**
     * Generate attendance report.
     */
    public function attendance(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'employee_id' => 'nullable|exists:employees,id',
                'format' => 'required|in:web,pdf',
            ]);

            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $employeeId = $request->employee_id;

            if ($request->format === 'pdf') {
                return $this->generateOptimizedPDF($startDate, $endDate, $employeeId, 'attendance');
            }

            // Create cache key for this specific report
            $cacheKey = "attendance_report_" .
                       $startDate->format('Y-m-d') . "_" .
                       $endDate->format('Y-m-d') . "_" .
                       ($employeeId ?? 'all');

            // Cache report data for 5 minutes
            $reportData = Cache::remember($cacheKey, 300, function () use ($startDate, $endDate, $employeeId) {
                $query = Attendance::with(['employee:id,name,employee_code'])
                                  ->select('id', 'employee_id', 'date', 'status', 'check_in', 'check_out', 'notes')
                                  ->whereBetween('date', [$startDate, $endDate]);

                if ($employeeId) {
                    $query->where('employee_id', $employeeId);
                }

                $attendances = $query->orderBy('date', 'desc')->get();

                // Calculate summary using database aggregation for better performance
                $summary = $this->getAttendanceSummary($startDate, $endDate, $employeeId);

                return [
                    'attendances' => $attendances,
                    'summary' => $summary,
                ];
            });

            return view('reports.attendance', [
                'attendances' => $reportData['attendances'],
                'summary' => $reportData['summary'],
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);

        } catch (\Exception $e) {
            Log::error('Attendance report error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'start_date' => $request->start_date ?? 'N/A',
                'end_date' => $request->end_date ?? 'N/A',
                'employee_id' => $request->employee_id ?? 'N/A',
                'format' => $request->format ?? 'N/A'
            ]);

            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate attendance report: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to generate attendance report. Error: ' . $e->getMessage() . '. Please try again.');
        }
    }

    /**
     * Generate work logs report.
     */
    public function workLogs(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'employee_id' => 'nullable|exists:employees,id',
                'format' => 'required|in:web,pdf',
            ]);

            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $employeeId = $request->employee_id;

            if ($request->format === 'pdf') {
                return $this->generateOptimizedPDF($startDate, $endDate, $employeeId, 'work_logs');
            }

            // Create cache key for this specific report
            $cacheKey = "work_logs_report_" .
                       $startDate->format('Y-m-d') . "_" .
                       $endDate->format('Y-m-d') . "_" .
                       ($employeeId ?? 'all');

            // Cache report data for 5 minutes
            $reportData = Cache::remember($cacheKey, 300, function () use ($startDate, $endDate, $employeeId) {
                $query = WorkLog::with(['employee:id,name,employee_code'])
                               ->select('id', 'employee_id', 'work_date', 'task_summary', 'status', 'start_time', 'end_time', 'action_details')
                               ->whereBetween('work_date', [$startDate, $endDate]);

                if ($employeeId) {
                    $query->where('employee_id', $employeeId);
                }

                $workLogs = $query->orderBy('work_date', 'desc')->get();

                // Calculate summary using database aggregation for better performance
                $summary = $this->getWorkLogsSummary($startDate, $endDate, $employeeId, $workLogs);

                return [
                    'workLogs' => $workLogs,
                    'summary' => $summary,
                ];
            });

            return view('reports.work-logs', [
                'workLogs' => $reportData['workLogs'],
                'summary' => $reportData['summary'],
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);

        } catch (\Exception $e) {
            Log::error('Work logs report error: ' . $e->getMessage());
            return back()->with('error', 'Failed to generate work logs report. Please try again.');
        }
    }

    /**
     * Generate jobs report.
     */
    public function jobs(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'employee_id' => 'nullable|exists:employees,id',
                'format' => 'required|in:web,pdf',
            ]);

            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $employeeId = $request->employee_id;

            if ($request->format === 'pdf') {
                return $this->generateOptimizedPDF($startDate, $endDate, $employeeId, 'jobs');
            }

            // Create cache key for this specific report
            $cacheKey = "jobs_report_" .
                       $startDate->format('Y-m-d') . "_" .
                       $endDate->format('Y-m-d') . "_" .
                       ($employeeId ?? 'all');

            // Cache report data for 5 minutes
            $reportData = Cache::remember($cacheKey, 300, function () use ($startDate, $endDate, $employeeId) {
                $query = JobBatch::with(['employee:id,name,employee_code'])
                                 ->select('id', 'employee_id', 'name', 'description', 'job_status', 'start_date', 'due_date', 'progress_percentage', 'priority')
                                 ->whereNull('batch_type')
                                 ->whereBetween('start_date', [$startDate, $endDate]);

                if ($employeeId) {
                    $query->where('employee_id', $employeeId);
                }

                $jobs = $query->orderBy('start_date', 'desc')->get();

                // Calculate summary using optimized method
                $summary = $this->getJobsSummary($jobs);

                return [
                    'jobs' => $jobs,
                    'summary' => $summary,
                ];
            });

            return view('reports.jobs', [
                'jobs' => $reportData['jobs'],
                'summary' => $reportData['summary'],
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);

        } catch (\Exception $e) {
            Log::error('Jobs report error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'start_date' => $request->start_date ?? 'N/A',
                'end_date' => $request->end_date ?? 'N/A',
                'employee_id' => $request->employee_id ?? 'N/A',
                'format' => $request->format ?? 'N/A'
            ]);

            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate jobs report: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to generate jobs report. Error: ' . $e->getMessage() . '. Please try again.');
        }
    }

    /**
     * Generate leaves report.
     */
    public function leaves(Request $request)
    {
        try {
            $request->validate([
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'employee_id' => 'nullable|exists:employees,id',
                'format' => 'required|in:web,pdf',
            ]);

            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            $employeeId = $request->employee_id;

            if ($request->format === 'pdf') {
                return $this->generateOptimizedPDF($startDate, $endDate, $employeeId, 'leaves');
            }

            // Create cache key for this specific report
            $cacheKey = "leaves_report_" .
                       $startDate->format('Y-m-d') . "_" .
                       $endDate->format('Y-m-d') . "_" .
                       ($employeeId ?? 'all');

            // Cache report data for 5 minutes
            $reportData = Cache::remember($cacheKey, 300, function () use ($startDate, $endDate, $employeeId) {
                $query = Leave::with(['employee:id,name,employee_code'])
                             ->select('id', 'employee_id', 'leave_type', 'start_date', 'end_date', 'total_days', 'status', 'reason')
                             ->whereBetween('start_date', [$startDate, $endDate]);

                if ($employeeId) {
                    $query->where('employee_id', $employeeId);
                }

                $leaves = $query->orderBy('start_date', 'desc')->get();

                // Calculate summary using optimized method
                $summary = $this->getLeavesSummary($leaves);

                return [
                    'leaves' => $leaves,
                    'summary' => $summary,
                ];
            });

            return view('reports.leaves', [
                'leaves' => $reportData['leaves'],
                'summary' => $reportData['summary'],
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);

        } catch (\Exception $e) {
            Log::error('Leaves report error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'start_date' => $request->start_date ?? 'N/A',
                'end_date' => $request->end_date ?? 'N/A',
                'employee_id' => $request->employee_id ?? 'N/A',
                'format' => $request->format ?? 'N/A'
            ]);

            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate leaves report: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to generate leaves report. Error: ' . $e->getMessage() . '. Please try again.');
        }
    }



    /**
     * Generate optimized PDF report with better performance
     */
    private function generateOptimizedPDF($startDate, $endDate, $employeeId, $type)
    {
        try {
            // Set memory limit for large reports
            ini_set('memory_limit', '512M');
            set_time_limit(300); // 5 minutes

            // Get optimized data for PDF
            $data = $this->getOptimizedReportData($startDate, $endDate, $employeeId, $type);

            // Configure PDF options for better performance
            $pdf = Pdf::loadView("reports.pdf.{$type}", compact('data', 'startDate', 'endDate'))
                     ->setPaper('a4', 'portrait')
                     ->setOptions([
                         'isHtml5ParserEnabled' => true,
                         'isPhpEnabled' => true,
                         'defaultFont' => 'Arial',
                         'dpi' => 96,
                         'defaultPaperSize' => 'a4',
                         'chroot' => public_path(),
                     ]);

            $filename = "{$type}_report_" . $startDate->format('Y-m-d') . "_to_" . $endDate->format('Y-m-d') . ".pdf";

            return $pdf->download($filename);

        } catch (\Exception $e) {
            Log::error("PDF generation error for {$type} report: " . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'employee_id' => $employeeId,
                'type' => $type
            ]);

            // Return JSON response for AJAX requests
            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate PDF report: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Failed to generate PDF report. Error: ' . $e->getMessage() . '. Please try again or use web view.');
        }
    }

    /**
     * Get optimized report data with better performance
     */
    private function getOptimizedReportData($startDate, $endDate, $employeeId = null, $type = 'comprehensive')
    {
        $data = [];

        try {
            // Ensure dates are Carbon instances
            $startDate = Carbon::parse($startDate);
            $endDate = Carbon::parse($endDate);
            if ($type === 'comprehensive' || $type === 'attendance') {
                // Optimized attendance data with eager loading
                $attendanceQuery = Attendance::with(['employee:id,name,employee_code'])
                                            ->select('id', 'employee_id', 'date', 'status', 'check_in', 'check_out', 'notes')
                                            ->whereBetween('date', [$startDate, $endDate]);

                if ($employeeId) {
                    $attendanceQuery->where('employee_id', $employeeId);
                }

                $data['attendances'] = $attendanceQuery->orderBy('date', 'desc')->get();
            }

            // Always include summary for attendance reports
            if ($type === 'attendance' || $type === 'comprehensive') {
                $data['summary'] = $this->getAttendanceSummary($startDate, $endDate, $employeeId);
            }

            if ($type === 'comprehensive' || $type === 'work_logs') {
                // Optimized work logs data
                $workLogQuery = WorkLog::with(['employee:id,name,employee_code'])
                                      ->select('id', 'employee_id', 'work_date', 'task_summary', 'status', 'start_time', 'end_time', 'action_details')
                                      ->whereBetween('work_date', [$startDate, $endDate]);

                if ($employeeId) {
                    $workLogQuery->where('employee_id', $employeeId);
                }

                $workLogs = $workLogQuery->orderBy('work_date', 'desc')->get();
                $data['workLogs'] = $workLogs;

                // Add summary data for work logs reports (always include for work_logs and comprehensive)
                if ($type === 'work_logs' || $type === 'comprehensive') {
                    $data['summary'] = $this->getWorkLogsSummary($startDate, $endDate, $employeeId, $workLogs);
                }
            }

            if ($type === 'comprehensive' || $type === 'jobs') {
                // Optimized jobs data using JobBatch model
                $jobQuery = JobBatch::with(['employee:id,name,employee_code'])
                                   ->select('id', 'employee_id', 'name', 'description', 'job_status', 'start_date', 'due_date', 'progress_percentage', 'priority')
                                   ->whereNull('batch_type')
                                   ->whereBetween('start_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);

                if ($employeeId) {
                    $jobQuery->where('employee_id', $employeeId);
                }

                $jobs = $jobQuery->orderBy('start_date', 'desc')->get();
                $data['jobs'] = $jobs;

                // Add summary data for jobs reports (always include for jobs and comprehensive)
                if ($type === 'jobs' || $type === 'comprehensive') {
                    $data['summary'] = $this->getJobsSummary($jobs);
                }
            }

            if ($type === 'comprehensive' || $type === 'leaves') {
                // Optimized leaves data
                $leaveQuery = Leave::with(['employee:id,name,employee_code'])
                                  ->select('id', 'employee_id', 'leave_type', 'start_date', 'end_date', 'total_days', 'status', 'reason')
                                  ->whereBetween('start_date', [$startDate, $endDate]);

                if ($employeeId) {
                    $leaveQuery->where('employee_id', $employeeId);
                }

                $leaves = $leaveQuery->orderBy('start_date', 'desc')->get();
                $data['leaves'] = $leaves;

                // Add summary data for leaves reports (always include for leaves and comprehensive)
                if ($type === 'leaves' || $type === 'comprehensive') {
                    $data['summary'] = $this->getLeavesSummary($leaves);
                }
            }

            return $data;

        } catch (\Exception $e) {
            Log::error("Error getting optimized report data: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get attendance summary with database aggregation
     */
    private function getAttendanceSummary($startDate, $endDate, $employeeId = null)
    {
        $query = DB::table('attendance')
                   ->selectRaw('
                       COUNT(*) as total_records,
                       SUM(CASE WHEN status = "present" THEN 1 ELSE 0 END) as present,
                       SUM(CASE WHEN status = "absent" THEN 1 ELSE 0 END) as absent,
                       SUM(CASE WHEN status = "late" THEN 1 ELSE 0 END) as late,
                       SUM(CASE WHEN status = "sick" THEN 1 ELSE 0 END) as sick,
                       SUM(CASE WHEN status = "leave" THEN 1 ELSE 0 END) as leave_status
                   ')
                   ->whereBetween('date', [$startDate, $endDate]);

        if ($employeeId) {
            $query->where('employee_id', $employeeId);
        }

        $result = $query->first();

        return [
            'total_records' => $result->total_records ?? 0,
            'present' => $result->present ?? 0,
            'absent' => $result->absent ?? 0,
            'late' => $result->late ?? 0,
            'sick' => $result->sick ?? 0,
            'leave' => $result->leave_status ?? 0,
        ];
    }

    /**
     * Get work logs summary with optimized calculations
     */
    private function getWorkLogsSummary($startDate, $endDate, $employeeId, $workLogs)
    {
        // Calculate total hours efficiently
        $totalHours = $workLogs->sum(function ($log) {
            if ($log->start_time && $log->end_time) {
                $start = Carbon::parse($log->start_time);
                $end = Carbon::parse($log->end_time);
                return $end->diffInHours($start);
            }
            return 0;
        });

        return [
            'total_logs' => $workLogs->count(),
            'total_hours' => $totalHours,
            'average_hours_per_day' => $workLogs->count() > 0 ? round($totalHours / $workLogs->count(), 2) : 0,
            'days_worked' => $workLogs->groupBy('work_date')->count(),
            'completed_tasks' => $workLogs->where('status', 'done')->count(),
            'ongoing_tasks' => $workLogs->where('status', 'ongoing')->count(),
            'in_progress_tasks' => $workLogs->where('status', 'in_progress')->count(),
        ];
    }

    /**
     * Get jobs summary with optimized calculations
     */
    private function getJobsSummary($jobs)
    {
        return [
            'total_jobs' => $jobs->count(),
            'pending' => $jobs->where('job_status', 'pending')->count(),
            'in_progress' => $jobs->where('job_status', 'in_progress')->count(),
            'completed' => $jobs->where('job_status', 'completed')->count(),
            'cancelled' => $jobs->where('job_status', 'cancelled')->count(),
            'overdue' => $jobs->filter(function($job) {
                return $job->due_date && $job->due_date < now() && $job->job_status !== 'completed';
            })->count(),
            'average_progress' => $jobs->avg('progress_percentage') ?? 0,
        ];
    }

    /**
     * Get leaves summary with optimized calculations
     */
    private function getLeavesSummary($leaves)
    {
        return [
            'total_leaves' => $leaves->count(),
            'approved' => $leaves->where('status', 'approved')->count(),
            'pending' => $leaves->where('status', 'pending')->count(),
            'rejected' => $leaves->where('status', 'rejected')->count(),
            'total_days' => $leaves->where('status', 'approved')->sum('total_days'),
            'leave_types' => $leaves->groupBy('leave_type')->map->count(),
        ];
    }

    /**
     * Clear report cache
     */
    public function clearCache()
    {
        try {
            Cache::flush();
            return response()->json(['success' => true, 'message' => 'Report cache cleared successfully']);
        } catch (\Exception $e) {
            Log::error('Cache clear error: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to clear cache']);
        }
    }
}
