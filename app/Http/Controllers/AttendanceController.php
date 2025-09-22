<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of attendance records.
     */
    public function index(Request $request)
    {
        $query = Attendance::with('employee');

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('date', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('date', '<=', $request->date_to);
        }

        // Filter by employee
        if ($request->has('employee_id') && $request->employee_id) {
            $query->where('employee_id', $request->employee_id);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $attendances = $query->orderBy('date', 'desc')
                           ->orderBy('check_in', 'desc')
                           ->paginate(20);

        // Get employees for filter dropdown
        $employees = Employee::where('status', 'active')
                           ->orderBy('name')
                           ->get();

        // Get statistics
        $stats = [
            'total_today' => Attendance::whereDate('date', today())->count(),
            'present_today' => Attendance::whereDate('date', today())->where('status', 'present')->count(),
            'absent_today' => Attendance::whereDate('date', today())->where('status', 'absent')->count(),
            'late_today' => Attendance::whereDate('date', today())
                                    ->where('status', 'present')
                                    ->whereTime('check_in', '>', '09:00:00')
                                    ->count(),
        ];

        return view('attendance.index', compact('attendances', 'employees', 'stats'));
    }

    /**
     * Show the form for creating a new attendance record.
     */
    public function create()
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();
        return view('attendance.create', compact('employees'));
    }

    /**
     * Store a newly created attendance record.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'check_in_latitude' => 'nullable|numeric|between:-90,90',
            'check_in_longitude' => 'nullable|numeric|between:-180,180',
            'check_in_location' => 'nullable|string|max:255',
            'check_out_latitude' => 'nullable|numeric|between:-90,90',
            'check_out_longitude' => 'nullable|numeric|between:-180,180',
            'check_out_location' => 'nullable|string|max:255',
            'status' => 'required|in:present,sick,leave,absent',
            'notes' => 'nullable|string|max:1000',
            'attachment_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('attachment_image')) {
            $file = $request->file('attachment_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/attendance'), $filename);
            $validated['attachment_image'] = $filename;
        }

        Attendance::create($validated);

        return redirect()->route('attendance.index')
                        ->with('success', 'Attendance record created successfully.');
    }

    /**
     * Display the specified attendance record.
     */
    public function show(Attendance $attendance)
    {
        $attendance->load('employee');
        return view('attendance.show', compact('attendance'));
    }

    /**
     * Show the form for editing the specified attendance record.
     */
    public function edit(Attendance $attendance)
    {
        $employees = Employee::where('status', 'active')->orderBy('name')->get();
        return view('attendance.edit', compact('attendance', 'employees'));
    }

    /**
     * Update the specified attendance record.
     */
    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i|after:check_in',
            'status' => 'required|in:present,sick,leave,absent',
            'notes' => 'nullable|string|max:1000',
            'attachment_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Handle file upload
        if ($request->hasFile('attachment_image')) {
            // Delete old file if exists
            if ($attendance->attachment_image && file_exists(public_path('uploads/attendance/' . $attendance->attachment_image))) {
                unlink(public_path('uploads/attendance/' . $attendance->attachment_image));
            }

            $file = $request->file('attachment_image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/attendance'), $filename);
            $validated['attachment_image'] = $filename;
        }

        $attendance->update($validated);

        return redirect()->route('attendance.index')
                        ->with('success', 'Attendance record updated successfully.');
    }

    /**
     * Remove the specified attendance record.
     */
    public function destroy(Attendance $attendance)
    {
        // Delete attachment file if exists
        if ($attendance->attachment_image && file_exists(public_path('uploads/attendance/' . $attendance->attachment_image))) {
            unlink(public_path('uploads/attendance/' . $attendance->attachment_image));
        }

        $attendance->delete();

        return redirect()->route('attendance.index')
                        ->with('success', 'Attendance record deleted successfully.');
    }

    /**
     * Quick check-in for current user.
     */
    public function checkIn(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'No employee record found for your account.');
        }

        // Check if already checked in today
        $existingAttendance = Attendance::where('employee_id', $employee->id)
                                      ->whereDate('date', today())
                                      ->first();

        if ($existingAttendance) {
            return redirect()->back()->with('warning', 'You have already checked in today.');
        }

        Attendance::create([
            'employee_id' => $employee->id,
            'date' => today(),
            'check_in' => now()->format('H:i:s'),
            'check_in_latitude' => $request->latitude,
            'check_in_longitude' => $request->longitude,
            'check_in_location' => $request->location,
            'status' => 'present',
            'notes' => 'Quick check-in from dashboard'
        ]);

        return redirect()->back()->with('success', 'Check-in successful!');
    }

    /**
     * Quick check-out for current user.
     */
    public function checkOut(Request $request)
    {
        $user = Auth::user();
        $employee = $user->employee;

        if (!$employee) {
            return redirect()->back()->with('error', 'No employee record found for your account.');
        }

        // Find today's attendance record
        $attendance = Attendance::where('employee_id', $employee->id)
                                ->whereDate('date', today())
                                ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'No check-in record found for today.');
        }

        if ($attendance->check_out) {
            return redirect()->back()->with('warning', 'You have already checked out today.');
        }

        $attendance->update([
            'check_out' => now()->format('H:i:s'),
            'check_out_latitude' => $request->latitude,
            'check_out_longitude' => $request->longitude,
            'check_out_location' => $request->location,
        ]);

        return redirect()->back()->with('success', 'Check-out successful!');
    }

    /**
     * Get attendance report.
     */
    public function report(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $attendances = Attendance::with('employee')
                                ->whereMonth('date', $month)
                                ->whereYear('date', $year)
                                ->orderBy('date', 'desc')
                                ->get();

        $summary = [
            'total_records' => $attendances->count(),
            'present' => $attendances->where('status', 'present')->count(),
            'sick' => $attendances->where('status', 'sick')->count(),
            'leave' => $attendances->where('status', 'leave')->count(),
            'absent' => $attendances->where('status', 'absent')->count(),
        ];

        return view('attendance.report', compact('attendances', 'summary', 'month', 'year'));
    }

    /**
     * Get employee attendance analytics
     */
    public function getEmployeeAnalytics(Request $request, $employeeId)
    {
        try {
            $employee = Employee::findOrFail($employeeId);

            $now = Carbon::now();
            $currentWeekStart = $now->copy()->startOfWeek();
            $currentMonthStart = $now->copy()->startOfMonth();

            // Weekly analytics (last 4 weeks)
            $weeklyData = [];
            for ($i = 0; $i < 4; $i++) {
                $weekStart = $currentWeekStart->copy()->subWeeks($i);
                $weekEnd = $weekStart->copy()->endOfWeek();

                $weekAttendances = Attendance::where('employee_id', $employeeId)
                    ->whereBetween('date', [$weekStart->format('Y-m-d'), $weekEnd->format('Y-m-d')])
                    ->where('status', 'present')
                    ->get();

                $avgCheckIn = null;
                $avgCheckOut = null;
                $totalDays = $weekAttendances->count();

                if ($totalDays > 0) {
                    // Calculate average check-in time
                    $checkInTimes = $weekAttendances->whereNotNull('check_in')->pluck('check_in');
                    if ($checkInTimes->count() > 0) {
                        $totalCheckInMinutes = 0;
                        foreach ($checkInTimes as $time) {
                            // Handle both datetime objects and time strings
                            if ($time instanceof \Carbon\Carbon) {
                                $timeString = $time->format('H:i:s');
                            } else {
                                $timeString = $time;
                            }
                            $parts = explode(':', $timeString);
                            $totalCheckInMinutes += (intval($parts[0]) * 60) + intval($parts[1]);
                        }
                        $avgCheckInMinutes = round($totalCheckInMinutes / $checkInTimes->count());
                        $avgCheckIn = sprintf('%02d:%02d', floor($avgCheckInMinutes / 60), $avgCheckInMinutes % 60);
                    }

                    // Calculate average check-out time
                    $checkOutTimes = $weekAttendances->whereNotNull('check_out')->pluck('check_out');
                    if ($checkOutTimes->count() > 0) {
                        $totalCheckOutMinutes = 0;
                        foreach ($checkOutTimes as $time) {
                            // Handle both datetime objects and time strings
                            if ($time instanceof \Carbon\Carbon) {
                                $timeString = $time->format('H:i:s');
                            } else {
                                $timeString = $time;
                            }
                            $parts = explode(':', $timeString);
                            $totalCheckOutMinutes += (intval($parts[0]) * 60) + intval($parts[1]);
                        }
                        $avgCheckOutMinutes = round($totalCheckOutMinutes / $checkOutTimes->count());
                        $avgCheckOut = sprintf('%02d:%02d', floor($avgCheckOutMinutes / 60), $avgCheckOutMinutes % 60);
                    }
                }

                $weeklyData[] = [
                    'week_start' => $weekStart->format('M d'),
                    'week_end' => $weekEnd->format('M d, Y'),
                    'total_days' => $totalDays,
                    'avg_check_in' => $avgCheckIn,
                    'avg_check_out' => $avgCheckOut,
                    'attendance_rate' => $totalDays > 0 ? round(($totalDays / 5) * 100, 1) : 0 // Assuming 5 working days
                ];
            }

            // Monthly analytics (last 6 months)
            $monthlyData = [];
            for ($i = 0; $i < 6; $i++) {
                $monthStart = $currentMonthStart->copy()->subMonths($i);
                $monthEnd = $monthStart->copy()->endOfMonth();

                $monthAttendances = Attendance::where('employee_id', $employeeId)
                    ->whereBetween('date', [$monthStart->format('Y-m-d'), $monthEnd->format('Y-m-d')])
                    ->where('status', 'present')
                    ->get();

                $avgCheckIn = null;
                $avgCheckOut = null;
                $totalDays = $monthAttendances->count();
                $workingDays = $this->getWorkingDaysInMonth($monthStart);

                if ($totalDays > 0) {
                    // Calculate average check-in time
                    $checkInTimes = $monthAttendances->whereNotNull('check_in')->pluck('check_in');
                    if ($checkInTimes->count() > 0) {
                        $totalCheckInMinutes = 0;
                        foreach ($checkInTimes as $time) {
                            // Handle both datetime objects and time strings
                            if ($time instanceof \Carbon\Carbon) {
                                $timeString = $time->format('H:i:s');
                            } else {
                                $timeString = $time;
                            }
                            $parts = explode(':', $timeString);
                            $totalCheckInMinutes += (intval($parts[0]) * 60) + intval($parts[1]);
                        }
                        $avgCheckInMinutes = round($totalCheckInMinutes / $checkInTimes->count());
                        $avgCheckIn = sprintf('%02d:%02d', floor($avgCheckInMinutes / 60), $avgCheckInMinutes % 60);
                    }

                    // Calculate average check-out time
                    $checkOutTimes = $monthAttendances->whereNotNull('check_out')->pluck('check_out');
                    if ($checkOutTimes->count() > 0) {
                        $totalCheckOutMinutes = 0;
                        foreach ($checkOutTimes as $time) {
                            // Handle both datetime objects and time strings
                            if ($time instanceof \Carbon\Carbon) {
                                $timeString = $time->format('H:i:s');
                            } else {
                                $timeString = $time;
                            }
                            $parts = explode(':', $timeString);
                            $totalCheckOutMinutes += (intval($parts[0]) * 60) + intval($parts[1]);
                        }
                        $avgCheckOutMinutes = round($totalCheckOutMinutes / $checkOutTimes->count());
                        $avgCheckOut = sprintf('%02d:%02d', floor($avgCheckOutMinutes / 60), $avgCheckOutMinutes % 60);
                    }
                }

                $monthlyData[] = [
                    'month' => $monthStart->format('F Y'),
                    'total_days' => $totalDays,
                    'working_days' => $workingDays,
                    'avg_check_in' => $avgCheckIn,
                    'avg_check_out' => $avgCheckOut,
                    'attendance_rate' => $workingDays > 0 ? round(($totalDays / $workingDays) * 100, 1) : 0
                ];
            }

            return response()->json([
                'employee' => [
                    'name' => $employee->name,
                    'employee_code' => $employee->employee_code,
                    'position' => $employee->position ?? 'N/A'
                ],
                'weekly_analytics' => array_reverse($weeklyData),
                'monthly_analytics' => array_reverse($monthlyData)
            ]);
        } catch (\Exception $e) {
            \Log::error('Analytics error: ' . $e->getMessage() . ' | Line: ' . $e->getLine() . ' | File: ' . $e->getFile());
            return response()->json([
                'error' => 'Failed to load analytics data',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => basename($e->getFile())
            ], 500);
        }
    }

    /**
     * Calculate working days in a month (excluding weekends)
     */
    private function getWorkingDaysInMonth($date)
    {
        $start = $date->copy()->startOfMonth();
        $end = $date->copy()->endOfMonth();
        $workingDays = 0;

        while ($start->lte($end)) {
            if ($start->isWeekday()) {
                $workingDays++;
            }
            $start->addDay();
        }

        return $workingDays;
    }
}

