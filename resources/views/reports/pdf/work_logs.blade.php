<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Work Logs Report</title>
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
            border-bottom: 2px solid #43e97b;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #43e97b;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary-section {
            margin-bottom: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-grid {
            display: table;
            width: 100%;
        }
        .summary-row {
            display: table-row;
        }
        .summary-cell {
            display: table-cell;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        .summary-cell.header {
            background-color: #43e97b;
            color: white;
            font-weight: bold;
        }
        .summary-cell.value {
            background-color: white;
            font-weight: bold;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #43e97b;
            color: white;
            font-weight: bold;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-done {
            background-color: #d4edda;
            color: #155724;
        }
        .status-ongoing {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-in_progress {
            background-color: #cce7ff;
            color: #004085;
        }
        .hours-badge {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .statistics {
            margin-top: 30px;
            display: table;
            width: 100%;
        }
        .stat-row {
            display: table-row;
        }
        .stat-cell {
            display: table-cell;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #43e97b;
        }
        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
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
    </style>
</head>
<body>
    <div class="header">
        <h1>Work Logs Report</h1>
        <p>Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
        <p>Generated on: {{ now()->format('M d, Y H:i') }}</p>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <h3 style="margin-top: 0; color: #43e97b;">Work Logs Summary</h3>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell header">Total Logs</div>
                <div class="summary-cell header">Total Hours</div>
                <div class="summary-cell header">Completed</div>
                <div class="summary-cell header">Ongoing</div>
                <div class="summary-cell header">In Progress</div>
                <div class="summary-cell header">Days Worked</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell value">{{ $data['summary']['total_logs'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['total_hours'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['completed_tasks'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['ongoing_tasks'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['in_progress_tasks'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['days_worked'] }}</div>
            </div>
        </div>
    </div>

    <!-- Work Logs Records Table -->
    @if($data['workLogs']->count() > 0)
    <h3 style="color: #43e97b; border-bottom: 1px solid #43e97b; padding-bottom: 5px;">Work Log Records</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Employee</th>
                <th>Start Time</th>
                <th>End Time</th>
                <th>Duration</th>
                <th>Task Summary</th>
                <th>Status</th>
                <th>Action Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['workLogs'] as $workLog)
            <tr>
                <td>{{ \Carbon\Carbon::parse($workLog->work_date)->format('M d, Y') }}</td>
                <td>
                    <div style="font-weight: bold;">{{ $workLog->employee->name ?? 'N/A' }}</div>
                    <div style="font-size: 8px; color: #666;">{{ $workLog->employee->employee_code ?? 'N/A' }}</div>
                </td>
                <td>
                    @if($workLog->start_time)
                        {{ \Carbon\Carbon::parse($workLog->start_time)->format('H:i') }}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if($workLog->end_time)
                        {{ \Carbon\Carbon::parse($workLog->end_time)->format('H:i') }}
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
                        <span class="hours-badge">{{ $duration }}h</span>
                    @else
                        -
                    @endif
                </td>
                <td>{{ \Illuminate\Support\Str::limit($workLog->task_summary ?? 'N/A', 40) }}</td>
                <td>
                    @if($workLog->status)
                        <span class="status-badge status-{{ $workLog->status }}">
                            {{ ucfirst(str_replace('_', ' ', $workLog->status)) }}
                        </span>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $workLog->action_details ? \Illuminate\Support\Str::limit($workLog->action_details, 30) : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Statistics -->
    <div class="statistics">
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-value">{{ $data['summary']['average_hours_per_day'] }}</div>
                <div class="stat-label">Avg Hours/Day</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    {{ $data['summary']['total_logs'] > 0 ? number_format(($data['summary']['completed_tasks'] / $data['summary']['total_logs']) * 100, 1) : 0 }}%
                </div>
                <div class="stat-label">Completion Rate</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    {{ $data['workLogs']->groupBy('employee_id')->count() }}
                </div>
                <div class="stat-label">Active Employees</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    {{ $data['summary']['total_logs'] > 0 ? number_format($data['summary']['total_hours'] / $data['summary']['total_logs'], 1) : 0 }}
                </div>
                <div class="stat-label">Avg Hours/Log</div>
            </div>
        </div>
    </div>
    @else
    <div style="text-align: center; padding: 50px; color: #666;">
        <h3>No work logs found</h3>
        <p>No work log data available for the selected period.</p>
    </div>
    @endif

    <div class="footer">
        <p>Employee Management System - Work Logs Report | Generated on {{ now()->format('M d, Y H:i') }}</p>
    </div>
</body>
</html>
