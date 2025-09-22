@extends('layouts.admin')

@section('title', Auth::user()->isEmployee() ? 'My Leave Requests' : 'Leave Management')

@push('head')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@push('styles')
<style>
    /* 🎨 PROFESSIONAL LEAVE MANAGEMENT STYLES */

    /* Main Container */
    .leave-management-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: 100vh;
        padding: 2rem 0;
    }

    /* Header Card */
    .header-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .header-card .card-body {
        padding: 2rem;
    }

    .header-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .header-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .btn-clean {
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        font-weight: 500;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
        transition: all 0.2s ease;
        border: none;
    }

    .btn-clean:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .btn-clean.primary {
        background-color: #007bff;
        color: white;
    }

    .btn-clean.warning {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-clean.success {
        background-color: #28a745;
        color: white;
    }

    /* Statistics Cards */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    .stat-card-simple {
        background: white;
        border-radius: 8px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
        border-left: 4px solid;
    }

    .stat-card-simple:hover {
        transform: translateY(-2px);
    }

    .stat-card-simple.primary { border-left-color: #007bff; }
    .stat-card-simple.warning { border-left-color: #ffc107; }
    .stat-card-simple.success { border-left-color: #28a745; }
    .stat-card-simple.danger { border-left-color: #dc3545; }
    .stat-card-simple.info { border-left-color: #17a2b8; }

    .stat-content-simple {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon-simple {
        width: 60px;
        height: 60px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }

    .stat-icon-simple.primary { background-color: #007bff; }
    .stat-icon-simple.warning { background-color: #ffc107; }
    .stat-icon-simple.success { background-color: #28a745; }
    .stat-icon-simple.danger { background-color: #dc3545; }
    .stat-icon-simple.info { background-color: #17a2b8; }

    .stat-info-simple h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        color: #2c3e50;
    }

    .stat-info-simple p {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0.25rem 0 0 0;
        font-weight: 500;
    }

    .stat-badge-simple {
        background-color: #ffc107;
        color: #212529;
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
        font-size: 0.7rem;
        font-weight: 600;
        margin-left: 0.5rem;
    }

    /* Clean Cards */
    .card-clean {
        background: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 1.5rem;
        border: 1px solid #e9ecef;
    }

    .card-header-clean {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        padding: 1rem 1.5rem;
    }

    .card-body-clean {
        padding: 1.5rem;
    }

    /* Table Improvements */
    .table-container {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .table-header {
        background-color: #f8f9fa;
        border-bottom: 2px solid #e9ecef;
        padding: 1rem 1.5rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .table-title {
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    .table-responsive {
        border-radius: 0 0 8px 8px;
    }

    .table th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        color: #495057;
        padding: 1rem 0.75rem;
    }

    .table td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Action Buttons */
    .action-btn-group {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .action-btn-small {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        border-radius: 4px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-right: 0.25rem;
    }

    .action-btn-small:hover {
        transform: translateY(-1px);
    }

    /* Button Group Spacing */
    .btn-group-spaced {
        display: flex;
        gap: 0.5rem;
        flex-wrap: wrap;
        align-items: center;
    }

    .btn-group-spaced .btn {
        margin-right: 0.5rem;
        margin-bottom: 0.25rem;
    }

    .btn-group-spaced .btn:last-child {
        margin-right: 0;
    }

    /* Table Action Buttons */
    .table-actions {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        min-width: 140px;
    }

    .table-actions .btn-group {
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

    /* Status Badges */
    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        text-align: center;
        display: inline-block;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-approved {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* 🎯 Enhanced Admin Actions Styling */
    .admin-actions-container {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 12px;
        min-width: 160px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .admin-actions-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #007bff, #28a745, #ffc107, #dc3545);
        animation: shimmer 3s infinite;
    }

    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(100%); }
    }

    .admin-actions-container:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        border-color: #007bff;
    }

    .admin-actions-container .btn {
        transition: all 0.2s ease;
        font-weight: 600;
        letter-spacing: 0.5px;
        position: relative;
        overflow: hidden;
    }

    .admin-actions-container .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
        transition: left 0.5s;
    }

    .admin-actions-container .btn:hover::before {
        left: 100%;
    }

    .admin-actions-container .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .admin-actions-container .btn-success {
        background: linear-gradient(45deg, #28a745, #20c997) !important;
        border: none !important;
        color: white !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }

    .admin-actions-container .btn-success:hover {
        background: linear-gradient(45deg, #218838, #1ea085) !important;
        transform: translateY(-2px);
    }

    .admin-actions-container .btn-danger {
        background: linear-gradient(45deg, #dc3545, #e74c3c) !important;
        border: none !important;
        color: white !important;
        text-shadow: 0 1px 2px rgba(0,0,0,0.2);
    }

    .admin-actions-container .btn-danger:hover {
        background: linear-gradient(45deg, #c82333, #dc2626) !important;
        transform: translateY(-2px);
    }

    .admin-actions-container .badge {
        animation: pulse 2s infinite;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    /* 🎯 Clean CRUD Action Buttons */
    .action-buttons-container {
        min-width: 120px;
        max-width: 150px;
    }

    .action-btn {
        font-size: 0.875rem;
        font-weight: 500;
        border-radius: 6px;
        transition: all 0.2s ease;
        text-decoration: none !important;
        border: 1px solid transparent;
    }

    .action-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .action-btn.btn-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        border-color: #28a745;
        color: white;
    }

    .action-btn.btn-success:hover {
        background: linear-gradient(135deg, #218838, #1ea085);
        border-color: #1e7e34;
        color: white;
    }

    .action-btn.btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border-color: #dc3545;
        color: white;
    }

    .action-btn.btn-danger:hover {
        background: linear-gradient(135deg, #c82333, #a71e2a);
        border-color: #bd2130;
        color: white;
    }

    .action-btn.btn-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800);
        border-color: #ffc107;
        color: #212529;
    }

    .action-btn.btn-warning:hover {
        background: linear-gradient(135deg, #e0a800, #d39e00);
        border-color: #d39e00;
        color: #212529;
    }

    .action-btn.btn-info {
        background: linear-gradient(135deg, #17a2b8, #138496);
        border-color: #17a2b8;
        color: white;
    }

    .action-btn.btn-info:hover {
        background: linear-gradient(135deg, #138496, #117a8b);
        border-color: #117a8b;
        color: white;
    }

    .action-btn.btn-outline-info {
        border-color: #17a2b8;
        color: #17a2b8;
        background: transparent;
    }

    .action-btn.btn-outline-info:hover {
        background: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }

    /* Status Badges */
    .badge {
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.5px;
    }

    .badge.bg-success {
        background: linear-gradient(135deg, #28a745, #20c997) !important;
    }

    .badge.bg-danger {
        background: linear-gradient(135deg, #dc3545, #c82333) !important;
    }

    .badge.bg-warning {
        background: linear-gradient(135deg, #ffc107, #e0a800) !important;
        color: #212529 !important;
    }

    /* Button Group Styling */
    .btn-group-vertical .action-btn {
        border-radius: 6px !important;
        margin-bottom: 2px;
    }

    .btn-group-vertical .action-btn:last-child {
        margin-bottom: 0;
    }

    /* 🎯 PROFESSIONAL ACTION BUTTONS */
    .action-container {
        min-width: 180px;
        padding: 0.5rem;
    }

    .action-btn {
        padding: 0.5rem 1rem;
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
    }

    .action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
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

    /* 🚨 WAITING STATUS SPECIAL STYLING */
    .waiting-actions {
        background: linear-gradient(135deg, #ffe6e6 0%, #ffcccc 100%);
        border: 2px solid #ff6b6b;
        border-radius: 12px;
        padding: 1rem;
        margin: 0.5rem 0;
        position: relative;
        animation: pulse-waiting 2s infinite;
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
    }

    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0.5; }
    }

    @keyframes pulse-waiting {
        0% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0.7); }
        70% { box-shadow: 0 0 0 10px rgba(255, 107, 107, 0); }
        100% { box-shadow: 0 0 0 0 rgba(255, 107, 107, 0); }
    }

    .waiting-actions::before {
        content: "⚠️ ACTION REQUIRED";
        position: absolute;
        top: -10px;
        left: 15px;
        background: #ff6b6b;
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.7rem;
        font-weight: 600;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }
</style>
@endpush

@section('content')
<div class="leave-page-container">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Please fix the following errors:</strong>
            <ul class="mb-0 mt-2">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('employee_notification'))
        @php
            $notification = session('employee_notification');
        @endphp
        @if(Auth::user()->isEmployee() && Auth::user()->employee && Auth::user()->employee->id == $notification['employee_id'])
            <div class="alert alert-{{ $notification['type'] }} alert-dismissible fade show border-0 shadow" role="alert">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        @if($notification['type'] === 'success')
                            <i class="fas fa-check-circle fa-3x text-success"></i>
                        @else
                            <i class="fas fa-exclamation-circle fa-3x text-danger"></i>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading mb-2">
                            @if($notification['type'] === 'success')
                                🎉 {{ $notification['title'] }}
                            @else
                                ❌ {{ $notification['title'] }}
                            @endif
                        </h5>
                        <p class="mb-2">{{ $notification['message'] }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>Just now
                            </small>
                            <a href="{{ route('leave.show', $notification['leave_id']) }}" class="btn btn-sm btn-outline-{{ $notification['type'] === 'success' ? 'success' : 'danger' }}">
                                <i class="fas fa-eye me-1"></i>View Details
                            </a>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    @endif

    <!-- Clean Page Header -->
    <div class="page-header-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>
                    @if(Auth::user()->isEmployee())
                        My Leave Requests
                    @else
                        Leave Management
                    @endif
                </h1>
                <p class="page-subtitle">
                    @if(Auth::user()->isEmployee())
                        View and manage your leave requests
                    @else
                        Manage employee leave requests and approvals
                    @endif
                    <span class="badge bg-secondary ms-2">{{ $leaves->total() }} Total</span>
                </p>
            </div>
            <div class="d-flex gap-2">
                @if(Auth::user()->isEmployee())
                    <a href="{{ route('leave.create') }}" class="btn-clean primary">
                        <i class="fas fa-plus"></i>
                        Request Leave
                    </a>
                @else
                    <a href="{{ route('leave.create') }}" class="btn-clean primary">
                        <i class="fas fa-plus"></i>
                        New Request
                    </a>
                    <a href="{{ route('leave.index', ['status' => 'pending']) }}" class="btn-clean warning">
                        <i class="fas fa-clock"></i>
                        Pending
                        @if($stats['pending_leaves'] > 0)
                            <span class="badge bg-dark ms-1">{{ $stats['pending_leaves'] }}</span>
                        @endif
                    </a>
                    @if($stats['pending_leaves'] > 0)
                        <button type="button" class="btn-clean success" onclick="showBulkActions()">
                            <i class="fas fa-tasks"></i>
                            Bulk Actions
                        </button>
                    @endif
                @endif
            </div>
        </div>
    </div>

    <!-- Clean Filter Section -->
    <div class="card-clean">
        <div class="card-header-clean">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filter Leave Requests
            </h6>
        </div>
        <div class="card-body-clean">
            <form method="GET" action="{{ route('leave.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">All Status</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>

                <div class="col-md-3">
                    <label for="leave_type" class="form-label">Leave Type</label>
                    <select class="form-select" id="leave_type" name="leave_type">
                        <option value="">All Types</option>
                        <option value="annual" {{ request('leave_type') == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                        <option value="sick" {{ request('leave_type') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                        <option value="emergency" {{ request('leave_type') == 'emergency' ? 'selected' : '' }}>Emergency Leave</option>
                        <option value="maternity" {{ request('leave_type') == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                        <option value="paternity" {{ request('leave_type') == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
                        <option value="unpaid" {{ request('leave_type') == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
                    </select>
                </div>

                @if(!Auth::user()->isEmployee())
                <div class="col-md-3">
                    <label for="employee_id" class="form-label">Employee</label>
                    <select class="form-select" id="employee_id" name="employee_id">
                        <option value="">All Employees</option>
                        @foreach($employees as $employee)
                            <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                {{ $employee->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="col-md-2">
                    <label for="date_from" class="form-label">From Date</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>

                <div class="col-md-2">
                    <label for="date_to" class="form-label">To Date</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-search me-1"></i>Filter
                    </button>
                    <a href="{{ route('leave.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times me-1"></i>Clear
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- 🎯 Admin Bulk Actions Panel -->
    @if(Auth::user()->hasRole(['admin', 'hr', 'manager']) && $stats['pending_leaves'] > 0)
    <div class="card-clean mb-4">
        <div class="card-header-clean bg-warning bg-opacity-10">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-warning">
                    <i class="fas fa-bolt me-2"></i>⚡ Bulk Actions - {{ $stats['pending_leaves'] }} Pending Requests
                </h6>
                <div class="d-flex gap-2">
                    <button type="button" class="btn btn-success btn-sm" onclick="showBulkApprovalModal()">
                        <i class="fas fa-check-double me-1"></i>Bulk Approve
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="showBulkRejectionModal()">
                        <i class="fas fa-times-circle me-1"></i>Bulk Reject
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body-clean py-2">
            <div class="d-flex align-items-center justify-content-between">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="selectAllLeaves" onchange="toggleSelectAll()">
                    <label class="form-check-label" for="selectAllLeaves">
                        <strong>Select All Pending Requests</strong>
                    </label>
                </div>
                <div class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Select requests below and use bulk actions to process multiple requests at once.
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Clean Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card-simple primary">
            <div class="stat-content-simple">
                <div class="stat-icon-simple primary">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info-simple">
                    <h3>{{ $stats['total_leaves'] }}</h3>
                    <p>Total Leaves</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple warning">
            <div class="stat-content-simple">
                <div class="stat-icon-simple warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info-simple">
                    <h3>{{ $stats['pending_leaves'] }}</h3>
                    <p>Pending Approval
                        @if($stats['pending_leaves'] > 0)
                            <span class="stat-badge-simple">Action Required</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple success">
            <div class="stat-content-simple">
                <div class="stat-icon-simple success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info-simple">
                    <h3>{{ $stats['approved_leaves'] }}</h3>
                    <p>Approved</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple danger">
            <div class="stat-content-simple">
                <div class="stat-icon-simple danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info-simple">
                    <h3>{{ $stats['rejected_leaves'] }}</h3>
                    <p>Rejected</p>
                </div>
            </div>
        </div>
    </div>

    @if(!Auth::user()->isEmployee())
    <!-- Additional Statistics for Admin -->
    <div class="stats-container">
        <div class="stat-card-simple info">
            <div class="stat-content-simple">
                <div class="stat-icon-simple info">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-info-simple">
                    <h3>{{ $stats['today_requests'] ?? 0 }}</h3>
                    <p>Today's Requests</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple info">
            <div class="stat-content-simple">
                <div class="stat-icon-simple info">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="stat-info-simple">
                    <h3>{{ $stats['this_week_requests'] ?? 0 }}</h3>
                    <p>This Week</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple primary">
            <div class="stat-content-simple">
                <div class="stat-icon-simple primary">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info-simple">
                    <h3>{{ $stats['this_month_requests'] ?? 0 }}</h3>
                    <p>This Month</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple danger">
            <div class="stat-content-simple">
                <div class="stat-icon-simple danger">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stat-info-simple">
                    <h3>{{ $stats['urgent_pending'] ?? 0 }}</h3>
                    <p>Urgent (≤3 days)
                        @if(($stats['urgent_pending'] ?? 0) > 0)
                            <span class="stat-badge-simple">Urgent!</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if(!Auth::user()->isEmployee() && $stats['pending_leaves'] > 0)
    <!-- Admin Action Required Alert -->
    <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-triangle fa-2x me-3"></i>
            <div>
                <h6 class="alert-heading mb-1">
                    <strong>{{ $stats['pending_leaves'] }}</strong> Leave Request(s) Require Your Action
                </h6>
                <p class="mb-0">
                    Review and approve/reject pending leave requests from employees.
                    @if(isset($stats['urgent_pending']) && $stats['urgent_pending'] > 0)
                        <span class="badge badge-danger ms-2">{{ $stats['urgent_pending'] }} Urgent</span>
                    @endif
                </p>
            </div>
            <div class="ms-auto">
                <a href="#leave-table" class="btn btn-warning btn-sm">
                    <i class="fas fa-arrow-down me-1"></i>Review Below
                </a>
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <!-- Filters -->
    @if(!Auth::user()->hasRole('employee'))
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filters
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('leave.index') }}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select class="form-control" id="employee_id" name="employee_id">
                            <option value="">All Employees</option>
                            @foreach($employees as $employee)
                                <option value="{{ $employee->id }}"
                                        {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="leave_type" class="form-label">Leave Type</label>
                        <select class="form-control" id="leave_type" name="leave_type">
                            <option value="">All Types</option>
                            <option value="annual" {{ request('leave_type') == 'annual' ? 'selected' : '' }}>Annual</option>
                            <option value="sick" {{ request('leave_type') == 'sick' ? 'selected' : '' }}>Sick</option>
                            <option value="emergency" {{ request('leave_type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                            <option value="maternity" {{ request('leave_type') == 'maternity' ? 'selected' : '' }}>Maternity</option>
                            <option value="paternity" {{ request('leave_type') == 'paternity' ? 'selected' : '' }}>Paternity</option>
                            <option value="unpaid" {{ request('leave_type') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="date_from" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="date_from" name="date_from"
                               value="{{ request('date_from') }}">
                    </div>
                    <div class="col-md-2">
                        <label for="date_to" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="date_to" name="date_to"
                               value="{{ request('date_to') }}">
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <a href="{{ route('leave.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    @endif



    @if(Auth::user()->isEmployee())
    <!-- Employee Status Summary -->
    @php
        $recentLeaves = $leaves->take(3);
        $hasRecentUpdates = $recentLeaves->where('updated_at', '>', now()->subDays(7))->where('status', '!=', 'pending')->count() > 0;
    @endphp

    @if($hasRecentUpdates)
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-info">
            <h6 class="m-0 font-weight-bold text-white">
                <i class="fas fa-bell me-2"></i>Recent Status Updates
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach($recentLeaves->where('updated_at', '>', now()->subDays(7))->where('status', '!=', 'pending') as $leave)
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="card border-{{ $leave->status === 'approved' ? 'success' : 'danger' }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h6 class="card-title mb-0">{{ $leave->leave_type_display }}</h6>
                                <span class="badge bg-{{ $leave->status === 'approved' ? 'success' : 'danger' }}">
                                    {{ ucfirst($leave->status) }}
                                </span>
                            </div>
                            <p class="card-text small">
                                <strong>Duration:</strong> {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }}<br>
                                <strong>Days:</strong> {{ $leave->total_days }} day(s)<br>
                                <strong>Updated:</strong> {{ $leave->updated_at->diffForHumans() }}
                            </p>
                            @if($leave->status === 'approved')
                                <div class="alert alert-success alert-sm mb-0">
                                    <i class="fas fa-check-circle me-1"></i>
                                    <strong>Approved</strong> by {{ $leave->approvedBy->username ?? 'Admin' }}
                                </div>
                            @elseif($leave->status === 'rejected')
                                <div class="alert alert-danger alert-sm mb-0">
                                    <i class="fas fa-times-circle me-1"></i>
                                    <strong>Rejected</strong> by {{ $leave->approvedBy->username ?? 'Admin' }}
                                    @if($leave->admin_notes)
                                        <br><small><strong>Reason:</strong> {{ $leave->admin_notes }}</small>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    @endif

    <!-- Leave Requests Table -->
    <div class="table-container" id="leave-table">
        <div class="table-header">
            <h6 class="table-title">
                <i class="fas fa-table me-2"></i>
                @if(Auth::user()->isEmployee())
                    My Leave Requests ({{ $leaves->total() }})
                @else
                    Leave Management ({{ $leaves->total() }})
                    @if(Auth::user()->hasRole(['admin', 'hr', 'manager']) && $leaves->where('status', 'pending')->count() > 0)
                        <small class="text-muted ms-2">
                            <i class="fas fa-info-circle"></i>
                            {{ $leaves->where('status', 'pending')->count() }} pending request(s) require action
                        </small>
                    @endif
                @endif
            </h6>
            @if(!Auth::user()->isEmployee())
                <div class="btn-group" id="bulkActions" style="display: none;">
                    <button type="button" class="btn btn-success btn-sm" onclick="bulkApprove()">
                        <i class="fas fa-check me-1"></i>Approve Selected
                    </button>
                    <button type="button" class="btn btn-danger btn-sm" onclick="bulkReject()">
                        <i class="fas fa-times me-1"></i>Reject Selected
                    </button>
                </div>
            @endif
        </div>
        <div class="p-0">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            @if(!Auth::user()->isEmployee())
                                <th width="40">
                                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll()" title="Select All">
                                </th>
                            @endif
                            <th>#</th>
                            @if(!Auth::user()->hasRole('employee'))
                                <th>Employee</th>
                            @endif
                            <th>Leave Type</th>
                            <th>Duration</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th>Applied Date</th>
                            <th>Actions</th>
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
                                @if(!Auth::user()->isEmployee())
                                    <td>
                                        @if($leave->isPending())
                                            <input type="checkbox" name="selected_leaves[]" value="{{ $leave->id }}"
                                                   class="leave-checkbox" onchange="updateBulkActions()">
                                        @endif
                                    </td>
                                @endif
                                <td>{{ $leaves->firstItem() + $index }}</td>
                                @if(!Auth::user()->hasRole('employee'))
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2">
                                                <i class="fas fa-user-circle text-secondary" style="font-size: 1.5rem;"></i>
                                            </div>
                                            <div>
                                                <strong>{{ $leave->employee->name ?? 'N/A' }}</strong><br>
                                                <small class="text-muted">{{ $leave->employee->employee_code ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                @endif
                                <td>
                                    <span class="badge bg-info">{{ $leave->leave_type_display }}</span>
                                </td>
                                <td>
                                    <small>
                                        <strong>From:</strong> {{ $leave->start_date->format('d M Y') }}<br>
                                        <strong>To:</strong> {{ $leave->end_date->format('d M Y') }}
                                    </small>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $leave->total_days }} day(s)</span>
                                </td>
                                <td>
                                    <div class="text-center">
                                        @if($leave->status === 'pending')
                                            <span class="status-badge pending">
                                                <i class="fas fa-clock"></i>Pending
                                            </span>
                                            <br><small class="text-muted">Waiting for approval</small>
                                            @if($leave->start_date <= now()->addDays(3))
                                                <br><span class="badge badge-danger">Urgent</span>
                                            @endif
                                        @elseif($leave->status === 'waiting')
                                            <span class="status-badge waiting">
                                                <i class="fas fa-exclamation-triangle"></i>Waiting
                                            </span>
                                            <br><small class="text-warning mt-1">
                                                <strong>⚠️ Admin Response Required</strong>
                                            </small>
                                        @elseif($leave->status === 'approved')
                                            <span class="badge bg-success fs-6 mb-1">
                                                <i class="fas fa-check me-1"></i>Approved
                                            </span>
                                            <br><small class="text-success">
                                                <strong>by {{ $leave->approvedBy->username ?? 'Admin' }}</strong>
                                                <br>{{ $leave->approved_at ? $leave->approved_at->format('d M Y H:i') : '' }}
                                            </small>
                                        @elseif($leave->status === 'rejected')
                                            <span class="badge bg-danger fs-6 mb-1">
                                                <i class="fas fa-times me-1"></i>Rejected
                                            </span>
                                            <br><small class="text-danger">
                                                <strong>by {{ $leave->approvedBy->username ?? 'Admin' }}</strong>
                                                <br>{{ $leave->approved_at ? $leave->approved_at->format('d M Y H:i') : '' }}
                                            </small>
                                            @if($leave->admin_notes)
                                                <br><small class="text-danger">
                                                    <strong>Reason:</strong> {{ Str::limit($leave->admin_notes, 40) }}
                                                    @if(strlen($leave->admin_notes) > 40)
                                                        <a href="{{ route('leave.show', $leave) }}" class="text-decoration-none">...more</a>
                                                    @endif
                                                </small>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                                <td>{{ $leave->created_at->format('d M Y') }}</td>
                                <td>
                                    <!-- 🎯 SIMPLIFIED WORKING ACTIONS -->
                                    <div class="action-buttons-container" style="min-width: 140px;">

                                        <!-- 👁️ VIEW DETAIL - ALWAYS AVAILABLE -->
                                        <a href="{{ route('leave.show', $leave) }}" class="action-btn view" title="View Details">
                                            <i class="fas fa-eye"></i>View Detail
                                        </a>

                                        @if(($leave->isPending() || $leave->status === 'waiting') && Auth::user()->hasRole(['admin', 'hr', 'manager']))
                                            @if($leave->status === 'waiting')
                                                <!-- 🚨 WAITING STATUS - SPECIAL ACTIONS -->
                                                <div class="waiting-actions">
                                                    <div class="waiting-badge">⚠️ WAITING</div>

                                                    <!-- ✅ APPROVE BUTTON - ENHANCED -->
                                                    <form action="{{ route('leave.approve', $leave) }}" method="POST" class="mb-1" onsubmit="return confirmApprove('{{ $leave->employee->name ?? 'Employee' }}', '{{ $leave->leave_type_display }}')">
                                                        @csrf
                                                        <input type="hidden" name="admin_message" value="Your leave request has been approved by {{ Auth::user()->username }}.">
                                                        <button type="submit" class="action-btn approve" title="Approve Request">
                                                            <i class="fas fa-check"></i>APPROVE NOW
                                                        </button>
                                                    </form>

                                                    <!-- ❌ REJECT BUTTON - ENHANCED -->
                                                    <button type="button" class="action-btn reject"
                                                            onclick="simpleReject('{{ $leave->id }}', '{{ $leave->employee->name ?? 'Employee' }}', '{{ $leave->leave_type_display }}')"
                                                            title="Reject Request">
                                                        <i class="fas fa-times"></i>REJECT NOW
                                                    </button>
                                                </div>
                                            @else
                                                <!-- ✅ APPROVE BUTTON - STANDARD -->
                                                <form action="{{ route('leave.approve', $leave) }}" method="POST" class="mb-1" onsubmit="return confirmApprove('{{ $leave->employee->name ?? 'Employee' }}', '{{ $leave->leave_type_display }}')">
                                                    @csrf
                                                    <input type="hidden" name="admin_message" value="Your leave request has been approved by {{ Auth::user()->username }}.">
                                                    <button type="submit" class="action-btn approve" title="Approve Request">
                                                        <i class="fas fa-check"></i>Approve
                                                    </button>
                                                </form>

                                                <!-- ❌ REJECT BUTTON - STANDARD -->
                                                <button type="button" class="action-btn reject"
                                                        onclick="simpleReject('{{ $leave->id }}', '{{ $leave->employee->name ?? 'Employee' }}', '{{ $leave->leave_type_display }}')"
                                                        title="Reject Request">
                                                    <i class="fas fa-times"></i>Reject
                                                </button>
                                            @endif

                                        @elseif($leave->isPending() && $leave->employee_id == Auth::user()->employee?->id)
                                            <!-- EMPLOYEE ACTIONS -->
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
                                            <!-- READ-ONLY STATUS -->
                                            <div class="text-center">
                                                @if($leave->status === 'approved')
                                                    <span class="badge bg-success fs-6 mb-1">
                                                        <i class="fas fa-check-circle me-1"></i>Approved
                                                    </span>
                                                @elseif($leave->status === 'rejected')
                                                    <span class="badge bg-danger fs-6 mb-1">
                                                        <i class="fas fa-times-circle me-1"></i>Rejected
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning fs-6 mb-1">
                                                        <i class="fas fa-clock me-1"></i>{{ ucfirst($leave->status) }}
                                                    </span>
                                                @endif
                                                @if($leave->approved_by)
                                                    <br><small class="text-muted">by {{ $leave->approvedBy->username ?? 'Admin' }}</small>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ Auth::user()->isEmployee() ? '7' : '9' }}" class="text-center py-4">
                                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No leave requests found</h5>
                                    @if(Auth::user()->isEmployee())
                                        <p class="text-muted">Start by creating a leave request</p>
                                        <a href="{{ route('leave.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-1"></i> Request Leave
                                        </a>
                                    @else
                                        <p class="text-muted">No leave requests match your current filters</p>
                                        <a href="{{ route('leave.index') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-refresh me-1"></i> Clear Filters
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($leaves->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $leaves->appends(request()->query())->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Clean Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle me-2"></i>Reject Leave Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Employee Info -->
                    <div class="alert alert-light border">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Employee:</strong> <span id="modalEmployeeName">-</span>
                            </div>
                            <div class="col-md-6">
                                <strong>Leave Type:</strong> <span id="modalLeaveType">-</span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Reasons -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Quick Rejection Reasons:</label>
                        <div class="row g-2">
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="setReason('Insufficient notice period - please submit requests at least 14 days in advance.')">
                                    <i class="fas fa-clock me-1"></i>Insufficient Notice
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="setReason('Peak business period - unable to approve leave during this time.')">
                                    <i class="fas fa-chart-line me-1"></i>Peak Period
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="setReason('Staffing shortage - current levels do not permit additional leave.')">
                                    <i class="fas fa-users me-1"></i>Staffing Shortage
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="setReason('Conflicting requests - multiple team members requested same period.')">
                                    <i class="fas fa-calendar-times me-1"></i>Conflicting Requests
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="setReason('Incomplete documentation - additional information required.')">
                                    <i class="fas fa-file-alt me-1"></i>Incomplete Docs
                                </button>
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="setReason('Exceeds allowance - request would exceed available leave balance.')">
                                    <i class="fas fa-balance-scale me-1"></i>Exceeds Allowance
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Rejection Reason -->
                    <div class="mb-3">
                        <label for="adminNotes" class="form-label fw-bold">
                            Reason for Rejection <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="adminNotes" name="admin_notes" rows="4" required
                                  placeholder="Please provide a clear reason for rejecting this leave request..."></textarea>
                    </div>

                    <!-- Alternative Suggestions -->
                    <div class="mb-3">
                        <label for="alternativeSuggestions" class="form-label fw-bold">
                            Alternative Suggestions <span class="text-muted">(Optional)</span>
                        </label>
                        <textarea class="form-control" id="alternativeSuggestions" name="alternative_suggestions" rows="2"
                                  placeholder="Suggest alternative dates or solutions..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban me-1"></i>Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/leave-actions.js') }}"></script>
<script>
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
            isEmployee: {{ Auth::user()->isEmployee() ? 'true' : 'false' }},
            hasManagePermission: {{ Auth::user()->hasRole(['admin', 'hr', 'manager']) ? 'true' : 'false' }}
        }
    });

    // Auto-dismiss alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert:not(.alert-dismissible)');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    });

    // Real-time notification for admin
    @if(!Auth::user()->isEmployee())
        // Check for new pending requests every 30 seconds
        setInterval(function() {
            fetch('{{ route("leave.index") }}?ajax=1&status=pending')
                .then(response => response.json())
                .then(data => {
                    if (data.pending_count > {{ $stats['pending_leaves'] }}) {
                        leaveActions.showNotification('New leave request submitted!', 'warning');
                        // Update pending count in badge
                        const badge = document.querySelector('.btn-warning .badge, .btn-warning');
                        if (badge) {
                            badge.textContent = `Pending (${data.pending_count})`;
                        }
                    }
                })
                .catch(error => console.log('Error checking for updates:', error));
        }, 30000);
    @endif

    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Debug: Check if service is initialized
    console.log('LeaveActionsService initialized:', !!window.leaveActions);
    console.log('User context:', window.leaveActions?.user);
});

// 🎯 FIXED: Clean modal functions
function showRejectModal(leaveId, employeeName, leaveType) {
    console.log('showRejectModal called:', leaveId, employeeName, leaveType);

    // Check if modal exists
    let modal = document.getElementById('rejectModal');
    if (!modal) {
        console.error('Reject modal not found!');
        // Create modal if not exists
        createRejectModal();
        modal = document.getElementById('rejectModal');
    }

    // Set form action
    const form = document.getElementById('rejectForm');
    if (form) {
        form.action = '/leave/' + leaveId + '/reject';
    }

    // Set employee info
    const employeeNameEl = document.getElementById('modalEmployeeName');
    const leaveTypeEl = document.getElementById('modalLeaveType');

    if (employeeNameEl) employeeNameEl.textContent = employeeName;
    if (leaveTypeEl) leaveTypeEl.textContent = leaveType;

    // Clear previous values
    const adminNotesEl = document.getElementById('adminNotes');
    const alternativeSuggestionsEl = document.getElementById('alternativeSuggestions');

    if (adminNotesEl) adminNotesEl.value = '';
    if (alternativeSuggestionsEl) alternativeSuggestionsEl.value = '';

    // Show modal
    try {
        const bootstrapModal = new bootstrap.Modal(modal);
        bootstrapModal.show();
    } catch (error) {
        console.error('Error showing modal:', error);
        // Fallback: simple confirm
        const reason = prompt('Enter rejection reason:');
        if (reason) {
            submitRejectForm(leaveId, reason);
        }
    }
}

function setReason(reason) {
    const adminNotesEl = document.getElementById('adminNotes');
    if (adminNotesEl) {
        adminNotesEl.value = reason;
    }
}

// 🚀 ADDED: Create modal dynamically if not exists
function createRejectModal() {
    const modalHtml = `
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">
                        <i class="fas fa-times-circle me-2"></i>Reject Leave Request
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form id="rejectForm" method="POST">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="modal-body">
                        <div class="alert alert-light border">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Employee:</strong> <span id="modalEmployeeName">-</span>
                                </div>
                                <div class="col-md-6">
                                    <strong>Leave Type:</strong> <span id="modalLeaveType">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Quick Rejection Reasons:</label>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="setReason('Insufficient notice period - please submit requests at least 14 days in advance.')">
                                        <i class="fas fa-clock me-1"></i>Insufficient Notice
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="setReason('Peak business period - unable to approve leave during this time.')">
                                        <i class="fas fa-chart-line me-1"></i>Peak Period
                                    </button>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="setReason('Staffing shortage - current levels do not permit additional leave.')">
                                        <i class="fas fa-users me-1"></i>Staffing Shortage
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="adminNotes" class="form-label fw-bold">
                                Reason for Rejection <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="adminNotes" name="admin_notes" rows="4" required
                                      placeholder="Please provide a clear reason for rejecting this leave request..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="alternativeSuggestions" class="form-label fw-bold">
                                Alternative Suggestions <span class="text-muted">(Optional)</span>
                            </label>
                            <textarea class="form-control" id="alternativeSuggestions" name="alternative_suggestions" rows="2"
                                      placeholder="Suggest alternative dates or solutions..."></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-ban me-1"></i>Reject Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>`;

    document.body.insertAdjacentHTML('beforeend', modalHtml);
}

// 🚀 ADDED: Fallback submit function
function submitRejectForm(leaveId, reason) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '/leave/' + leaveId + '/reject';

    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = '{{ csrf_token() }}';
    form.appendChild(csrfInput);

    const notesInput = document.createElement('input');
    notesInput.type = 'hidden';
    notesInput.name = 'admin_notes';
    notesInput.value = reason;
    form.appendChild(notesInput);

    document.body.appendChild(form);
    form.submit();
}

// 🎯 Bulk Actions Functions
function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll') || document.getElementById('selectAllLeaves');
    const checkboxes = document.querySelectorAll('.leave-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });

    updateBulkActions();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.leave-checkbox:checked');
    const bulkButtons = document.querySelectorAll('[onclick*="showBulk"]');

    // Update button text with count
    bulkButtons.forEach(button => {
        if (button.textContent.includes('Bulk Approve')) {
            button.innerHTML = `<i class="fas fa-check-double me-1"></i>Bulk Approve (${checkedBoxes.length})`;
        } else if (button.textContent.includes('Bulk Reject')) {
            button.innerHTML = `<i class="fas fa-times-circle me-1"></i>Bulk Reject (${checkedBoxes.length})`;
        }
    });

    // Enable/disable bulk buttons
    const hasSelection = checkedBoxes.length > 0;
    bulkButtons.forEach(button => {
        button.disabled = !hasSelection;
        if (hasSelection) {
            button.classList.remove('btn-secondary');
            if (button.textContent.includes('Approve')) {
                button.classList.add('btn-success');
            } else {
                button.classList.add('btn-danger');
            }
        } else {
            button.classList.add('btn-secondary');
            button.classList.remove('btn-success', 'btn-danger');
        }
    });
}

function showBulkApprovalModal() {
    const checkedBoxes = document.querySelectorAll('.leave-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('⚠️ Please select at least one leave request to approve.');
        return;
    }

    const leaveIds = Array.from(checkedBoxes).map(cb => cb.value);
    const confirmMessage = `✅ BULK APPROVE CONFIRMATION\n\n` +
                          `You are about to approve ${leaveIds.length} leave request(s).\n\n` +
                          `This action cannot be undone.\n\n` +
                          `Continue with bulk approval?`;

    if (confirm(confirmMessage)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("leave.bulk-approve") }}';

        // Add CSRF token
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Add leave IDs
        leaveIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'leave_ids[]';
            input.value = id;
            form.appendChild(input);
        });

        // Add admin message
        const messageInput = document.createElement('input');
        messageInput.type = 'hidden';
        messageInput.name = 'admin_message';
        messageInput.value = 'Your leave requests have been approved via bulk action.';
        form.appendChild(messageInput);

        document.body.appendChild(form);
        form.submit();
    }
}

function showBulkRejectionModal() {
    const checkedBoxes = document.querySelectorAll('.leave-checkbox:checked');
    if (checkedBoxes.length === 0) {
        alert('⚠️ Please select at least one leave request to reject.');
        return;
    }

    const leaveIds = Array.from(checkedBoxes).map(cb => cb.value);
    const reason = prompt(`❌ BULK REJECT - ${leaveIds.length} Request(s)\n\nPlease provide a reason for rejecting these leave requests:`);

    if (reason && reason.trim()) {
        const confirmMessage = `❌ BULK REJECT CONFIRMATION\n\n` +
                              `You are about to reject ${leaveIds.length} leave request(s).\n\n` +
                              `Reason: ${reason}\n\n` +
                              `This action cannot be undone.\n\n` +
                              `Continue with bulk rejection?`;

        if (confirm(confirmMessage)) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("leave.bulk-reject") }}';

            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);

            // Add leave IDs
            leaveIds.forEach(id => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'leave_ids[]';
                input.value = id;
                form.appendChild(input);
            });

            // Add admin notes
            const notesInput = document.createElement('input');
            notesInput.type = 'hidden';
            notesInput.name = 'admin_notes';
            notesInput.value = reason;
            form.appendChild(notesInput);

            document.body.appendChild(form);
            form.submit();
        }
    }
}

// All leave action functions are now handled by the LeaveActionsService class
// The service provides consistent UI/UX and better error handling
// Global functions are available for backward compatibility

// Legacy notification function - now handled by service
function showNotification(message, type = 'info') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    alertDiv.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(alertDiv);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.remove();
        }
    }, 5000);
}

// Enhanced reject modal function
// 🎯 SIMPLIFIED WORKING FUNCTIONS
function confirmApprove(employeeName, leaveType) {
    return confirm(`Approve Leave Request?\n\nEmployee: ${employeeName}\nType: ${leaveType}\n\nThis will approve the request immediately.`);
}

function simpleReject(leaveId, employeeName, leaveType) {
    const reason = prompt(`Reject Leave Request?\n\nEmployee: ${employeeName}\nType: ${leaveType}\n\nPlease enter rejection reason:`);

    if (reason && reason.trim()) {
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

// 🧪 TEST FUNCTIONS for quick testing
function testApproveFirst() {
    const firstApproveButton = document.querySelector('button[type="submit"]:has(i.fa-check)');
    if (firstApproveButton) {
        console.log('Testing approve on first pending request');
        firstApproveButton.click();
    } else {
        alert('No approve button found');
    }
}

function testRejectFirst() {
    const firstRejectButton = document.querySelector('button[onclick*="simpleReject"]');
    if (firstRejectButton) {
        console.log('Testing reject on first pending request');
        firstRejectButton.click();
    } else {
        alert('No reject button found');
    }
}

// Set predefined rejection reason
function setReason(reason) {
    const textarea = document.getElementById('admin_notes');
    if (textarea.value.trim() === '') {
        textarea.value = reason;
    } else {
        textarea.value += '. ' + reason;
    }
    textarea.focus();
}

// Confirm delete function
function confirmDelete(itemName, deleteUrl) {
    if (confirm(`Are you sure you want to delete the leave request for ${itemName}?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
}

// Toggle select all checkboxes
function toggleSelectAll() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('input[name="selected_leaves[]"]');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });

    updateBulkActions();
}

// Update bulk action buttons visibility
function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('input[name="selected_leaves[]"]:checked');
    const bulkActions = document.getElementById('bulkActions');

    if (bulkActions && checkedBoxes.length > 0) {
        bulkActions.style.display = 'block';
        const approveBtn = bulkActions.querySelector('.btn-success');
        const rejectBtn = bulkActions.querySelector('.btn-danger');
        if (approveBtn) approveBtn.innerHTML = `<i class="fas fa-check me-1"></i>Approve Selected (${checkedBoxes.length})`;
        if (rejectBtn) rejectBtn.innerHTML = `<i class="fas fa-times me-1"></i>Reject Selected (${checkedBoxes.length})`;
    } else if (bulkActions) {
        bulkActions.style.display = 'none';
    }
}

// Show bulk actions panel
function showBulkActions() {
    const pendingCheckboxes = document.querySelectorAll('input[name="selected_leaves[]"]');
    if (pendingCheckboxes.length > 0) {
        // Scroll to table
        document.getElementById('leave-table').scrollIntoView({ behavior: 'smooth' });

        // Show notification
        showNotification('Select leave requests using checkboxes to perform bulk actions', 'info');
    }
}

// Bulk approve function
function bulkApprove() {
    const checkedBoxes = document.querySelectorAll('input[name="selected_leaves[]"]:checked');
    if (checkedBoxes.length === 0) {
        showNotification('Please select at least one leave request', 'warning');
        return;
    }

    if (confirm(`Are you sure you want to approve ${checkedBoxes.length} selected leave request(s)?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("leave.bulk-approve") }}';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);

        // Add selected leave IDs
        checkedBoxes.forEach(checkbox => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'leave_ids[]';
            input.value = checkbox.value;
            form.appendChild(input);
        });

        document.body.appendChild(form);
        form.submit();
    }
}

// Bulk reject function
function bulkReject() {
    const checkedBoxes = document.querySelectorAll('input[name="selected_leaves[]"]:checked');
    if (checkedBoxes.length === 0) {
        showNotification('Please select at least one leave request', 'warning');
        return;
    }

    // Show bulk reject modal
    showBulkRejectModal(checkedBoxes);
}

// Show bulk reject modal
function showBulkRejectModal(checkedBoxes) {
    let modal = document.getElementById('bulkRejectModal');
    if (!modal) {
        // Create modal if it doesn't exist
        createBulkRejectModal();
        modal = document.getElementById('bulkRejectModal');
    }

    const form = modal.querySelector('form');

    // Clear previous leave IDs
    const existingInputs = form.querySelectorAll('input[name="leave_ids[]"]');
    existingInputs.forEach(input => input.remove());

    // Add selected leave IDs
    checkedBoxes.forEach(checkbox => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'leave_ids[]';
        input.value = checkbox.value;
        form.appendChild(input);
    });

    // Update modal title
    const countElement = document.getElementById('bulkRejectCount');
    if (countElement) countElement.textContent = checkedBoxes.length;

    // Reset form
    const textarea = form.querySelector('textarea[name="admin_notes"]');
    if (textarea) {
        textarea.value = '';
    }

    // Show modal
    const bsModal = new bootstrap.Modal(modal);
    bsModal.show();
}

// Create bulk reject modal dynamically
function createBulkRejectModal() {
    const modalHtml = `
        <div class="modal fade" id="bulkRejectModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">
                            <i class="fas fa-times-circle text-danger me-2"></i>Bulk Reject Leave Requests
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('leave.bulk-reject') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                You are about to reject <strong id="bulkRejectCount">0</strong> leave request(s).
                            </div>

                            <div class="mb-3">
                                <label for="bulk_admin_notes" class="form-label">
                                    <strong>Reason for Rejection <span class="text-danger">*</span></strong>
                                </label>
                                <textarea class="form-control" id="bulk_admin_notes" name="admin_notes" rows="4"
                                          placeholder="Please provide a reason for rejecting these leave requests..." required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Cancel
                            </button>
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-times me-1"></i>Reject Selected
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalHtml);
}
</script>
@endpush





