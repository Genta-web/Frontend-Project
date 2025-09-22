<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Comprehensive Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #007bff;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .section-title {
            background-color: #f8f9fa;
            padding: 10px;
            border-left: 4px solid #007bff;
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 15px;
        }
        .summary-grid {
            display: table;
            width: 100%;
            margin-bottom: 20px;
        }
        .summary-row {
            display: table-row;
        }
        .summary-cell {
            display: table-cell;
            padding: 8px;
            border: 1px solid #ddd;
            text-align: center;
            background-color: #f8f9fa;
        }
        .summary-cell.value {
            background-color: white;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-present { background-color: #d4edda; color: #155724; }
        .status-sick { background-color: #fff3cd; color: #856404; }
        .status-leave { background-color: #cce7ff; color: #004085; }
        .status-absent { background-color: #f8d7da; color: #721c24; }
        .status-done { background-color: #d4edda; color: #155724; }
        .status-ongoing { background-color: #fff3cd; color: #856404; }
        .status-in_progress { background-color: #cce7ff; color: #004085; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-completed { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        .status-approved { background-color: #d4edda; color: #155724; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Comprehensive Employee Report</h1>
        <p>Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
        <p>Generated on: {{ now()->format('M d, Y H:i') }}</p>
    </div>

    <!-- Attendance Section -->
    @if(isset($data['attendances']) && $data['attendances']->count() > 0)
    <div class="section">
        <div class="section-title">Attendance Summary</div>
        
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">Total Records</div>
                <div class="summary-cell">Present</div>
                <div class="summary-cell">Sick</div>
                <div class="summary-cell">Leave</div>
                <div class="summary-cell">Absent</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell value">{{ $data['attendances']->count() }}</div>
                <div class="summary-cell value">{{ $data['attendances']->where('status', 'present')->count() }}</div>
                <div class="summary-cell value">{{ $data['attendances']->where('status', 'sick')->count() }}</div>
                <div class="summary-cell value">{{ $data['attendances']->where('status', 'leave')->count() }}</div>
                <div class="summary-cell value">{{ $data['attendances']->where('status', 'absent')->count() }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Employee</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['attendances']->take(50) as $attendance)
                <tr>
                    <td>{{ $attendance->date->format('M d, Y') }}</td>
                    <td>{{ $attendance->employee->name }}</td>
                    <td>{{ $attendance->check_in ? $attendance->check_in->format('H:i') : '-' }}</td>
                    <td>{{ $attendance->check_out ? $attendance->check_out->format('H:i') : '-' }}</td>
                    <td><span class="status-badge status-{{ $attendance->status }}">{{ ucfirst($attendance->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Work Logs Section -->
    @if(isset($data['workLogs']) && $data['workLogs']->count() > 0)
    <div class="section page-break">
        <div class="section-title">Work Logs Summary</div>
        
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">Total Logs</div>
                <div class="summary-cell">Completed</div>
                <div class="summary-cell">Ongoing</div>
                <div class="summary-cell">In Progress</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell value">{{ $data['workLogs']->count() }}</div>
                <div class="summary-cell value">{{ $data['workLogs']->where('status', 'done')->count() }}</div>
                <div class="summary-cell value">{{ $data['workLogs']->where('status', 'ongoing')->count() }}</div>
                <div class="summary-cell value">{{ $data['workLogs']->where('status', 'in_progress')->count() }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Employee</th>
                    <th>Task Summary</th>
                    <th>Status</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['workLogs']->take(50) as $workLog)
                <tr>
                    <td>{{ $workLog->work_date->format('M d, Y') }}</td>
                    <td>{{ $workLog->employee->name }}</td>
                    <td>{{ Str::limit($workLog->task_summary, 40) }}</td>
                    <td>
                        @if($workLog->status)
                            <span class="status-badge status-{{ $workLog->status }}">{{ ucfirst(str_replace('_', ' ', $workLog->status)) }}</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        @if($workLog->start_time && $workLog->end_time)
                            @php
                                $start = \Carbon\Carbon::parse($workLog->start_time);
                                $end = \Carbon\Carbon::parse($workLog->end_time);
                                $duration = $end->diffInHours($start);
                            @endphp
                            {{ $duration }}h
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Jobs Section -->
    @if(isset($data['jobs']) && $data['jobs']->count() > 0)
    <div class="section page-break">
        <div class="section-title">Jobs Summary</div>
        
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">Total Jobs</div>
                <div class="summary-cell">Pending</div>
                <div class="summary-cell">In Progress</div>
                <div class="summary-cell">Completed</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell value">{{ $data['jobs']->count() }}</div>
                <div class="summary-cell value">{{ $data['jobs']->where('job_status', 'pending')->count() }}</div>
                <div class="summary-cell value">{{ $data['jobs']->where('job_status', 'in_progress')->count() }}</div>
                <div class="summary-cell value">{{ $data['jobs']->where('job_status', 'completed')->count() }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Employee</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['jobs']->take(50) as $job)
                <tr>
                    <td>{{ Str::limit($job->name, 30) }}</td>
                    <td>{{ $job->employee->name }}</td>
                    <td>{{ ucfirst($job->priority) }}</td>
                    <td><span class="status-badge status-{{ $job->job_status }}">{{ ucfirst(str_replace('_', ' ', $job->job_status)) }}</span></td>
                    <td>{{ $job->progress_percentage }}%</td>
                    <td>{{ $job->due_date ? $job->due_date->format('M d, Y') : '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <!-- Leaves Section -->
    @if(isset($data['leaves']) && $data['leaves']->count() > 0)
    <div class="section page-break">
        <div class="section-title">Leaves Summary</div>
        
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">Total Applications</div>
                <div class="summary-cell">Approved</div>
                <div class="summary-cell">Pending</div>
                <div class="summary-cell">Rejected</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell value">{{ $data['leaves']->count() }}</div>
                <div class="summary-cell value">{{ $data['leaves']->where('status', 'approved')->count() }}</div>
                <div class="summary-cell value">{{ $data['leaves']->where('status', 'pending')->count() }}</div>
                <div class="summary-cell value">{{ $data['leaves']->where('status', 'rejected')->count() }}</div>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Employee</th>
                    <th>Leave Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Days</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data['leaves']->take(50) as $leave)
                <tr>
                    <td>{{ $leave->employee->name }}</td>
                    <td>{{ ucfirst($leave->leave_type) }}</td>
                    <td>{{ $leave->start_date->format('M d, Y') }}</td>
                    <td>{{ $leave->end_date->format('M d, Y') }}</td>
                    <td>{{ $leave->total_days }}</td>
                    <td><span class="status-badge status-{{ $leave->status }}">{{ ucfirst($leave->status) }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif

    <div class="footer">
        <p>Employee Management System - Comprehensive Report | Page <span class="pagenum"></span></p>
    </div>
</body>
</html>
