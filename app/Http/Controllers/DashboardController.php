<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Employee;
use App\Models\Attendance;
use App\Models\WorkLog;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();

        // Redirect based on role
        switch ($user->role) {
            case 'admin':
                return $this->adminDashboard();
            case 'hr':
                return $this->hrDashboard();
            case 'manager':
                return $this->managerDashboard();
            case 'employee':
                return $this->employeeDashboard();
            default:
                return $this->defaultDashboard();
        }
    }

    /**
     * Admin dashboard.
     */
    public function adminDashboard()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'inactive_employees' => Employee::where('status', 'inactive')->count(),
            'total_attendance_today' => Attendance::whereDate('date', today())->count(),
            'present_today' => Attendance::whereDate('date', today())->where('status', 'present')->count(),
        ];
        $employee = Employee::count();
        $recent_employees = Employee::latest()->take(5)->get();
        $recent_attendance = Attendance::with('employee')
            ->whereDate('date', today())
            ->latest()
            ->take(10)
            ->get();

        return view('dashboard.admin', compact('stats', 'recent_employees', 'recent_attendance', 'employee' ));
    }

    /**
     * HR dashboard.
     */
    public function hrDashboard()
    {
        $stats = [
            'total_employees' => Employee::count(),
            'active_employees' => Employee::where('status', 'active')->count(),
            'attendance_today' => Attendance::whereDate('date', today())->count(),
        ];

        return view('dashboard.hr', compact('stats'));
    }

    /**
     * Manager dashboard.
     */
    public function managerDashboard()
    {
        $stats = [
            'team_members' => Employee::where('status', 'active')->count(),
            'attendance_today' => Attendance::whereDate('date', today())->count(),
        ];

        return view('dashboard.manager', compact('stats'));
    }

    /**
     * Employee dashboard.
     */
    public function employeeDashboard()
    {
        $user = Auth::user();
        $employee = $user->employee;

        $stats = [];
        $attendanceToday = null;
        $recentWorkLogs = collect();
        $attendanceStats = [];
        $leaveStats = [];

        if ($employee) {
            // Basic stats
            $stats = [
                'attendance_this_month' => Attendance::where('employee_id', $employee->id)
                    ->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year)
                    ->count(),
                'work_logs_this_month' => WorkLog::where('employee_id', $employee->id)
                    ->whereMonth('work_date', now()->month)
                    ->whereYear('work_date', now()->year)
                    ->count(),
                'total_work_logs' => WorkLog::where('employee_id', $employee->id)->count(),
            ];

            // Today's attendance
            $attendanceToday = Attendance::where('employee_id', $employee->id)
                    ->whereDate('date', today())
                    ->first();

            // Attendance statistics
            $totalAttendance = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->count();

            $presentDays = Attendance::where('employee_id', $employee->id)
                ->whereMonth('date', now()->month)
                ->whereYear('date', now()->year)
                ->where('status', 'present')
                ->count();

            $attendancePercentage = $totalAttendance > 0 ? round(($presentDays / $totalAttendance) * 100, 2) : 0;

            $attendanceStats = [
                'total_days' => $totalAttendance,
                'present_days' => $presentDays,
                'percentage' => $attendancePercentage
            ];

            // Recent work logs
            $recentWorkLogs = WorkLog::where('employee_id', $employee->id)
                ->orderBy('work_date', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(5)
                ->get();

            // Leave statistics
            $leaveStats = [
                'pending_requests' => \App\Models\Leave::where('employee_id', $employee->id)
                    ->where('status', 'pending')
                    ->count(),
                'approved_this_year' => \App\Models\Leave::where('employee_id', $employee->id)
                    ->where('status', 'approved')
                    ->whereYear('start_date', now()->year)
                    ->count(),
                'total_days_taken' => \App\Models\Leave::where('employee_id', $employee->id)
                    ->where('status', 'approved')
                    ->whereYear('start_date', now()->year)
                    ->sum('total_days')
            ];
        }

        return view('dashboard.employee', compact('stats', 'employee', 'attendanceToday', 'recentWorkLogs', 'attendanceStats', 'leaveStats'));
    }

    /**
     * Default dashboard.
     */
    public function defaultDashboard()
    {
        return view('dashboard.default');
    }

    /**
     * Get dashboard stats for AJAX refresh.
     */
    public function getDashboardStats()
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return response()->json(['success' => false, 'message' => 'Employee not found']);
        }

        // Calculate fresh stats
        $totalWorkLogs = WorkLog::where('employee_id', $employee->id)->count();

        $totalAttendance = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->count();

        $presentDays = Attendance::where('employee_id', $employee->id)
            ->whereMonth('date', now()->month)
            ->whereYear('date', now()->year)
            ->where('status', 'present')
            ->count();

        $attendancePercentage = $totalAttendance > 0 ? round(($presentDays / $totalAttendance) * 100, 2) : 0;

        $pendingLeaves = \App\Models\Leave::where('employee_id', $employee->id)
            ->where('status', 'pending')
            ->count();

        return response()->json([
            'success' => true,
            'stats' => [
                'total_work_logs' => $totalWorkLogs,
                'attendance_percentage' => $attendancePercentage,
                'pending_leaves' => $pendingLeaves,
            ]
        ]);
    }
}
