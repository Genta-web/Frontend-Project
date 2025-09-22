@extends('layouts.admin')

@section('title', Auth::user()->isEmployee() ? 'My Leave Requests' : 'Leave Management')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('styles')
<style>
    /* 🎨 PROFESSIONAL LEAVE MANAGEMENT SYSTEM */

    /* Main Container */
    .leave-management-page {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Professional Header */
    .professional-header {
        background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
        color: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        margin-bottom: 2rem;
        overflow: hidden;
        position: relative;
    }

    .professional-header::before {
        content: '';
        position: absolute;
        top: 0;
        right: 0;
        width: 200px;
        height: 200px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transform: translate(50%, -50%);
    }

    .header-content {
        padding: 2.5rem;
        position: relative;
        z-index: 2;
    }

    .header-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .header-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    /* Professional Table Card */
    .professional-table-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        border: none;
    }

    .table-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 1.5rem 2rem;
        border-bottom: 2px solid #dee2e6;
    }

    .table-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    /* Professional Table */
    .professional-table {
        margin: 0;
        background: white;
    }

    .professional-table thead th {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        font-weight: 600;
        color: #2c3e50;
        padding: 1.25rem 1rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.875rem;
        border-bottom: 2px solid #dee2e6;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .professional-table tbody td {
        padding: 1.25rem 1rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f4;
        color: #495057;
    }

    .professional-table tbody tr {
        transition: all 0.3s ease;
    }

    .professional-table tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    /* Status Row Styling */
    .status-pending {
        background: linear-gradient(135deg, #fff3cd 0%, #ffeaa7 100%) !important;
        border-left: 4px solid #ffc107;
    }

    .status-waiting {
        background: linear-gradient(135deg, #ffe6e6 0%, #ffcccc 100%) !important;
        border-left: 4px solid #ff6b6b;
        animation: pulse-waiting 2s infinite;
    }

    .status-approved {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%) !important;
        border-left: 4px solid #28a745;
    }

    .status-rejected {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%) !important;
        border-left: 4px solid #dc3545;
    }

    @keyframes pulse-waiting {
        0% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(255, 107, 107, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0); }
    }

    /* Professional Status Badges */
    .status-badge {
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .status-badge.pending {
        background: linear-gradient(135deg, #ffc107, #ffca2c);
        color: #212529;
        animation: pulse-pending 2s infinite;
    }

    .status-badge.waiting {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        animation: blink-waiting 1.5s infinite;
    }

    .status-badge.approved {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .status-badge.rejected {
        background: linear-gradient(135deg, #dc3545, #e74c3c);
        color: white;
    }

    @keyframes pulse-pending {
        0% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(255, 193, 7, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 193, 7, 0); }
    }

    @keyframes blink-waiting {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0.7; }
    }

    /* Professional Action Buttons */
    .action-container {
        min-width: 180px;
        padding: 0.5rem;
    }

    .action-btn {
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        transition: all 0.3s ease;
        border: none;
        text-decoration: none !important;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.5rem;
        width: 100%;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        text-decoration: none !important;
    }

    .action-btn.view {
        background: linear-gradient(135deg, #17a2b8, #138496);
        color: white;
    }

    .action-btn.approve {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .action-btn.reject {
        background: linear-gradient(135deg, #dc3545, #e74c3c);
        color: white;
    }

    .action-btn.edit {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        color: #212529;
    }

    .action-btn.delete {
        background: linear-gradient(135deg, #6c757d, #5a6268);
        color: white;
    }

    /* Special Waiting Actions */
    .waiting-actions {
        background: linear-gradient(135deg, #ffe6e6 0%, #ffcccc 100%);
        border: 2px solid #ff6b6b;
        border-radius: 12px;
        padding: 1rem;
        margin: 0.5rem 0;
        position: relative;
        animation: pulse-waiting-container 2s infinite;
    }

    .waiting-actions::before {
        content: "⚠️ ACTION REQUIRED";
        position: absolute;
        top: -12px;
        left: 15px;
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 600;
        animation: pulse-label 2s infinite;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    @keyframes pulse-waiting-container {
        0% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(255, 107, 107, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0); }
    }

    @keyframes pulse-label {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .waiting-badge {
        background: linear-gradient(135deg, #ff6b6b, #ee5a24);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        animation: blink 1.5s infinite;
        margin-bottom: 0.75rem;
        display: inline-block;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0.6; }
    }

    /* Employee Info Styling */
    .employee-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .employee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .employee-details h6 {
        margin-bottom: 0.25rem;
        font-weight: 600;
        color: #2c3e50;
    }

    .employee-details small {
        color: #6c757d;
    }

    /* Leave Type Styling */
    .leave-type {
        padding: 0.375rem 0.75rem;
        background: linear-gradient(135deg, #e3f2fd, #bbdefb);
        color: #1565c0;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.875rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Date Range Styling */
    .date-range {
        background: linear-gradient(135deg, #f3e5f5, #e1bee7);
        color: #7b1fa2;
        padding: 0.5rem 1rem;
        border-radius: 8px;
        font-weight: 500;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .header-title {
            font-size: 1.5rem;
        }

        .action-container {
            min-width: 140px;
        }

        .action-btn {
            font-size: 0.75rem;
            padding: 0.5rem 1rem;
        }

        .professional-table thead th,
        .professional-table tbody td {
            padding: 0.75rem 0.5rem;
            font-size: 0.875rem;
        }
    }
</style>
@endpush

@section('content')
<div class="leave-management-page">
    <div class="container-fluid">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-lg" role="alert" style="background: rgba(40, 167, 69, 0.1); border: 2px solid #28a745; backdrop-filter: blur(10px); border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-check-circle text-success me-3" style="font-size: 1.5rem;"></i>
                    <div>
                        <h6 class="alert-heading mb-1 text-success fw-bold">✅ Success!</h6>
                        <p class="mb-0 text-dark">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-lg" role="alert" style="background: rgba(220, 53, 69, 0.1); border: 2px solid #dc3545; backdrop-filter: blur(10px); border-radius: 12px;">
                <div class="d-flex align-items-center">
                    <i class="fas fa-exclamation-circle text-danger me-3" style="font-size: 1.5rem;"></i>
                    <div>
                        <h6 class="alert-heading mb-1 text-danger fw-bold">❌ Error!</h6>
                        <p class="mb-0 text-dark">{{ session('error') }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Professional Header -->
        <div class="professional-header">
            <div class="header-content">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="header-title">
                            <i class="fas fa-calendar-check me-3"></i>
                            @if(Auth::user()->isEmployee())
                                My Leave Requests
                            @else
                                Leave Management System
                            @endif
                        </h1>
                        <p class="header-subtitle">
                            @if(Auth::user()->isEmployee())
                                📋 View and manage your personal leave requests
                            @else
                                🎯 Manage employee leave requests and approvals
                                @php
                                    $pendingCount = $leaves->where('status', 'pending')->count();
                                    $waitingCount = $leaves->where('status', 'waiting')->count();
                                @endphp
                                @if(Auth::user()->hasRole(['admin', 'hr', 'manager']))
                                    @if($pendingCount > 0)
                                        • <strong class="text-warning">{{ $pendingCount }}</strong> pending request(s) require review
                                    @endif
                                    @if($waitingCount > 0)
                                        • <strong class="text-danger">{{ $waitingCount }}</strong> waiting request(s) need immediate response
                                    @endif
                                @endif
                            @endif
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('leave.create') }}" class="btn btn-light btn-lg shadow-lg" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(10px); border-radius: 12px; font-weight: 600;">
                            <i class="fas fa-plus me-2"></i>
                            <strong>New Request</strong>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Table Card -->
        <div class="professional-table-card">
            <div class="table-header">
                <h3 class="table-title">
                    <i class="fas fa-list-alt me-2"></i>
                    @if(Auth::user()->isEmployee())
                        My Leave Requests ({{ $leaves->total() }})
                    @else
                        All Leave Requests ({{ $leaves->total() }})
                    @endif
                </h3>
            </div>

            <div class="table-responsive">
                <table class="professional-table table">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Employee</th>
                            <th width="15%">Leave Type</th>
                            <th width="20%">Date Range</th>
                            <th width="10%">Days</th>
                            <th width="15%">Status</th>
                            <th width="15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $index => $leave)
                            <tr class="
                                @if($leave->status === 'pending') status-pending
                                @elseif($leave->status === 'waiting') status-waiting
                                @elseif($leave->status === 'approved') status-approved
                                @elseif($leave->status === 'rejected') status-rejected
                                @endif
                            ">
                                <!-- Row Number -->
                                <td class="text-center">
                                    <span class="fw-bold text-muted">{{ $leaves->firstItem() + $index }}</span>
                                </td>

                                <!-- Employee Info -->
                                <td>
                                    <div class="employee-info">
                                        <div class="employee-avatar">
                                            {{ strtoupper(substr($leave->employee->name ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="employee-details">
                                            <h6 class="mb-0">{{ $leave->employee->name ?? 'Unknown' }}</h6>
                                            <small class="text-muted">{{ $leave->employee->email ?? 'No email' }}</small>
                                        </div>
                                    </div>
                                </td>

                                <!-- Leave Type -->
                                <td>
                                    <span class="leave-type">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ $leave->leave_type_display }}
                                    </span>
                                </td>

                                <!-- Date Range -->
                                <td>
                                    <div class="date-range">
                                        <i class="fas fa-calendar me-1"></i>
                                        <strong>{{ $leave->start_date->format('d M Y') }}</strong>
                                        <br>
                                        <small>to {{ $leave->end_date->format('d M Y') }}</small>
                                    </div>
                                </td>

                                <!-- Total Days -->
                                <td class="text-center">
                                    <span class="badge bg-primary fs-6">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ $leave->total_days }} day(s)
                                    </span>
                                </td>

                                <!-- Status -->
                                <td class="text-center">
                                    @if($leave->status === 'pending')
                                        <span class="status-badge pending">
                                            <i class="fas fa-clock"></i>Pending
                                        </span>
                                        <br><small class="text-muted mt-1">Waiting for approval</small>
                                    @elseif($leave->status === 'waiting')
                                        <span class="status-badge waiting">
                                            <i class="fas fa-exclamation-triangle"></i>Waiting
                                        </span>
                                        <br><small class="text-warning mt-1 fw-bold">
                                            ⚠️ Admin Response Required
                                        </small>
                                    @elseif($leave->status === 'approved')
                                        <span class="status-badge approved">
                                            <i class="fas fa-check"></i>Approved
                                        </span>
                                        <br><small class="text-success mt-1">
                                            <strong>by {{ $leave->approvedBy->username ?? 'Admin' }}</strong>
                                            <br>{{ $leave->approved_at ? $leave->approved_at->format('d M Y H:i') : '' }}
                                        </small>
                                    @elseif($leave->status === 'rejected')
                                        <span class="status-badge rejected">
                                            <i class="fas fa-times"></i>Rejected
                                        </span>
                                        <br><small class="text-danger mt-1">
                                            <strong>by {{ $leave->approvedBy->username ?? 'Admin' }}</strong>
                                            <br>{{ $leave->approved_at ? $leave->approved_at->format('d M Y H:i') : '' }}
                                        </small>
                                    @else
                                        <span class="status-badge" style="background: #6c757d; color: white;">
                                            <i class="fas fa-question"></i>{{ ucfirst($leave->status) }}
                                        </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td>
                                    <div class="action-container">
                                        <!-- View Detail - Always Available -->
                                        <a href="{{ route('leave.show', $leave) }}" class="action-btn view" title="View Details">
                                            <i class="fas fa-eye"></i>View Detail
                                        </a>

                                        @if(($leave->status === 'pending' || $leave->status === 'waiting') && Auth::user()->hasRole(['admin', 'hr', 'manager']))
                                            @if($leave->status === 'waiting')
                                                <!-- Special Waiting Actions -->
                                                <div class="waiting-actions">
                                                    <div class="waiting-badge">⚠️ WAITING</div>

                                                    <!-- Enhanced Approve Button -->
                                                    <form action="{{ route('leave.approve', $leave) }}" method="POST" class="mb-1" onsubmit="return confirmApprove('{{ $leave->employee->name ?? 'Employee' }}', '{{ $leave->leave_type_display }}')">
                                                        @csrf
                                                        <input type="hidden" name="admin_message" value="Your leave request has been approved by {{ Auth::user()->username }}.">
                                                        <button type="submit" class="action-btn approve" title="Approve Request">
                                                            <i class="fas fa-check"></i>APPROVE NOW
                                                        </button>
                                                    </form>

                                                    <!-- Enhanced Reject Button -->
                                                    <button type="button" class="action-btn reject"
                                                            onclick="simpleReject('{{ $leave->id }}', '{{ $leave->employee->name ?? 'Employee' }}', '{{ $leave->leave_type_display }}')"
                                                            title="Reject Request">
                                                        <i class="fas fa-times"></i>REJECT NOW
                                                    </button>
                                                </div>
                                            @else
                                                <!-- Standard Admin Actions -->
                                                <form action="{{ route('leave.approve', $leave) }}" method="POST" class="mb-1" onsubmit="return confirmApprove('{{ $leave->employee->name ?? 'Employee' }}', '{{ $leave->leave_type_display }}')">
                                                    @csrf
                                                    <input type="hidden" name="admin_message" value="Your leave request has been approved by {{ Auth::user()->username }}.">
                                                    <button type="submit" class="action-btn approve" title="Approve Request">
                                                        <i class="fas fa-check"></i>Approve
                                                    </button>
                                                </form>

                                                <button type="button" class="action-btn reject"
                                                        onclick="simpleReject('{{ $leave->id }}', '{{ $leave->employee->name ?? 'Employee' }}', '{{ $leave->leave_type_display }}')"
                                                        title="Reject Request">
                                                    <i class="fas fa-times"></i>Reject
                                                </button>
                                            @endif

                                        @elseif($leave->status === 'pending' && $leave->employee_id == Auth::user()->employee?->id)
                                            <!-- Employee Actions for Own Pending Requests -->
                                            <a href="{{ route('leave.edit', $leave) }}" class="action-btn edit" title="Edit Request">
                                                <i class="fas fa-edit"></i>Edit
                                            </a>
                                            <form action="{{ route('leave.destroy', $leave) }}" method="POST" class="mb-1" onsubmit="return confirm('Delete this leave request? This action cannot be undone.')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="action-btn delete" title="Delete Request">
                                                    <i class="fas fa-trash"></i>Delete
                                                </button>
                                            </form>

                                        @else
                                            <!-- Read-Only Status Display -->
                                            <div class="text-center">
                                                <small class="text-muted">No actions available</small>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <h5>No Leave Requests Found</h5>
                                        <p>There are no leave requests to display.</p>
                                        <a href="{{ route('leave.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Create New Request
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($leaves->hasPages())
                <div class="d-flex justify-content-center py-3">
                    {{ $leaves->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // 🎯 PROFESSIONAL JAVASCRIPT FUNCTIONS

    // Confirm Approve Function
    function confirmApprove(employeeName, leaveType) {
        return confirm(`🎯 APPROVE LEAVE REQUEST\n\n` +
                      `Employee: ${employeeName}\n` +
                      `Type: ${leaveType}\n\n` +
                      `This will approve the request immediately.\n\n` +
                      `Continue?`);
    }

    // Simple Reject Function with Professional Prompt
    function simpleReject(leaveId, employeeName, leaveType) {
        const reason = prompt(`🚫 REJECT LEAVE REQUEST\n\n` +
                             `Employee: ${employeeName}\n` +
                             `Type: ${leaveType}\n\n` +
                             `Please enter rejection reason:`);

        if (reason && reason.trim()) {
            // Show loading state
            const button = event.target;
            const originalText = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            button.disabled = true;

            // Create and submit form
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/leave/${leaveId}/reject`;
            form.style.display = 'none';

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            // Add admin notes
            const notesInput = document.createElement('input');
            notesInput.type = 'hidden';
            notesInput.name = 'admin_notes';
            notesInput.value = reason;
            form.appendChild(notesInput);

            // Submit form
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Professional Toast Notifications
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        toast.style.cssText = `
            top: 20px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
        `;

        toast.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'} me-2"></i>
                <div>${message}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(toast);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (toast.parentNode) {
                toast.remove();
            }
        }, 5000);
    }

    // Initialize tooltips
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Add smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    });
</script>
@endpush
