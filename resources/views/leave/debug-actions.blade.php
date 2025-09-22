@extends('layouts.admin')

@section('title', 'Debug Leave Actions')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="card-title mb-0">🔧 Debug Leave Actions - Real-time Testing</h5>
                </div>
                <div class="card-body">
                    <!-- Current User Debug -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">👤 Current User Debug</h6>
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
                                    <td><span class="badge bg-primary">{{ Auth::user()->role }}</span></td>
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
                                    <td><strong>Employee ID:</strong></td>
                                    <td>{{ Auth::user()->employee?->id ?? 'NULL' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">🔗 Routes Debug</h6>
                            <table class="table table-sm table-bordered">
                                <tr>
                                    <td><strong>Approve Route:</strong></td>
                                    <td>
                                        @try
                                            <span class="badge bg-success">{{ route('leave.approve', 1) }}</span>
                                        @catch(\Exception $e)
                                            <span class="badge bg-danger">ERROR: {{ $e->getMessage() }}</span>
                                        @endtry
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Reject Route:</strong></td>
                                    <td>
                                        @try
                                            <span class="badge bg-success">{{ route('leave.reject', 1) }}</span>
                                        @catch(\Exception $e)
                                            <span class="badge bg-danger">ERROR: {{ $e->getMessage() }}</span>
                                        @endtry
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>CSRF Token:</strong></td>
                                    <td><code>{{ csrf_token() }}</code></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <!-- Pending Leaves Debug -->
                    @php
                        $pendingLeaves = \App\Models\Leave::where('status', 'pending')->with('employee')->get();
                    @endphp
                    
                    <h6 class="text-primary">📋 Pending Leaves Debug ({{ $pendingLeaves->count() }})</h6>
                    
                    @if($pendingLeaves->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Employee</th>
                                        <th>Type</th>
                                        <th>Status</th>
                                        <th>Permission Check</th>
                                        <th>Direct Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pendingLeaves->take(5) as $leave)
                                    <tr>
                                        <td>{{ $leave->id }}</td>
                                        <td>{{ $leave->employee->name ?? 'N/A' }}</td>
                                        <td>{{ $leave->leave_type_display }}</td>
                                        <td>
                                            <span class="badge bg-warning">{{ $leave->status }}</span>
                                        </td>
                                        <td>
                                            @php
                                                $canApprove = \App\Helpers\LeavePermissionHelper::canApprove(Auth::user(), $leave);
                                                $canReject = \App\Helpers\LeavePermissionHelper::canReject(Auth::user(), $leave);
                                            @endphp
                                            <small>
                                                isPending: {{ $leave->isPending() ? '✅' : '❌' }}<br>
                                                canApprove: {{ $canApprove ? '✅' : '❌' }}<br>
                                                canReject: {{ $canReject ? '✅' : '❌' }}
                                            </small>
                                        </td>
                                        <td>
                                            <!-- DIRECT APPROVE FORM -->
                                            <form action="{{ route('leave.approve', $leave) }}" method="POST" style="display: inline;" onsubmit="return debugSubmit(this, 'approve')">
                                                @csrf
                                                <input type="hidden" name="admin_message" value="Debug approval test">
                                                <button type="submit" class="btn btn-success btn-sm mb-1 w-100">
                                                    <i class="fas fa-check me-1"></i>DEBUG APPROVE
                                                </button>
                                            </form>
                                            
                                            <!-- DIRECT REJECT FORM -->
                                            <form action="{{ route('leave.reject', $leave) }}" method="POST" style="display: inline;" onsubmit="return debugSubmit(this, 'reject')">
                                                @csrf
                                                <input type="hidden" name="admin_notes" value="Debug rejection test">
                                                <button type="submit" class="btn btn-danger btn-sm mb-1 w-100">
                                                    <i class="fas fa-times me-1"></i>DEBUG REJECT
                                                </button>
                                            </form>
                                            
                                            <!-- VIEW LINK -->
                                            <a href="{{ route('leave.show', $leave) }}" class="btn btn-info btn-sm w-100" target="_blank">
                                                <i class="fas fa-eye me-1"></i>VIEW DETAIL
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-warning">
                            <h6><i class="fas fa-exclamation-triangle me-2"></i>No Pending Leaves Found</h6>
                            <p class="mb-0">Create some pending leave requests to test the actions.</p>
                            <a href="{{ route('leave.create') }}" class="btn btn-primary mt-2">
                                <i class="fas fa-plus me-1"></i>Create Test Leave Request
                            </a>
                        </div>
                    @endif

                    <!-- Manual Test Forms -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6 class="text-primary">🧪 Manual Approve Test</h6>
                            <form id="manualApproveForm" onsubmit="return manualTest(this, 'approve')">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Leave ID:</label>
                                    <input type="number" name="leave_id" class="form-control" placeholder="Enter leave ID" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Admin Message:</label>
                                    <textarea name="admin_message" class="form-control" rows="2" placeholder="Optional message..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check me-1"></i>Manual Approve Test
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-primary">🧪 Manual Reject Test</h6>
                            <form id="manualRejectForm" onsubmit="return manualTest(this, 'reject')">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Leave ID:</label>
                                    <input type="number" name="leave_id" class="form-control" placeholder="Enter leave ID" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Rejection Reason:</label>
                                    <textarea name="admin_notes" class="form-control" rows="2" placeholder="Required rejection reason..." required></textarea>
                                </div>
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-times me-1"></i>Manual Reject Test
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Debug Log -->
                    <div class="mt-4">
                        <h6 class="text-primary">📝 Debug Log</h6>
                        <div id="debugLog" class="border p-3 bg-light" style="height: 200px; overflow-y: auto; font-family: monospace; font-size: 0.875rem;">
                            <div class="text-muted">Debug log will appear here...</div>
                        </div>
                        <button type="button" class="btn btn-secondary btn-sm mt-2" onclick="clearDebugLog()">
                            <i class="fas fa-trash me-1"></i>Clear Log
                        </button>
                    </div>

                    <!-- Navigation -->
                    <div class="mt-4">
                        <div class="d-flex gap-2">
                            <a href="{{ route('leave.index') }}" class="btn btn-primary">
                                <i class="fas fa-arrow-left me-1"></i>Back to Leave Management
                            </a>
                            <button type="button" class="btn btn-info" onclick="location.reload()">
                                <i class="fas fa-sync me-1"></i>Refresh Debug
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function debugLog(message) {
    const log = document.getElementById('debugLog');
    const timestamp = new Date().toLocaleTimeString();
    log.innerHTML += `<div>[${timestamp}] ${message}</div>`;
    log.scrollTop = log.scrollHeight;
}

function clearDebugLog() {
    document.getElementById('debugLog').innerHTML = '<div class="text-muted">Debug log cleared...</div>';
}

function debugSubmit(form, action) {
    debugLog(`🔄 Attempting ${action} action...`);
    debugLog(`📝 Form action: ${form.action}`);
    debugLog(`🔑 CSRF token: ${form.querySelector('[name="_token"]').value}`);
    
    const formData = new FormData(form);
    debugLog(`📋 Form data: ${Array.from(formData.entries()).map(([k,v]) => `${k}=${v}`).join(', ')}`);
    
    return confirm(`Debug ${action.toUpperCase()}?\n\nThis will actually perform the action.\nForm: ${form.action}\nContinue?`);
}

function manualTest(form, action) {
    const leaveId = form.querySelector('[name="leave_id"]').value;
    const url = `/leave/${leaveId}/${action}`;
    
    debugLog(`🧪 Manual ${action} test for Leave ID: ${leaveId}`);
    debugLog(`🔗 Target URL: ${url}`);
    
    // Create actual form and submit
    const realForm = document.createElement('form');
    realForm.method = 'POST';
    realForm.action = url;
    
    // Add CSRF token
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    realForm.appendChild(csrfInput);
    
    // Add form data
    const formData = new FormData(form);
    for (let [key, value] of formData.entries()) {
        if (key !== 'leave_id') {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            realForm.appendChild(input);
        }
    }
    
    document.body.appendChild(realForm);
    
    if (confirm(`Manual ${action.toUpperCase()} test?\n\nLeave ID: ${leaveId}\nURL: ${url}\n\nThis will actually perform the action. Continue?`)) {
        debugLog(`✅ Submitting manual ${action} test...`);
        realForm.submit();
    } else {
        debugLog(`❌ Manual ${action} test cancelled`);
        document.body.removeChild(realForm);
    }
    
    return false;
}

// Log initial state
document.addEventListener('DOMContentLoaded', function() {
    debugLog('🚀 Debug page loaded');
    debugLog(`👤 User: {{ Auth::user()->username }} ({{ Auth::user()->role }})`);
    debugLog(`🔑 Has admin role: {{ Auth::user()->hasRole(['admin', 'hr', 'manager']) ? 'YES' : 'NO' }}`);
    debugLog(`📋 Pending leaves: {{ $pendingLeaves->count() }}`);
});
</script>
@endsection
