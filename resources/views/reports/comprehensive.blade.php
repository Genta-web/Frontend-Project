@extends('layouts.admin')

@section('title', 'Comprehensive Report')

@push('styles')
<style>
.report-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}
.section-card {
    border-radius: 0.5rem;
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    margin-bottom: 2rem;
}
.section-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem 1.25rem;
    border-radius: 0.5rem 0.5rem 0 0;
}
.status-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
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
.summary-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}
.summary-item {
    text-align: center;
    padding: 1rem;
    background-color: #f8f9fa;
    border-radius: 0.5rem;
}
.summary-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #495057;
}
.summary-label {
    font-size: 0.875rem;
    color: #6c757d;
    margin-top: 0.25rem;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Report Header -->
    <div class="report-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="h3 mb-0">
                    <i class="fas fa-file-alt"></i> Comprehensive Report
                </h1>
                <p class="mb-0 mt-2">
                    Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
                </p>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <a href="{{ route('reports.index') }}" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Back to Reports
                    </a>
                    <a href="{{ route('reports.comprehensive', array_merge(request()->all(), ['format' => 'pdf'])) }}"
                       class="btn btn-light">
                        <i class="fas fa-file-pdf"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Section -->
    @if(isset($data['attendances']) && $data['attendances']->count() > 0)
    <div class="section-card">
        <div class="section-header">
            <h5 class="mb-0">
                <i class="fas fa-calendar-check text-primary"></i> Attendance Summary
            </h5>
        </div>
        <div class="card-body">
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-value">{{ $data['attendances']->count() }}</div>
                    <div class="summary-label">Total Records</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-success">{{ $data['attendances']->where('status', 'present')->count() }}</div>
                    <div class="summary-label">Present</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-warning">{{ $data['attendances']->where('status', 'sick')->count() }}</div>
                    <div class="summary-label">Sick</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-info">{{ $data['attendances']->where('status', 'leave')->count() }}</div>
                    <div class="summary-label">Leave</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-danger">{{ $data['attendances']->where('status', 'absent')->count() }}</div>
                    <div class="summary-label">Absent</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['attendances']->take(10) as $attendance)
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
                @if($data['attendances']->count() > 10)
                    <p class="text-muted text-center">Showing 10 of {{ $data['attendances']->count() }} records. <a href="{{ route('reports.attendance', request()->all()) }}">View full attendance report</a></p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Work Logs Section -->
    @if(isset($data['workLogs']) && $data['workLogs']->count() > 0)
    <div class="section-card">
        <div class="section-header">
            <h5 class="mb-0">
                <i class="fas fa-tasks text-success"></i> Work Logs Summary
            </h5>
        </div>
        <div class="card-body">
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-value">{{ $data['workLogs']->count() }}</div>
                    <div class="summary-label">Total Logs</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-success">{{ $data['workLogs']->where('status', 'done')->count() }}</div>
                    <div class="summary-label">Completed</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-warning">{{ $data['workLogs']->where('status', 'ongoing')->count() }}</div>
                    <div class="summary-label">Ongoing</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-info">{{ $data['workLogs']->where('status', 'in_progress')->count() }}</div>
                    <div class="summary-label">In Progress</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Employee</th>
                            <th>Task Summary</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['workLogs']->take(10) as $workLog)
                        <tr>
                            <td>{{ $workLog->work_date->format('M d, Y') }}</td>
                            <td>{{ $workLog->employee->name }}</td>
                            <td>{{ Str::limit($workLog->task_summary, 50) }}</td>
                            <td>
                                @if($workLog->status)
                                    <span class="status-badge status-{{ $workLog->status }}">{{ ucfirst(str_replace('_', ' ', $workLog->status)) }}</span>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($data['workLogs']->count() > 10)
                    <p class="text-muted text-center">Showing 10 of {{ $data['workLogs']->count() }} records. <a href="{{ route('reports.work-logs', request()->all()) }}">View full work logs report</a></p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Jobs Section -->
    @if(isset($data['jobs']) && $data['jobs']->count() > 0)
    <div class="section-card">
        <div class="section-header">
            <h5 class="mb-0">
                <i class="fas fa-briefcase text-warning"></i> Jobs Summary
            </h5>
        </div>
        <div class="card-body">
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-value">{{ $data['jobs']->count() }}</div>
                    <div class="summary-label">Total Jobs</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-warning">{{ $data['jobs']->where('job_status', 'pending')->count() }}</div>
                    <div class="summary-label">Pending</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-info">{{ $data['jobs']->where('job_status', 'in_progress')->count() }}</div>
                    <div class="summary-label">In Progress</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-success">{{ $data['jobs']->where('job_status', 'completed')->count() }}</div>
                    <div class="summary-label">Completed</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Job Title</th>
                            <th>Employee</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['jobs']->take(10) as $job)
                        <tr>
                            <td>{{ Str::limit($job->name, 30) }}</td>
                            <td>{{ $job->employee->name }}</td>
                            <td>{{ ucfirst($job->priority) }}</td>
                            <td><span class="status-badge status-{{ $job->job_status }}">{{ ucfirst(str_replace('_', ' ', $job->job_status)) }}</span></td>
                            <td>{{ $job->progress_percentage }}%</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($data['jobs']->count() > 10)
                    <p class="text-muted text-center">Showing 10 of {{ $data['jobs']->count() }} records. <a href="{{ route('reports.jobs', request()->all()) }}">View full jobs report</a></p>
                @endif
            </div>
        </div>
    </div>
    @endif

    <!-- Leaves Section -->
    @if(isset($data['leaves']) && $data['leaves']->count() > 0)
    <div class="section-card">
        <div class="section-header">
            <h5 class="mb-0">
                <i class="fas fa-user-clock text-info"></i> Leaves Summary
            </h5>
        </div>
        <div class="card-body">
            <div class="summary-grid">
                <div class="summary-item">
                    <div class="summary-value">{{ $data['leaves']->count() }}</div>
                    <div class="summary-label">Total Applications</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-success">{{ $data['leaves']->where('status', 'approved')->count() }}</div>
                    <div class="summary-label">Approved</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-warning">{{ $data['leaves']->where('status', 'pending')->count() }}</div>
                    <div class="summary-label">Pending</div>
                </div>
                <div class="summary-item">
                    <div class="summary-value text-danger">{{ $data['leaves']->where('status', 'rejected')->count() }}</div>
                    <div class="summary-label">Rejected</div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Employee</th>
                            <th>Leave Type</th>
                            <th>Period</th>
                            <th>Days</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['leaves']->take(10) as $leave)
                        <tr>
                            <td>{{ $leave->employee->name }}</td>
                            <td>{{ ucfirst($leave->leave_type) }}</td>
                            <td>{{ $leave->start_date->format('M d') }} - {{ $leave->end_date->format('M d, Y') }}</td>
                            <td>{{ $leave->total_days }} days</td>
                            <td><span class="status-badge status-{{ $leave->status }}">{{ ucfirst($leave->status) }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @if($data['leaves']->count() > 10)
                    <p class="text-muted text-center">Showing 10 of {{ $data['leaves']->count() }} records. <a href="{{ route('reports.leaves', request()->all()) }}">View full leaves report</a></p>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if(!isset($data['attendances']) && !isset($data['workLogs']) && !isset($data['jobs']) && !isset($data['leaves']))
    <div class="text-center py-5">
        <i class="fas fa-file-alt fa-3x text-muted mb-3"></i>
        <h5 class="text-muted">No data found</h5>
        <p class="text-muted">No data available for the selected period and filters.</p>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle PDF download links - prevent loading overlay
    const pdfDownloadLinks = document.querySelectorAll('a[href*="format=pdf"]');
    pdfDownloadLinks.forEach(link => {
        // Add event listener with high priority (capture phase)
        link.addEventListener('click', function(e) {
            // Prevent any loading overlay from showing
            e.stopPropagation();
            e.stopImmediatePropagation();

            // Hide any existing loading overlay immediately
            const loadingOverlay = document.getElementById('loadingOverlay');
            if (loadingOverlay) {
                loadingOverlay.classList.remove('show');
                loadingOverlay.style.display = 'none';
            }

            // Override any global showLoading function temporarily
            const originalShowLoading = window.showLoading;
            window.showLoading = function() {
                console.log('Loading prevented for PDF download');
            };

            // Restore original function after a short delay
            setTimeout(() => {
                window.showLoading = originalShowLoading;
            }, 1000);

            // Add CSS rule to force hide loading overlay
            const style = document.createElement('style');
            style.id = 'pdf-download-style';
            style.textContent = `
                .loading-overlay, #loadingOverlay {
                    display: none !important;
                    opacity: 0 !important;
                    visibility: hidden !important;
                }
            `;
            document.head.appendChild(style);

            // Remove the style after download starts
            setTimeout(() => {
                const styleElement = document.getElementById('pdf-download-style');
                if (styleElement) {
                    styleElement.remove();
                }
            }, 2000);

            // Allow the link to proceed normally
            return true;
        }, true); // Use capture phase for higher priority
    });
});
</script>
@endpush
