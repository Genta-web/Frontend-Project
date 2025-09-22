{{--
    Leave Action Buttons Component
    
    Props:
    - $leave: Leave model instance
    - $context: 'index' or 'show' (determines button layout)
    - $showLabels: boolean (show/hide button labels)
--}}

@php
    $context = $context ?? 'index';
    $showLabels = $showLabels ?? true;
    $user = Auth::user();
    $canManage = $user->hasRole(['admin', 'hr', 'manager']);
    $isEmployee = $user->isEmployee();
    $isOwner = $isEmployee && $leave->employee_id == $user->employee?->id;
@endphp

<div class="leave-actions-container" data-context="{{ $context }}">
    @if($leave->isPending() && $canManage)
        {{-- Admin Actions for Pending Requests --}}
        <div class="admin-actions {{ $context === 'show' ? 'd-grid gap-2' : 'table-actions' }}">
            @if($context === 'index')
                <div class="btn-group-spaced">
                    <form action="{{ route('leave.approve', $leave) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" 
                                class="btn btn-success btn-sm action-btn-approve"
                                title="Approve this leave request"
                                data-action="approve-leave"
                                data-leave-id="{{ $leave->id }}"
                                data-leave-data="{{ json_encode([
                                    'employeeName' => $leave->employee->name ?? 'N/A',
                                    'leaveType' => $leave->leave_type_display,
                                    'duration' => $leave->start_date->format('d M Y') . ' - ' . $leave->end_date->format('d M Y'),
                                    'totalDays' => $leave->total_days
                                ]) }}"
                                onclick="return confirm('✅ APPROVE LEAVE REQUEST\n\nEmployee: {{ $leave->employee->name ?? 'N/A' }}\nType: {{ $leave->leave_type_display }}\nDuration: {{ $leave->start_date->format('d M Y') }} - {{ $leave->end_date->format('d M Y') }}\nDays: {{ $leave->total_days }}\n\nAre you sure you want to approve this request?')">
                            <i class="fas fa-check me-1"></i>
                            @if($showLabels)<strong>APPROVE</strong>@endif
                        </button>
                    </form>
                    
                    <button type="button" 
                            class="btn btn-danger btn-sm action-btn-reject"
                            data-action="reject-leave"
                            data-leave-id="{{ $leave->id }}"
                            data-leave-data="{{ json_encode([
                                'employeeName' => $leave->employee->name ?? 'Employee',
                                'leaveType' => $leave->leave_type_display
                            ]) }}"
                            onclick="showRejectModal({{ $leave->id }}, '{{ $leave->employee->name ?? 'Employee' }}', '{{ $leave->leave_type_display }}')"
                            title="Reject this leave request">
                        <i class="fas fa-times me-1"></i>
                        @if($showLabels)<strong>REJECT</strong>@endif
                    </button>
                </div>
                
                <a href="{{ route('leave.show', $leave) }}" class="btn btn-outline-info btn-sm w-100 mt-1">
                    <i class="fas fa-eye me-1"></i>View Details
                </a>
            @else
                {{-- Show page actions --}}
                <button type="button" 
                        class="btn btn-success shadow-sm action-btn-approve"
                        data-action="approve-leave"
                        data-leave-id="{{ $leave->id }}"
                        data-leave-data="{{ json_encode([
                            'employeeName' => $leave->employee->name ?? 'N/A',
                            'leaveType' => $leave->leave_type_display,
                            'duration' => $leave->start_date->format('d M Y') . ' - ' . $leave->end_date->format('d M Y'),
                            'totalDays' => $leave->total_days
                        ]) }}"
                        onclick="approveLeave()">
                    <i class="fas fa-check me-2"></i>Approve Request
                </button>
                
                <button type="button" 
                        class="btn btn-danger shadow-sm action-btn-reject"
                        data-action="reject-leave"
                        data-leave-id="{{ $leave->id }}"
                        data-leave-data="{{ json_encode([
                            'employeeName' => $leave->employee->name ?? 'Employee',
                            'leaveType' => $leave->leave_type_display
                        ]) }}"
                        onclick="showRejectModal()">
                    <i class="fas fa-times me-2"></i>Reject Request
                </button>
            @endif
        </div>
        
    @elseif(!$leave->isPending() && $canManage)
        {{-- Admin Actions for Processed Requests --}}
        <div class="processed-actions {{ $context === 'show' ? '' : 'table-actions' }}">
            <span class="badge {{ $leave->status_badge_class }} fs-6 {{ $context === 'index' ? 'mb-2' : '' }}">
                {{ ucfirst($leave->status) }}
            </span>
            
            @if($context === 'index')
                <a href="{{ route('leave.show', $leave) }}" class="btn btn-outline-info btn-sm w-100">
                    <i class="fas fa-eye me-1"></i>View Details
                </a>
                
                @if($leave->status === 'rejected')
                    <small class="text-muted mt-1">by {{ $leave->approvedBy->username ?? 'Admin' }}</small>
                @endif
            @endif
        </div>
        
    @elseif($isEmployee)
        {{-- Employee Actions --}}
        <div class="employee-actions {{ $context === 'show' ? 'd-flex gap-2' : 'd-flex flex-column gap-1' }}">
            @if($leave->isPending())
                @if($context === 'index')
                    <span class="badge bg-warning fs-6">
                        <i class="fas fa-clock me-1"></i>Pending Review
                    </span>
                @endif
                
                @if($isOwner)
                    <div class="btn-group-spaced {{ $context === 'show' ? '' : 'mt-1' }}">
                        <a href="{{ route('leave.edit', $leave) }}" 
                           class="btn {{ $context === 'show' ? 'btn-warning' : 'btn-outline-warning btn-sm' }}">
                            <i class="fas fa-edit me-1"></i>
                            @if($showLabels || $context === 'show')Edit@endif
                        </a>
                        
                        <button type="button" 
                                class="btn {{ $context === 'show' ? 'btn-danger' : 'btn-outline-danger btn-sm' }} action-btn-delete"
                                data-action="delete-leave"
                                data-leave-id="{{ $leave->id }}"
                                data-leave-data="{{ json_encode([
                                    'leaveType' => $leave->leave_type_display
                                ]) }}"
                                onclick="confirmDelete('{{ $leave->leave_type_display }}', '{{ route('leave.destroy', $leave) }}')"
                                title="Delete">
                            <i class="fas fa-trash me-1"></i>
                            @if($showLabels || $context === 'show')Delete@endif
                        </button>
                    </div>
                @endif
            @else
                {{-- Processed leave status --}}
                <span class="badge {{ $leave->status_badge_class }} fs-6">
                    @if($leave->status === 'approved')
                        <i class="fas fa-check me-1"></i>Approved
                    @elseif($leave->status === 'rejected')
                        <i class="fas fa-times me-1"></i>Rejected
                    @endif
                </span>
                
                @if($context === 'index')
                    <a href="{{ route('leave.show', $leave) }}" class="btn btn-outline-info btn-sm mt-1">
                        <i class="fas fa-eye me-1"></i>View Details
                    </a>
                @endif
            @endif
        </div>
    @endif
</div>

@push('styles')
<style>
.leave-actions-container {
    min-width: 140px;
}

.leave-actions-container[data-context="show"] {
    min-width: auto;
}

.table-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.table-actions .btn-group-spaced {
    display: flex;
    gap: 0.25rem;
    justify-content: flex-start;
}

.table-actions .btn {
    flex: 1;
    min-width: auto;
    padding: 0.375rem 0.5rem;
    font-size: 0.75rem;
}

.action-btn-approve:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
}

.action-btn-reject:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
}

.action-btn-delete:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 8px rgba(220, 53, 69, 0.2);
}

.btn-group-spaced {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
    align-items: center;
}

.btn-group-spaced .btn {
    margin-right: 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .table-actions .btn-group-spaced {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .table-actions .btn {
        width: 100%;
    }
    
    .leave-actions-container[data-context="show"] .btn-group-spaced {
        flex-direction: column;
        width: 100%;
    }
    
    .leave-actions-container[data-context="show"] .btn {
        width: 100%;
    }
}
</style>
@endpush
