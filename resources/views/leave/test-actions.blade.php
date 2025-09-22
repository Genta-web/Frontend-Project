@extends('layouts.admin')

@section('title', 'Test Leave Actions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">🧪 Test Leave Actions - Debug Mode</h5>
                </div>
                <div class="card-body">
                    <!-- Current User Info -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">👤 Current User Information</h6>
                            <table class="table table-sm table-bordered">
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
                                    <td><strong>hasRole(['admin', 'hr', 'manager']):</strong></td>
                                    <td>
                                        @if(Auth::user()->hasRole(['admin', 'hr', 'manager']))
                                            <span class="badge bg-success">✅ TRUE</span>
                                        @else
                                            <span class="badge bg-danger">❌ FALSE</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>isEmployee():</strong></td>
                                    <td>
                                        @if(Auth::user()->isEmployee())
                                            <span class="badge bg-info">✅ TRUE</span>
                                        @else
                                            <span class="badge bg-secondary">❌ FALSE</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">📊 Leave Statistics</h6>
                            @php
                                $pendingLeaves = \App\Models\Leave::where('status', 'pending')->get();
                                $totalLeaves = \App\Models\Leave::count();
                            @endphp
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <td><strong>Total Leaves:</strong></td>
                                    <td>{{ $totalLeaves }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Pending Leaves:</strong></td>
                                    <td>
                                        <span class="badge bg-warning">{{ $pendingLeaves->count() }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Routes Available:</strong></td>
                                    <td>
                                        @try
                                            <span class="badge bg-success">{{ route('leave.approve', 1) }}</span><br>
                                            <span class="badge bg-danger">{{ route('leave.reject', 1) }}</span>
                                        @catch(\Exception $e)
                                            <span class="badge bg-danger">Routes Error</span>
                                        @endtry
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Test Actions -->
                    @if($pendingLeaves->count() > 0)
                    <div class="row">
                        <div class="col-12">
                            <h6 class="text-primary">🧪 Test Actions on Pending Leaves</h6>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Employee</th>
                                            <th>Leave Type</th>
                                            <th>Duration</th>
                                            <th>Status</th>
                                            <th>Condition Check</th>
                                            <th>Test Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingLeaves->take(5) as $leave)
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
                                                <small>
                                                    isPending: {{ $leave->isPending() ? '✅' : '❌' }}<br>
                                                    hasRole: {{ Auth::user()->hasRole(['admin', 'hr', 'manager']) ? '✅' : '❌' }}<br>
                                                    Combined: {{ ($leave->isPending() && Auth::user()->hasRole(['admin', 'hr', 'manager'])) ? '✅ SHOW' : '❌ HIDE' }}
                                                </small>
                                            </td>
                                            <td>
                                                <!-- ALWAYS SHOW TEST BUTTONS -->
                                                <div class="d-grid gap-1">
                                                    <form action="{{ route('leave.approve', $leave) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        <input type="hidden" name="admin_message" value="Test approval from debug page">
                                                        <button type="submit" class="btn btn-success btn-sm w-100" 
                                                                onclick="return confirm('🧪 TEST APPROVE\n\nLeave ID: {{ $leave->id }}\nEmployee: {{ $leave->employee->name ?? 'N/A' }}\n\nProceed with test approval?')">
                                                            <i class="fas fa-check me-1"></i>TEST APPROVE
                                                        </button>
                                                    </form>
                                                    <button type="button" class="btn btn-danger btn-sm w-100"
                                                            onclick="testRejectAction({{ $leave->id }}, '{{ $leave->employee->name ?? 'Employee' }}')">
                                                        <i class="fas fa-times me-1"></i>TEST REJECT
                                                    </button>
                                                    <a href="{{ route('leave.show', $leave) }}" class="btn btn-info btn-sm w-100">
                                                        <i class="fas fa-eye me-1"></i>VIEW DETAILS
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>No pending leave requests found.</strong><br>
                        Create some pending leave requests to test the actions.
                    </div>
                    @endif

                    <!-- Navigation -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex gap-2">
                                <a href="{{ route('leave.index') }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Back to Leave Management
                                </a>
                                <a href="{{ route('leave.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>Create Test Leave Request
                                </a>
                                <button type="button" class="btn btn-info" onclick="location.reload()">
                                    <i class="fas fa-sync me-2"></i>Refresh
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Instructions -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="alert alert-warning">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>Testing Instructions:</h6>
                                <ol>
                                    <li><strong>Check User Role:</strong> Make sure you have admin/hr/manager role</li>
                                    <li><strong>Check Conditions:</strong> Verify isPending and hasRole both show ✅</li>
                                    <li><strong>Test Actions:</strong> Use TEST APPROVE/REJECT buttons above</li>
                                    <li><strong>Check Results:</strong> Verify success/error messages and database updates</li>
                                    <li><strong>Debug Issues:</strong> Check browser console for JavaScript errors</li>
                                </ol>
                            </div>
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
                <h5 class="modal-title">🧪 Test Reject Action</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="testRejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-info">
                        <strong>Testing Reject Action</strong><br>
                        Employee: <span id="testEmployeeName">-</span><br>
                        Leave ID: <span id="testLeaveId">-</span>
                    </div>
                    <div class="mb-3">
                        <label for="testAdminNotes" class="form-label">Test Rejection Reason</label>
                        <textarea class="form-control" id="testAdminNotes" name="admin_notes" rows="3" required>Testing rejection functionality from debug page.</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-times me-2"></i>Test Reject
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function testRejectAction(leaveId, employeeName) {
    document.getElementById('testRejectForm').action = '/leave/' + leaveId + '/reject';
    document.getElementById('testEmployeeName').textContent = employeeName;
    document.getElementById('testLeaveId').textContent = leaveId;
    
    const modal = new bootstrap.Modal(document.getElementById('testRejectModal'));
    modal.show();
}

// Log debug info to console
console.log('🧪 Test Actions Page Loaded');
console.log('User Role:', '{{ Auth::user()->role }}');
console.log('Has Admin Role:', {{ Auth::user()->hasRole(['admin', 'hr', 'manager']) ? 'true' : 'false' }});
console.log('Pending Leaves Count:', {{ $pendingLeaves->count() }});
</script>
@endsection
