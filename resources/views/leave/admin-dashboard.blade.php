@extends('layouts.app')

@section('title', 'Admin Leave Management Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="h3 mb-0">
                        <i class="fas fa-tachometer-alt me-2 text-primary"></i>
                        Leave Management Dashboard
                    </h1>
                    <p class="text-muted mb-0">Comprehensive admin tools for managing employee leave requests</p>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('leave.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-list me-1"></i>All Requests
                    </a>
                    <a href="{{ route('leave.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i>New Request
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-clock text-warning fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Pending Requests</div>
                            <div class="h4 mb-0 text-warning">{{ $stats['pending'] ?? 0 }}</div>
                            <div class="small text-muted">Requires attention</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-check text-success fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Approved Today</div>
                            <div class="h4 mb-0 text-success">{{ $stats['approved_today'] ?? 0 }}</div>
                            <div class="small text-muted">This month: {{ $stats['approved_month'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-times text-danger fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Rejected Today</div>
                            <div class="h4 mb-0 text-danger">{{ $stats['rejected_today'] ?? 0 }}</div>
                            <div class="small text-muted">This month: {{ $stats['rejected_month'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3">
                                <i class="fas fa-calendar text-info fa-lg"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small">Upcoming Leaves</div>
                            <div class="h4 mb-0 text-info">{{ $stats['upcoming'] ?? 0 }}</div>
                            <div class="small text-muted">Next 30 days</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions Panel -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <button class="btn btn-outline-success w-100 h-100 py-3" onclick="showBulkApprovalModal()">
                                <i class="fas fa-check-double fa-2x mb-2 d-block"></i>
                                <div class="fw-bold">Bulk Approve</div>
                                <small class="text-muted">Approve multiple requests</small>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-danger w-100 h-100 py-3" onclick="showBulkRejectionModal()">
                                <i class="fas fa-times-circle fa-2x mb-2 d-block"></i>
                                <div class="fw-bold">Bulk Reject</div>
                                <small class="text-muted">Reject multiple requests</small>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-outline-info w-100 h-100 py-3" onclick="showResponseTemplates()">
                                <i class="fas fa-comment-dots fa-2x mb-2 d-block"></i>
                                <div class="fw-bold">Response Templates</div>
                                <small class="text-muted">Manage message templates</small>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Pending Requests -->
    <div class="row">
        <!-- Pending Requests -->
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock me-2 text-warning"></i>Pending Requests
                    </h5>
                    <a href="{{ route('leave.index', ['status' => 'pending']) }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
                <div class="card-body p-0">
                    @if(isset($pendingRequests) && $pendingRequests->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Employee</th>
                                        <th>Leave Type</th>
                                        <th>Duration</th>
                                        <th>Days</th>
                                        <th>Submitted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingRequests->take(5) as $leave)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar-sm bg-primary bg-opacity-10 rounded-circle me-2 d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user text-primary"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-medium">{{ $leave->employee->name ?? 'N/A' }}</div>
                                                    <small class="text-muted">{{ $leave->employee->department ?? 'N/A' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-info bg-opacity-10 text-info">
                                                {{ $leave->leave_type_display }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="small">
                                                {{ $leave->start_date->format('d M') }} -
                                                {{ $leave->end_date->format('d M Y') }}
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge bg-secondary">{{ $leave->total_days }} days</span>
                                        </td>
                                        <td>
                                            <div class="small text-muted">
                                                {{ $leave->created_at->diffForHumans() }}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <button class="btn btn-success btn-sm"
                                                        onclick="quickApprove('{{ $leave->id }}', '{{ $leave->employee->name }}', '{{ $leave->leave_type_display }}')"
                                                        title="Quick Approve">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                                <button class="btn btn-danger btn-sm"
                                                        onclick="quickReject('{{ $leave->id }}', '{{ $leave->employee->name }}', '{{ $leave->leave_type_display }}')"
                                                        title="Quick Reject">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                                <a href="{{ route('leave.show', $leave) }}" class="btn btn-info btn-sm" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                            <h5>No Pending Requests</h5>
                            <p class="text-muted">All leave requests have been processed.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-history me-2 text-info"></i>Recent Activity
                    </h5>
                </div>
                <div class="card-body">
                    @if(isset($recentActivity) && $recentActivity->count() > 0)
                        <div class="timeline">
                            @foreach($recentActivity->take(5) as $activity)
                            <div class="timeline-item mb-3">
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <div class="timeline-icon bg-{{ $activity->status === 'approved' ? 'success' : ($activity->status === 'rejected' ? 'danger' : 'warning') }} bg-opacity-10 rounded-circle p-2">
                                            <i class="fas fa-{{ $activity->status === 'approved' ? 'check' : ($activity->status === 'rejected' ? 'times' : 'clock') }} text-{{ $activity->status === 'approved' ? 'success' : ($activity->status === 'rejected' ? 'danger' : 'warning') }}"></i>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="small fw-medium">
                                            {{ $activity->employee->name ?? 'Employee' }}
                                        </div>
                                        <div class="small text-muted">
                                            {{ ucfirst($activity->status) }} - {{ $activity->leave_type_display }}
                                        </div>
                                        <div class="small text-muted">
                                            {{ $activity->updated_at->diffForHumans() }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-history text-muted fa-2x mb-2"></i>
                            <p class="text-muted mb-0">No recent activity</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
}

.timeline-icon {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}
</style>
@endpush

@push('scripts')
<script src="{{ asset('js/leave-actions.js') }}"></script>
<script>
// Initialize dashboard
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Leave Actions Service
    window.leaveActions = new LeaveActionsService({
        routes: {
            approve: '{{ route("leave.approve", ":id") }}',
            reject: '{{ route("leave.reject", ":id") }}',
            destroy: '{{ route("leave.destroy", ":id") }}',
            bulkApprove: '{{ route("leave.bulk-approve") }}',
            bulkReject: '{{ route("leave.bulk-reject") }}'
        },
        csrfToken: '{{ csrf_token() }}',
        user: {
            isEmployee: false,
            hasManagePermission: true
        }
    });
});

// Quick approve function
function quickApprove(leaveId, employeeName, leaveType) {
    if (window.leaveActions) {
        window.leaveActions.approveLeave(leaveId, {
            employeeName: employeeName,
            leaveType: leaveType
        });
    }
}

// Quick reject function
function quickReject(leaveId, employeeName, leaveType) {
    if (window.leaveActions) {
        window.leaveActions.showRejectModal(leaveId, {
            employeeName: employeeName,
            leaveType: leaveType
        });
    }
}

// Show bulk approval modal
function showBulkApprovalModal() {
    window.location.href = '{{ route("leave.index") }}?show_bulk=true';
}

// Show bulk rejection modal
function showBulkRejectionModal() {
    window.location.href = '{{ route("leave.index") }}?show_bulk=true';
}

// Show response templates
function showResponseTemplates() {
    // Implementation for response templates modal
    alert('Response templates feature coming soon!');
}
</script>
@endpush
@endsection
