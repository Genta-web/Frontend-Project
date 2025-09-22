<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Attendance Report</title>
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
            border-bottom: 2px solid #4facfe;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #4facfe;
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
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        .summary-cell.header {
            background-color: #4facfe;
            color: white;
            font-weight: bold;
        }
        .summary-cell.value {
            background-color: white;
            font-weight: bold;
            font-size: 16px;
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
            font-size: 11px;
        }
        th {
            background-color: #4facfe;
            color: white;
            font-weight: bold;
        }
        .status-badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-present {
            background-color: #d4edda;
            color: #155724;
        }
        .status-sick {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-leave {
            background-color: #cce7ff;
            color: #004085;
        }
        .status-absent {
            background-color: #f8d7da;
            color: #721c24;
        }
        .time-badge {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 10px;
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
            font-size: 18px;
            font-weight: bold;
            color: #4facfe;
        }
        .stat-label {
            font-size: 12px;
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
        <h1>Attendance Report</h1>
        <p>Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
        <p>Generated on: {{ now()->format('M d, Y H:i') }}</p>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <h3 style="margin-top: 0; color: #4facfe;">Attendance Summary</h3>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell header">Total Records</div>
                <div class="summary-cell header">Present</div>
                <div class="summary-cell header">Sick</div>
                <div class="summary-cell header">Leave</div>
                <div class="summary-cell header">Absent</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell value">{{ $data['summary']['total_records'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['present'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['sick'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['leave'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['absent'] }}</div>
            </div>
        </div>
    </div>

    <!-- Attendance Records Table -->
    @if($data['attendances']->count() > 0)
    <h3 style="color: #4facfe; border-bottom: 1px solid #4facfe; padding-bottom: 5px;">Attendance Records</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Employee</th>
                <th>Employee Code</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Status</th>
                <th>Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['attendances'] as $attendance)
            <tr>
                <td>
                    @if(!empty($attendance->date))
                        {{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}
                    @else
                        -
                    @endif
                </td>
                <td>{{ $attendance->employee->name ?? 'N/A' }}</td>
                <td>{{ $attendance->employee->employee_code ?? 'N/A' }}</td>
                <td>
                    @if(!empty($attendance->check_in))
                        <span class="time-badge">{{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}</span>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if(!empty($attendance->check_out))
                        <span class="time-badge">{{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}</span>
                    @else
                        -
                    @endif
                </td>
                <td>
                    <span class="status-badge status-{{ $attendance->status }}">
                        {{ ucfirst($attendance->status) }}
                    </span>
                </td>
                <td>{{ $attendance->notes ? \Illuminate\Support\Str::limit($attendance->notes, 30) : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Statistics -->
    <div class="statistics">
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-value">
                    {{ $data['summary']['total_records'] > 0 ? number_format(($data['summary']['present'] / $data['summary']['total_records']) * 100, 1) : 0 }}%
                </div>
                <div class="stat-label">Present Rate</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    {{ $data['summary']['total_records'] > 0 ? number_format(($data['summary']['absent'] / $data['summary']['total_records']) * 100, 1) : 0 }}%
                </div>
                <div class="stat-label">Absence Rate</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    {{ $data['attendances']->groupBy('employee_id')->count() }}
                </div>
                <div class="stat-label">Employees</div>
            </div>
        </div>
    </div>
    @else
    <div style="text-align: center; padding: 50px; color: #666;">
        <h3>No attendance records found</h3>
        <p>No attendance data available for the selected period.</p>
    </div>
    @endif

    <div class="footer">
        <p>Employee Management System - Attendance Report | Generated on {{ now()->format('M d, Y H:i') }}</p>
    </div>
</body>
</html>
