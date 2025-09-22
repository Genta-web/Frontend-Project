@extends('layouts.admin')

@section('title', 'Leave System Debug')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">🔧 Leave System Debug Information</h5>
                </div>
                <div class="card-body">
                    <!-- Current User Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">👤 Current User Information</h6>
                            <table class="table table-sm">
                                <tr>
                                    <td><strong>User ID:</strong></td>
                                    <td>{{ Auth::user()->id }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Username:</strong></td>
                                    <td>{{ Auth::user()->username }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Role:</strong></td>
                                    <td>
                                        <span class="badge bg-primary">{{ Auth::user()->role }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Is Admin:</strong></td>
                                    <td>
                                        @if(Auth::user()->isAdmin())
                                            <span class="badge bg-success">✅ Yes</span>
                                        @else
                                            <span class="badge bg-secondary">❌ No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Is HR:</strong></td>
                                    <td>
                                        @if(Auth::user()->isHR())
                                            <span class="badge bg-success">✅ Yes</span>
                                        @else
                                            <span class="badge bg-secondary">❌ No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Is Manager:</strong></td>
                                    <td>
                                        @if(Auth::user()->isManager())
                                            <span class="badge bg-success">✅ Yes</span>
                                        @else
                                            <span class="badge bg-secondary">❌ No</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Has Role [admin,hr,manager]:</strong></td>
                                    <td>
                                        @if(Auth::user()->hasRole(['admin', 'hr', 'manager']))
                                            <span class="badge bg-success">✅ Yes</span>
                                        @else
                                            <span class="badge bg-danger">❌ No</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">📊 Permission Check Results</h6>
                            @php
                                $testLeave = \App\Models\Leave::where('status', 'pending')->first();
                            @endphp
                            
                            @if($testLeave)
                                <table class="table table-sm">
                                    <tr>
                                        <td><strong>Test Leave ID:</strong></td>
                                        <td>{{ $testLeave->id }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Leave Status:</strong></td>
                                        <td>
                                            <span class="badge bg-warning">{{ $testLeave->status }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Can Approve:</strong></td>
                                        <td>
                                            @if(\App\Helpers\LeavePermissionHelper::canApprove(Auth::user(), $testLeave))
                                                <span class="badge bg-success">✅ Yes</span>
                                            @else
                                                <span class="badge bg-danger">❌ No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Can Reject:</strong></td>
                                        <td>
                                            @if(\App\Helpers\LeavePermissionHelper::canReject(Auth::user(), $testLeave))
                                                <span class="badge bg-success">✅ Yes</span>
                                            @else
                                                <span class="badge bg-danger">❌ No</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Can Bulk Action:</strong></td>
                                        <td>
                                            @if(\App\Helpers\LeavePermissionHelper::canBulkAction(Auth::user()))
                                                <span class="badge bg-success">✅ Yes</span>
                                            @else
                                                <span class="badge bg-danger">❌ No</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No pending leave requests found for testing permissions.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Pending Leaves -->
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary">📋 Pending Leave Requests</h6>
                            @php
                                $pendingLeaves = \App\Models\Leave::with(['employee'])
                                    ->where('status', 'pending')
                                    ->orderBy('created_at', 'desc')
                                    ->take(5)
                                    ->get();
                            @endphp

                            @if($pendingLeaves->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-sm table-striped">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Employee</th>
                                                <th>Leave Type</th>
                                                <th>Duration</th>
                                                <th>Status</th>
                                                <th>Actions Available</th>
                                                <th>Test Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($pendingLeaves as $leave)
                                            <tr>
                                                <td>{{ $leave->id }}</td>
                                                <td>{{ $leave->employee->name ?? 'N/A' }}</td>
                                                <td>{{ $leave->leave_type_display }}</td>
                                                <td>
                                                    {{ $leave->start_date->format('d M') }} - 
                                                    {{ $leave->end_date->format('d M Y') }}
                                                </td>
                                                <td>
                                                    <span class="badge bg-warning">{{ $leave->status }}</span>
                                                </td>
                                                <td>
                                                    @php
                                                        $actions = \App\Helpers\LeavePermissionHelper::getAvailableActions(Auth::user(), $leave);
                                                    @endphp
                                                    @foreach($actions as $action)
                                                        <span class="badge bg-info me-1">{{ $action }}</span>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    @if(Auth::user()->hasRole(['admin', 'hr', 'manager']) && $leave->isPending())
                                                        <form action="{{ route('leave.approve', $leave) }}" method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-xs" 
                                                                    onclick="return confirm('Approve this leave request?')">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <button type="button" class="btn btn-danger btn-xs" 
                                                                onclick="testReject({{ $leave->id }})">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    @else
                                                        <span class="text-muted">No actions</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No pending leave requests found.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Routes Test -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="text-primary">🔗 Routes Test</h6>
                            <div class="alert alert-secondary">
                                <strong>Available Routes:</strong><br>
                                <code>{{ route('leave.index') }}</code> - Leave Index<br>
                                @if($pendingLeaves->count() > 0)
                                    <code>{{ route('leave.approve', $pendingLeaves->first()) }}</code> - Approve Route<br>
                                    <code>{{ route('leave.reject', $pendingLeaves->first()) }}</code> - Reject Route<br>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <a href="{{ route('leave.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Leave Management
                            </a>
                            <button type="button" class="btn btn-info" onclick="location.reload()">
                                <i class="fas fa-sync me-2"></i>Refresh Debug Info
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Reject Modal -->
<div class="modal fade" id="testRejectModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Test Reject</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="testRejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="testAdminNotes" class="form-label">Reason for Rejection</label>
                        <textarea class="form-control" id="testAdminNotes" name="admin_notes" rows="3" required>Testing rejection functionality from debug page.</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Test Reject</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function testReject(leaveId) {
    document.getElementById('testRejectForm').action = '/leave/' + leaveId + '/reject';
    const modal = new bootstrap.Modal(document.getElementById('testRejectModal'));
    modal.show();
}
</script>
@endsection
