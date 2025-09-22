<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Leaves Report</title>
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
            border-bottom: 2px solid #a8edea;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #333;
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
            background-color: #6c757d;
            color: white;
            font-weight: bold;
        }
        .summary-cell.value {
            background-color: white;
            font-weight: bold;
            font-size: 16px;
        }
        .leave-types {
            margin-bottom: 20px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .leave-type-item {
            display: inline-block;
            margin: 5px;
            padding: 5px 10px;
            background-color: #e3f2fd;
            color: #1976d2;
            border-radius: 3px;
            font-size: 11px;
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
            background-color: #6c757d;
            color: white;
            font-weight: bold;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-approved { background-color: #d4edda; color: #155724; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-rejected { background-color: #f8d7da; color: #721c24; }
        .leave-type-badge {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
        }
        .days-badge {
            background-color: #f8f9fa;
            color: #495057;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: 500;
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
            color: #6c757d;
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
        <h1>Leaves Report</h1>
        <p>Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}</p>
        <p>Generated on: {{ now()->format('M d, Y H:i') }}</p>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <h3 style="margin-top: 0; color: #6c757d;">Leaves Summary</h3>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell header">Total Applications</div>
                <div class="summary-cell header">Approved</div>
                <div class="summary-cell header">Pending</div>
                <div class="summary-cell header">Rejected</div>
                <div class="summary-cell header">Total Days</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell value">{{ $data['summary']['total_leaves'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['approved'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['pending'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['rejected'] }}</div>
                <div class="summary-cell value">{{ $data['summary']['total_days'] }}</div>
            </div>
        </div>
    </div>

    <!-- Leave Types Distribution -->
    @if($data['summary']['leave_types']->count() > 0)
    <div class="leave-types">
        <h4 style="margin-top: 0; color: #6c757d;">Leave Types Distribution</h4>
        @foreach($data['summary']['leave_types'] as $type => $count)
            <span class="leave-type-item">{{ ucfirst($type) }}: {{ $count }}</span>
        @endforeach
    </div>
    @endif

    <!-- Leaves Records Table -->
    @if($data['leaves']->count() > 0)
    <h3 style="color: #6c757d; border-bottom: 1px solid #6c757d; padding-bottom: 5px;">Leave Records</h3>
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Leave Type</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Days</th>
                <th>Status</th>
                <th>Reason</th>
                <th>Approved By</th>
                <th>Admin Notes</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['leaves'] as $leave)
            <tr>
                <td>
                    <div style="font-weight: bold;">{{ $leave->employee->name ?? 'N/A' }}</div>
                    <div style="font-size: 8px; color: #666;">{{ $leave->employee->employee_code ?? 'N/A' }}</div>
                </td>
                <td>
                    <span class="leave-type-badge">{{ ucfirst($leave->leave_type) }}</span>
                </td>
                <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('M d, Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}</td>
                <td>
                    <span class="days-badge">{{ $leave->total_days }} days</span>
                </td>
                <td>
                    <span class="status-badge status-{{ $leave->status }}">
                        {{ ucfirst($leave->status) }}
                    </span>
                </td>
                <td>{{ $leave->reason ? Str::limit($leave->reason, 40) : '-' }}</td>
                <td>
                    @if($leave->approvedBy)
                        <div style="font-size: 9px;">
                            <div style="font-weight: bold;">{{ $leave->approvedBy->username }}</div>
                            @if($leave->approved_at)
                                <div style="color: #666;">{{ $leave->approved_at->format('M d, Y') }}</div>
                            @endif
                        </div>
                    @else
                        -
                    @endif
                </td>
                <td>{{ $leave->admin_notes ? Str::limit($leave->admin_notes, 30) : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Statistics -->
    <div class="statistics">
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-value">
                    {{ $data['summary']['total_leaves'] > 0 ? number_format(($data['summary']['approved'] / $data['summary']['total_leaves']) * 100, 1) : 0 }}%
                </div>
                <div class="stat-label">Approval Rate</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    {{ $data['summary']['approved'] > 0 ? number_format($data['summary']['total_days'] / $data['summary']['approved'], 1) : 0 }}
                </div>
                <div class="stat-label">Avg Days per Leave</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    {{ $data['leaves']->groupBy('employee_id')->count() }}
                </div>
                <div class="stat-label">Employees on Leave</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    {{ $data['summary']['leave_types']->count() }}
                </div>
                <div class="stat-label">Leave Types</div>
            </div>
        </div>
    </div>
    @else
    <div style="text-align: center; padding: 50px; color: #666;">
        <h3>No leave records found</h3>
        <p>No leave data available for the selected period.</p>
    </div>
    @endif

    <div class="footer">
        <p>Employee Management System - Leaves Report | Generated on {{ now()->format('M d, Y H:i') }}</p>
    </div>
</body>
</html>
