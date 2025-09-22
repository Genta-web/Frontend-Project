@extends('layouts.admin')

@section('title', 'Employee Jobs')

@if (session('success'))
<div class="popup-overlay" id="successPopup">
    <div class="popup-card">
        <div class="popup-icon">
            {{-- Ikon centang (check) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>
        <h2 class="popup-title">Success!</h2>
        <p class="popup-message">{{ session('success') }}</p>
        <button class="popup-button" id="closePopup">OK</button>
    </div>
</div>
@endif

<style>
/* Style untuk pop-up notifikasi */
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    padding: 20px;
    box-sizing: border-box;
}

.popup-card {
    background: white;
    padding: 2.5rem;
    border-radius: 1.5rem; /* Sudut lebih bulat */
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 400px;
    width: 100%;
    transform: scale(0.95);
    animation: popup-animation 0.3s ease-out forwards;
}

@keyframes popup-animation {
    from {
        opacity: 0;
        transform: scale(0.9);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.popup-icon {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem auto;
    background-color: #D1FAE5; /* Hijau muda */
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-icon svg {
    width: 40px;
    height: 40px;
    color: #065F46; /* Hijau tua */
}

.popup-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1F2937; /* Teks gelap */
    margin: 0 0 0.5rem 0;
}

.popup-message {
    font-size: 1rem;
    color: #6B7280; /* Teks abu-abu */
    margin: 0 0 2rem 0;
    line-height: 1.6;
}

.popup-button {
    width: 100%;
    padding: 0.8rem 1rem;
    background-color: #1F2937; /* Hitam/abu tua */
    color: white;
    border: none;
    border-radius: 0.75rem;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.popup-button:hover {
    background-color: #374151;
}
</style>

@push('styles')
<style>
    /* Enhanced Employee Jobs Styling */
    .btn-toolbar .dropdown .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        border: none;
        padding: 0.5rem 0;
    }

    .dropdown-item {
        padding: 0.75rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .dropdown-item.text-danger:hover {
        background-color: #fff5f5;
        color: #dc3545 !important;
    }

    /* Checkbox Styling */
    .form-check-input {
        border-radius: 4px;
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
    }

    .form-check-input:indeterminate {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    /* Table Enhancements */
    .table tbody tr {
        transition: all 0.3s ease;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Modal Enhancements */
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header.bg-danger {
        border-radius: 15px 15px 0 0;
    }

    .modal-footer {
        border-radius: 0 0 15px 15px;
        border-top: 2px solid #f8f9fa;
    }

    /* Enhanced Status Badges */
    .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
        border-radius: 15px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .badge:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    /* Filter Button Styling */
    .btn-group .btn {
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        margin: 0 2px;
        transition: all 0.3s ease;
    }

    .btn-group .btn.active {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    }

    .btn-group .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Professional Dropdown Styling (Like Leave Management) */
    .dropdown-menu {
        border-radius: 15px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        border: none;
        padding: 0;
        overflow: hidden;
        min-width: 280px;
    }

    .dropdown-header {
        font-weight: 700;
        color: #495057;
        text-transform: uppercase;
        font-size: 0.7rem;
        letter-spacing: 1px;
        padding: 0.75rem 1rem;
        margin: 0;
        border-bottom: 1px solid #e9ecef;
    }

    .dropdown-header.bg-light {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-bottom: 2px solid #dee2e6;
    }

    .dropdown-header.bg-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        border-bottom: 2px solid #bd2130;
    }

    .dropdown-item {
        padding: 1rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        display: flex;
        align-items: center;
    }

    .dropdown-item:hover:not(:disabled) {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        transform: translateX(3px);
        box-shadow: inset 3px 0 0 #007bff;
    }

    .dropdown-item:disabled {
        opacity: 0.4;
        cursor: not-allowed;
        background: #f8f9fa;
    }

    .dropdown-item.text-danger:hover {
        background: linear-gradient(135deg, #fff5f5 0%, #ffe6e6 100%);
        color: #dc3545 !important;
        box-shadow: inset 3px 0 0 #dc3545;
    }

    .dropdown-divider {
        margin: 0;
        border-top: 1px solid #e9ecef;
    }

    /* Professional Badge Styling */
    .dropdown-item .badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
        border-radius: 10px;
        font-weight: 600;
    }

    /* Enhanced Modal Styling */
    .modal-content {
        border-radius: 20px;
        border: none;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
        overflow: hidden;
    }

    .modal-header {
        border-bottom: 2px solid #e9ecef;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        border-top: 2px solid #e9ecef;
        padding: 1.5rem;
        background: #f8f9fa;
    }

    /* Professional Card Styling in Modal */
    .modal .card {
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .modal .card-header {
        padding: 1rem 1.5rem;
        font-weight: 600;
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }

    .modal .card-body {
        padding: 1.5rem;
    }

    /* Professional Status Summary Cards */
    .status-summary .card {
        border-radius: 15px;
        transition: all 0.3s ease;
        border-width: 2px;
    }

    .status-summary .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .status-summary .card-body {
        padding: 1.5rem;
    }

    .status-summary .progress {
        border-radius: 10px;
        overflow: hidden;
        background-color: rgba(0, 0, 0, 0.1);
    }

    .status-summary .progress-bar {
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    /* Responsive Status Cards */
    @media (max-width: 768px) {
        .status-summary .col-md-3 {
            margin-bottom: 1rem;
        }

        .status-summary .card-body {
            padding: 1rem;
        }

        .status-summary h3 {
            font-size: 1.5rem;
        }
    }

    /* Loading States */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }



    /* Badge Enhancements */
    .badge {
        font-weight: 500;
        padding: 0.5rem 0.75rem;
    }

    /* Progress Bar Styling */
    .progress {
        border-radius: 10px;
        background-color: #e9ecef;
    }

    .progress-bar {
        border-radius: 10px;
        transition: width 0.6s ease;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .btn-toolbar {
            flex-direction: column;
            gap: 0.5rem;
        }

        .dropdown {
            width: 100%;
        }

        .dropdown .btn {
            width: 100%;
        }

        .table-responsive {
            font-size: 0.875rem;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-4 pb-3 mb-4 border-bottom">
        <div>
            <h1 class="h3">
                @if(Auth::user()->hasRole('employee'))
                    My Jobs & Tasks
                @else
                    Employee Jobs & Tasks
                @endif
            </h1>
            <p class="text-muted">Manage and track job assignments and progress</p>
        </div>
        <div class="btn-toolbar">
            <div class="btn-group me-2">
                <a href="{{ route('employee-jobs.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Create Job
                </a>
            </div>
            @if(Auth::user()->hasRole(['admin', 'hr']))
                <div class="dropdown">
                    <button class="btn btn-outline-danger dropdown-toggle" type="button" id="bulkActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-trash me-1"></i>
                        Bulk Actions
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="bulkActionsDropdown">
                        <li>
                            <button class="dropdown-item" type="button" onclick="showBulkDeleteModal('selected')">
                                <i class="fas fa-check-square me-2 text-warning"></i>
                                Delete Selected
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item" type="button" onclick="showBulkDeleteModal('completed')">
                                <i class="fas fa-check-circle me-2 text-success"></i>
                                Delete All Completed
                            </button>
                        </li>
                        <li>
                            <button class="dropdown-item" type="button" onclick="showBulkDeleteModal('cancelled')">
                                <i class="fas fa-times-circle me-2 text-secondary"></i>
                                Delete All Cancelled
                            </button>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <button class="dropdown-item text-danger" type="button" onclick="showBulkDeleteModal('all')">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Delete All Jobs
                            </button>
                        </li>
                    </ul>
                </div>
            @endif
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('employee-jobs.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="search" name="search"
                               value="{{ request('search') }}" placeholder="Search by title or description...">
                    </div>
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('hr'))
                    <div class="col-md-2">
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
                    @endif
                    <div class="col-md-2">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="priority" class="form-label">Priority</label>
                        <select class="form-control" id="priority" name="priority">
                            <option value="">All Priority</option>
                            <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="due_date_filter" class="form-label">Due Date</label>
                        <select class="form-control" id="due_date_filter" name="due_date_filter">
                            <option value="">All Dates</option>
                            <option value="overdue" {{ request('due_date_filter') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                            <option value="today" {{ request('due_date_filter') == 'today' ? 'selected' : '' }}>Due Today</option>
                            <option value="this_week" {{ request('due_date_filter') == 'this_week' ? 'selected' : '' }}>Due This Week</option>
                        </select>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('employee-jobs.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Professional Status Summary (Like Leave Management) -->
    <div class="row mb-4 status-summary">
        <div class="col-md-3">
            <div class="card border-warning shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-clock fa-2x text-warning me-2"></i>
                        <div>
                            <h3 class="mb-0 text-warning">{{ $statusCounts['pending'] }}</h3>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-warning" style="width: {{ $statusCounts['total'] > 0 ? ($statusCounts['pending'] / $statusCounts['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-info shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="d-flex align-items-center justify-content-center mb-2">
                        <i class="fas fa-play fa-2x text-info me-2"></i>
                        <div>
                            <h3 class="mb-0 text-info">{{ $statusCounts['in_progress'] }}</h3>
                            <small class="text-muted">In Progress</small>
                        </div>
                    </div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-info" style="width: {{ $statusCounts['total'] > 0 ? ($statusCounts['in_progress'] / $statusCounts['total']) * 100 : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jobs Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-briefcase me-2"></i>Employee Jobs List
                        <span class="badge bg-light text-dark ms-2">{{ $employeeJobs->total() }}</span>
                    </h6>
                    <div class="mt-2">
                        <small class="text-muted">
                            <span class="badge bg-warning text-dark me-1" title="Pending Jobs Count">
                                <i class="fas fa-clock me-1"></i>{{ $statusCounts['pending'] ?? 0 }} Pending
                            </span>
                            <span class="badge bg-info text-white me-1" title="In Progress Jobs Count">
                                <i class="fas fa-play me-1"></i>{{ $statusCounts['in_progress'] ?? 0 }} In Progress
                            </span>
                            <span class="badge bg-success text-white me-1" title="Completed Jobs Count">
                                <i class="fas fa-check me-1"></i>{{ $statusCounts['completed'] ?? 0 }} Completed
                            </span>
                            <span class="badge bg-danger text-white" title="Cancelled Jobs Count">
                                <i class="fas fa-times me-1"></i>{{ $statusCounts['cancelled'] ?? 0 }} Cancelled
                            </span>
                        </small>
                        <div class="mt-1">
                            <small class="text-muted">
                                <strong>Debug Info:</strong>
                                Total={{ $statusCounts['total'] ?? 0 }},
                                P={{ $statusCounts['pending'] ?? 0 }},
                                IP={{ $statusCounts['in_progress'] ?? 0 }},
                                C={{ $statusCounts['completed'] ?? 0 }},
                                X={{ $statusCounts['cancelled'] ?? 0 }}
                            </small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end justify-content-start mt-2 mt-md-0 gap-2 flex-wrap">
                        <!-- Status Filter Buttons -->
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active" data-filter="all">
                                <i class="fas fa-list me-1"></i>All
                            </button>
                            <button type="button" class="btn btn-outline-warning" data-filter="pending">
                                <i class="fas fa-clock me-1"></i>Pending
                            </button>
                            <button type="button" class="btn btn-outline-info" data-filter="in_progress">
                                <i class="fas fa-play me-1"></i>In Progress
                            </button>
                            <button type="button" class="btn btn-outline-success" data-filter="completed">
                                <i class="fas fa-check me-1"></i>Completed
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-filter="cancelled">
                                <i class="fas fa-times me-1"></i>Cancelled
                            </button>
                        </div>

                        @if(Auth::user()->hasRole(['admin', 'hr']))
                            <!-- Professional Bulk Actions (Like Leave Management) -->
                            <div class="dropdown">
                                <button class="btn btn-outline-danger btn-sm dropdown-toggle" type="button" id="bulkActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-tasks me-1"></i>
                                    Bulk Management
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="bulkActionsDropdown" style="min-width: 280px;">
                                    <!-- Selection Actions -->
                                    <li class="dropdown-header bg-light">
                                        <i class="fas fa-check-square me-2"></i>Selection Actions
                                    </li>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center" type="button" onclick="showBulkDeleteModal('selected')">
                                            <div class="me-3">
                                                <i class="fas fa-check-square text-primary"></i>
                                            </div>
                                            <div>
                                                <div class="fw-bold">Delete Selected</div>
                                                <small class="text-muted">Remove individually selected jobs</small>
                                            </div>
                                        </button>
                                    </li>

                                    <li><hr class="dropdown-divider"></li>

                                    <!-- Status-Based Actions -->
                                    <li class="dropdown-header bg-light">
                                        <i class="fas fa-filter me-2"></i>Delete by Status
                                    </li>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center"
                                                type="button" onclick="showBulkDeleteModal('pending')"
                                                data-count="{{ $statusCounts['pending'] ?? 0 }}"
                                                title="Click to test - Count: {{ $statusCounts['pending'] ?? 0 }}"
                                            <div class="me-3">
                                                <i class="fas fa-clock text-warning"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">Delete Pending Jobs</div>
                                                <small class="text-muted">Remove jobs not yet started</small>
                                            </div>
                                            <span class="badge bg-warning text-dark">{{ $statusCounts['pending'] }}</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center"
                                                type="button" onclick="showBulkDeleteModal('in_progress')"
                                                data-count="{{ $statusCounts['in_progress'] ?? 0 }}"
                                                title="Click to test - Count: {{ $statusCounts['in_progress'] ?? 0 }}">
                                            <div class="me-3">
                                                <i class="fas fa-play text-info"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">Delete In Progress Jobs</div>
                                                <small class="text-muted">⚠️ Remove active jobs</small>
                                            </div>
                                            <span class="badge bg-info">{{ $statusCounts['in_progress'] ?? 0 }}</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center"
                                                type="button" onclick="showBulkDeleteModal('completed')"
                                                data-count="{{ $statusCounts['completed'] ?? 0 }}"
                                                title="Click to test - Count: {{ $statusCounts['completed'] ?? 0 }}">
                                            <div class="me-3">
                                                <i class="fas fa-check-circle text-success"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">Delete Completed Jobs</div>
                                                <small class="text-muted">Clean up finished tasks</small>
                                            </div>
                                            <span class="badge bg-success">{{ $statusCounts['completed'] ?? 0 }}</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center"
                                                type="button" onclick="showBulkDeleteModal('cancelled')"
                                                data-count="{{ $statusCounts['cancelled'] ?? 0 }}"
                                                title="Click to test - Count: {{ $statusCounts['cancelled'] ?? 0 }}">
                                            <div class="me-3">
                                                <i class="fas fa-times-circle text-danger"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">Delete Cancelled Jobs</div>
                                                <small class="text-muted">Remove cancelled tasks</small>
                                            </div>
                                            <span class="badge bg-danger">{{ $statusCounts['cancelled'] ?? 0 }}</span>
                                        </button>
                                    </li>

                                    <li><hr class="dropdown-divider"></li>

                                    <!-- Critical Actions -->
                                    <li class="dropdown-header bg-danger text-white">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Critical Actions
                                    </li>
                                    <li>
                                        <button class="dropdown-item d-flex align-items-center text-danger"
                                                type="button" onclick="showBulkDeleteModal('all')"
                                                data-count="{{ $statusCounts['total'] ?? 0 }}"
                                                title="Click to test - Count: {{ $statusCounts['total'] ?? 0 }}">
                                            <div class="me-3">
                                                <i class="fas fa-exclamation-triangle text-danger"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <div class="fw-bold">Delete ALL Jobs</div>
                                                <small class="text-muted">🚨 Complete database cleanup</small>
                                            </div>
                                            <span class="badge bg-danger">{{ $statusCounts['total'] ?? 0 }}</span>
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        @endif

                        <!-- Debug Status Counts Button -->
                        <button type="button" class="btn btn-outline-info btn-sm" onclick="debugStatusCounts()">
                            <i class="fas fa-bug me-1"></i>
                            Debug Counts
                        </button>

                        <!-- Test Bulk Delete Button -->
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="testBulkDelete()">
                            <i class="fas fa-test-tube me-1"></i>
                            Test Bulk Delete
                        </button>

                        <!-- Simple Test Modal Button -->
                        <button type="button" class="btn btn-outline-success btn-sm" onclick="testSimpleModal()">
                            <i class="fas fa-play me-1"></i>
                            Test Modal
                        </button>

                        <!-- Refresh Button -->
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="window.location.reload()">
                            <i class="fas fa-sync-alt me-1"></i>
                            Refresh
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            @if($employeeJobs->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                @if(Auth::user()->hasRole(['admin', 'hr']))
                                    <th width="3%">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                            <label class="form-check-label" for="selectAll"></label>
                                        </div>
                                    </th>
                                @endif
                                <th>Title</th>
                                @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('hr'))
                                <th>Employee</th>
                                @endif
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Due Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employeeJobs as $job)
                                <tr class="{{ $job->isOverdue() ? 'table-danger' : '' }}" data-job-id="{{ $job->id }}" data-status="{{ $job->status }}">
                                    @if(Auth::user()->hasRole(['admin', 'hr']))
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input job-checkbox" type="checkbox" value="{{ $job->id }}" id="job_{{ $job->id }}" onchange="updateBulkActions()">
                                                <label class="form-check-label" for="job_{{ $job->id }}"></label>
                                            </div>
                                        </td>
                                    @endif
                                    <td>
                                        <div>
                                            <strong>{{ $job->title }}</strong>
                                            @if($job->isOverdue())
                                                <span class="badge bg-danger ms-1">OVERDUE</span>
                                            @endif
                                            <br><small class="text-muted">{{ Str::limit($job->description, 60) }}</small>
                                        </div>
                                    </td>
                                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('hr'))
                                    <td>
                                        <span class="badge bg-info">{{ $job->employee->name }}</span>
                                    </td>
                                    @endif
                                    <td>
                                        <span class="badge {{ $job->priority_badge_class }}">
                                            {{ $job->priority_display }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $job->status_badge_class }}">
                                            {{ $job->status_display }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="progress" style="height: 20px;">
                                            <div class="progress-bar" role="progressbar"
                                                 style="width: {{ $job->progress_percentage }}%"
                                                 aria-valuenow="{{ $job->progress_percentage }}"
                                                 aria-valuemin="0" aria-valuemax="100">
                                                {{ $job->progress_percentage }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $job->due_date->format('d M Y') }}</small>
                                        @if($job->days_until_due < 0)
                                            <br><small class="text-danger">{{ abs($job->days_until_due) }} days overdue</small>
                                        @elseif($job->days_until_due == 0)
                                            <br><small class="text-warning">Due today</small>
                                        @elseif($job->days_until_due <= 3)
                                            <br><small class="text-warning">{{ $job->days_until_due }} days left</small>
                                        @else
                                            <br><small class="text-muted">{{ $job->days_until_due }} days left</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('employee-jobs.show', $job) }}"
                                               class="btn btn-sm btn-outline-info" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('hr') ||
                                                (Auth::user()->hasRole('employee') && Auth::user()->employee && $job->employee_id == Auth::user()->employee->id))
                                                <a href="{{ route('employee-jobs.edit', $job) }}"
                                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if(!$job->isCompleted())
                                                    <button type="button" class="btn btn-sm btn-outline-success"
                                                            onclick="showProgressModal({{ $job->id }}, '{{ $job->title }}', {{ $job->progress_percentage }}, '{{ $job->status }}')"
                                                            title="Update Progress">
                                                        <i class="fas fa-tasks"></i>
                                                    </button>
                                                @endif
                                            @endif

                                            @if(Auth::user()->hasRole('admin'))
                                                <button type="button" class="btn btn-sm btn-outline-danger"
                                                        onclick="confirmDelete('{{ $job->title }}', '{{ route('employee-jobs.destroy', $job->id) }}')"
                                                        title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Enhanced Professional Pagination -->
                @if($employeeJobs->hasPages())
                    <div class="card-footer bg-light border-top">
                        <div class="row align-items-center">
                            <div class="col-md-6">
                                <div class="pagination-info">
                                    <span class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Showing {{ $employeeJobs->firstItem() }} to {{ $employeeJobs->lastItem() }} of {{ $employeeJobs->total() }} results
                                    </span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="d-flex justify-content-md-end justify-content-center mt-2 mt-md-0">
                                    <nav aria-label="Employee jobs pagination">
                                        <div class="pagination-wrapper">
                                            {{ $employeeJobs->appends(request()->query())->links('custom.pagination') }}
                                        </div>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No Jobs Found</h5>
                    <p class="text-muted">There are no jobs matching your criteria.</p>
                    <a href="{{ route('employee-jobs.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Create First Job
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Bulk Delete Modal -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="bulkDeleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Bulk Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h5 class="text-danger">Warning: This action cannot be undone!</h5>
                </div>

                <div id="bulkDeleteContent">
                    <!-- Content will be populated by JavaScript -->
                </div>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Important:</strong> Deleted jobs cannot be recovered. This will permanently remove job records and any associated attachments.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmBulkDelete">
                    <i class="fas fa-trash me-1"></i>Delete Jobs
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Progress Update Modal -->
<div class="modal fade" id="progressModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Update Progress</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="progressForm">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="progress_percentage" class="form-label">Progress Percentage</label>
                        <input type="range" class="form-range" id="progress_percentage" name="progress_percentage"
                               min="0" max="100" value="0" oninput="updateProgressDisplay(this.value)">
                        <div class="d-flex justify-content-between">
                            <small>0%</small>
                            <small id="progress-display">0%</small>
                            <small>100%</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending">Pending</option>
                            <option value="in_progress">In Progress</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"
                                  placeholder="Add any notes about the progress..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Progress</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection



@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('successPopup');
    const closeButton = document.getElementById('closePopup');

    if (popup) {
        // Fungsi untuk menutup popup
        const closePopup = () => {
            popup.style.display = 'none';
        };

        // Tutup saat tombol OK diklik
        if (closeButton) {
            closeButton.addEventListener('click', closePopup);
        }

        // Tutup saat area luar popup diklik
        popup.addEventListener('click', function(event) {
            if (event.target === this) {
                closePopup();
            }
        });
    }

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

let currentJobId = null;

function showProgressModal(jobId, jobTitle, currentProgress, currentStatus) {
    currentJobId = jobId;
    document.querySelector('#progressModal .modal-title').textContent = `Update Progress: ${jobTitle}`;
    document.getElementById('progress_percentage').value = currentProgress;
    document.getElementById('status').value = currentStatus;
    updateProgressDisplay(currentProgress);

    const modal = new bootstrap.Modal(document.getElementById('progressModal'));
    modal.show();
}

function updateProgressDisplay(value) {
    document.getElementById('progress-display').textContent = value + '%';

    // Auto-update status based on progress
    const statusSelect = document.getElementById('status');
    if (value == 0) {
        statusSelect.value = 'pending';
    } else if (value == 100) {
        statusSelect.value = 'completed';
    } else if (value > 0 && value < 100) {
        statusSelect.value = 'in_progress';
    }
}

document.getElementById('progressForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch(`/employee-jobs/${currentJobId}/progress`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('progressModal')).hide();
            if (typeof window.showAlert === 'function') {
                window.showAlert('Success', data.message, 'success');
            } else {
                alert(data.message);
            }
            // Reload page to show updated data
            setTimeout(() => window.location.reload(), 1000);
        } else {
            alert('Error updating progress');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating progress');
    });
});





// Status Filter Functionality
document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    const tableRows = document.querySelectorAll('tbody tr[data-status]');

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');

            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            // Filter rows
            tableRows.forEach(row => {
                const status = row.getAttribute('data-status');

                if (filter === 'all' || status === filter) {
                    row.style.display = '';
                    // Add fade-in animation
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.style.opacity = '1';
                    }, 100);
                } else {
                    row.style.display = 'none';
                }
            });

            // Update count
            updateFilterCount(filter);
        });
    });

    // Update filter count
    function updateFilterCount(filter) {
        const visibleRows = Array.from(tableRows).filter(row => {
            const status = row.getAttribute('data-status');
            return filter === 'all' || status === filter;
        });

        console.log(`Showing ${visibleRows.length} jobs for filter: ${filter}`);
    }

    // Add smooth transitions
    tableRows.forEach(row => {
        row.style.transition = 'all 0.3s ease';
    });
});

// Bulk Delete Functionality
function toggleSelectAll() {
    const selectAllCheckbox = document.getElementById('selectAll');
    const jobCheckboxes = document.querySelectorAll('.job-checkbox');

    jobCheckboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });

    updateBulkActions();
}

function updateBulkActions() {
    const selectedCheckboxes = document.querySelectorAll('.job-checkbox:checked');
    const selectAllCheckbox = document.getElementById('selectAll');
    const totalCheckboxes = document.querySelectorAll('.job-checkbox');

    // Update select all checkbox state
    if (selectedCheckboxes.length === 0) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = false;
    } else if (selectedCheckboxes.length === totalCheckboxes.length) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = true;
    } else {
        selectAllCheckbox.indeterminate = true;
    }
}

function showBulkDeleteModal(type) {
    console.log('showBulkDeleteModal called with type:', type);

    try {
        const modal = new bootstrap.Modal(document.getElementById('bulkDeleteModal'));
        const content = document.getElementById('bulkDeleteContent');
        const confirmBtn = document.getElementById('confirmBulkDelete');

        // Simple status counts - using direct values to avoid PHP parsing issues
        const statusCounts = {
            pending: parseInt('{{ $statusCounts["pending"] ?? 0 }}') || 0,
            in_progress: parseInt('{{ $statusCounts["in_progress"] ?? 0 }}') || 0,
            completed: parseInt('{{ $statusCounts["completed"] ?? 0 }}') || 0,
            cancelled: parseInt('{{ $statusCounts["cancelled"] ?? 0 }}') || 0,
            total: parseInt('{{ $statusCounts["total"] ?? 0 }}') || 0
        };

        // Debug: Log the status counts
        console.log('Status counts from backend:', statusCounts);
        console.log('Delete type:', type);

        // Verify modal elements exist
        if (!modal || !content || !confirmBtn) {
            console.error('Modal elements not found:', {modal, content, confirmBtn});
            alert('Error: Modal elements not found. Please refresh the page.');
            return;
        }

    let title = '';
    let description = '';
    let count = 0;
    let deleteType = type;
    let statusColor = '';
    let statusIcon = '';
    let warningLevel = 'info';

        if (type === 'selected') {
            const selectedCheckboxes = document.querySelectorAll('.job-checkbox:checked');
            count = selectedCheckboxes.length;

            if (count === 0) {
                alert('Please select at least one job to delete.');
                return;
            }

            title = `Delete Selected Jobs`;
            description = `You have selected ${count} job${count > 1 ? 's' : ''} for deletion.`;
            statusColor = 'primary';
            statusIcon = 'check-square';
            warningLevel = 'warning';
        } else if (type === 'pending') {
            count = statusCounts.pending;
            title = `Delete All Pending Jobs`;
            description = `This will remove all ${count} jobs that haven't been started yet.`;
            statusColor = 'warning';
            statusIcon = 'clock';
            warningLevel = 'info';
        } else if (type === 'in_progress') {
            count = statusCounts.in_progress;
            title = `Delete All In Progress Jobs`;
            description = `⚠️ WARNING: This will delete ${count} jobs currently being worked on!`;
            statusColor = 'info';
            statusIcon = 'play';
            warningLevel = 'danger';
        } else if (type === 'completed') {
            count = statusCounts.completed;
            title = `Delete All Completed Jobs`;
            description = `This will clean up your database by removing ${count} finished tasks.`;
            statusColor = 'success';
            statusIcon = 'check-circle';
            warningLevel = 'info';
        } else if (type === 'cancelled') {
            count = statusCounts.cancelled;
            title = `Delete All Cancelled Jobs`;
            description = `This will remove all ${count} cancelled jobs from your database.`;
            statusColor = 'danger';
            statusIcon = 'times-circle';
            warningLevel = 'info';
        } else if (type === 'all') {
            count = statusCounts.total;
            title = `Delete ALL Jobs`;
            description = `🚨 CRITICAL: This will delete all ${count} jobs and completely clear your job management database!`;
            statusColor = 'danger';
            statusIcon = 'exclamation-triangle';
            warningLevel = 'danger';
        }

        console.log('Modal data prepared:', {title, description, count, statusColor, statusIcon, warningLevel});

        // Simple modal content
        content.innerHTML = `
            <div class="text-center mb-3">
                <h5 class="text-danger">${title}</h5>
                <p class="text-muted">${description}</p>
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>${count} job${count > 1 ? 's' : ''} will be permanently deleted!</strong>
                </div>
                <div class="bg-light p-3 rounded">
                    <h4 class="text-${statusColor} mb-0">${count}</h4>
                    <small class="text-muted">Job${count > 1 ? 's' : ''} to delete</small>
                </div>
            </div>
        `;

        console.log('Modal content set successfully');

        // Store delete type and count for confirmation
        confirmBtn.setAttribute('data-delete-type', type);
        confirmBtn.setAttribute('data-count', count);

        // Update button text
        confirmBtn.innerHTML = '<i class="fas fa-trash me-1"></i>Delete Jobs';
        confirmBtn.className = 'btn btn-danger';

        console.log('About to show modal');
        modal.show();
        console.log('Modal show() called');

    } catch (error) {
        console.error('Error in showBulkDeleteModal:', error);
        alert('Error opening delete modal: ' + error.message);
    }
}

// Professional alert function like leave management
function showAlert(title, message, type = 'info') {
    // Create alert modal if it doesn't exist
    let alertModal = document.getElementById('alertModal');
    if (!alertModal) {
        const alertHTML = `
            <div class="modal fade" id="alertModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" id="alertHeader">
                            <h5 class="modal-title" id="alertTitle"></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body" id="alertBody"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                        </div>
                    </div>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', alertHTML);
        alertModal = document.getElementById('alertModal');
    }

    const header = document.getElementById('alertHeader');
    const titleEl = document.getElementById('alertTitle');
    const body = document.getElementById('alertBody');

    // Set colors based on type
    const colors = {
        'info': 'bg-info text-white',
        'warning': 'bg-warning text-dark',
        'danger': 'bg-danger text-white',
        'success': 'bg-success text-white'
    };

    const icons = {
        'info': 'fa-info-circle',
        'warning': 'fa-exclamation-triangle',
        'danger': 'fa-exclamation-circle',
        'success': 'fa-check-circle'
    };

    header.className = `modal-header ${colors[type]}`;
    titleEl.innerHTML = `<i class="fas ${icons[type]} me-2"></i>${title}`;
    body.innerHTML = message;

    new bootstrap.Modal(alertModal).show();
}

// Simplified bulk delete confirmation handler
document.getElementById('confirmBulkDelete').addEventListener('click', function() {
    console.log('Confirm bulk delete clicked');

    const deleteType = this.getAttribute('data-delete-type');
    const count = this.getAttribute('data-count');

    console.log('Delete type:', deleteType, 'Count:', count);

    // Show loading state
    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Deleting...';
    this.disabled = true;

    // Prepare data for deletion
    let deleteData = {
        type: deleteType,
        _token: '{{ csrf_token() }}'
    };

    if (deleteType === 'selected') {
        const selectedIds = Array.from(document.querySelectorAll('.job-checkbox:checked'))
                               .map(checkbox => checkbox.value);
        deleteData.ids = selectedIds;
        console.log('Selected IDs:', selectedIds);
    }

    console.log('Sending delete request with data:', deleteData);

    // Send delete request
    fetch('{{ route("employee-jobs.bulk-delete") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(deleteData)
    })
    })
    .then(data => {
        console.log('Response data:', data);

        if (data.success) {
            // Close modal
            const modalInstance = bootstrap.Modal.getInstance(document.getElementById('bulkDeleteModal'));
            modalInstance.hide();

            // Show success message
            alert(`Successfully deleted ${data.deleted_count} job${data.deleted_count > 1 ? 's' : ''}.`);

            // Reload page
            setTimeout(() => {
                window.location.reload();
            }, 1000);
        } else {
            throw new Error(data.message || 'Delete operation failed');
        }
    })
    .catch(error => {
        console.error('Bulk delete error:', error);
        alert('Failed to delete jobs: ' + error.message);

        // Reset button state
        this.innerHTML = '<i class="fas fa-trash me-1"></i>Delete Jobs';
        this.disabled = false;
    });
});

// Professional success notification function
function showSuccessNotification(count, type) {
    const typeLabels = {
        'selected': 'selected',
        'pending': 'pending',
        'in_progress': 'in progress',
        'completed': 'completed',
        'cancelled': 'cancelled',
        'all': 'all'
    };

    const message = count === 1
        ? `Successfully deleted 1 ${typeLabels[type]} job.`
        : `Successfully deleted ${count} ${typeLabels[type]} jobs.`;

    showAlert('Delete Successful', message, 'success');

    // Optional: Show toast notification if available
    if (typeof window.showToast === 'function') {
        window.showToast('success', 'Jobs Deleted', message);
    }
}

// Simple test modal function
function testSimpleModal() {
    console.log('Testing simple modal');

    try {
        const modal = document.getElementById('bulkDeleteModal');
        const content = document.getElementById('bulkDeleteContent');
        const confirmBtn = document.getElementById('confirmBulkDelete');

        console.log('Modal elements:', {modal, content, confirmBtn});

        if (!modal || !content || !confirmBtn) {
            alert('Modal elements not found!');
            return;
        }

        // Set simple content
        content.innerHTML = `
            <div class="text-center">
                <h5>Test Modal</h5>
                <p>This is a test to verify the modal is working.</p>
                <div class="alert alert-info">
                    Status counts: P={{ $statusCounts['pending'] ?? 0 }}, IP={{ $statusCounts['in_progress'] ?? 0 }}, C={{ $statusCounts['completed'] ?? 0 }}, X={{ $statusCounts['cancelled'] ?? 0 }}
                </div>
            </div>
        `;

        confirmBtn.setAttribute('data-delete-type', 'test');
        confirmBtn.innerHTML = '<i class="fas fa-check me-1"></i>Test OK';

        const modalInstance = new bootstrap.Modal(modal);
        modalInstance.show();

        console.log('Test modal shown successfully');

    } catch (error) {
        console.error('Test modal error:', error);
        alert('Test modal error: ' + error.message);
    }
}

// Test function to verify bulk delete modal
function testBulkDelete() {
    // Test with different status types
    const testTypes = ['pending', 'in_progress', 'completed', 'cancelled', 'all'];

    let testResults = '<strong>Bulk Delete Modal Test Results:</strong><br><br>';

    testTypes.forEach(type => {
        try {
            // Try to call the function without actually showing the modal
            const statusCounts = {
                pending: {{ $statusCounts['pending'] ?? 0 }},
                in_progress: {{ $statusCounts['in_progress'] ?? 0 }},
                completed: {{ $statusCounts['completed'] ?? 0 }},
                cancelled: {{ $statusCounts['cancelled'] ?? 0 }},
                total: {{ $statusCounts['total'] ?? 0 }}
            };

            let count = 0;
            switch(type) {
                case 'pending': count = statusCounts.pending; break;
                case 'in_progress': count = statusCounts.in_progress; break;
                case 'completed': count = statusCounts.completed; break;
                case 'cancelled': count = statusCounts.cancelled; break;
                case 'all': count = statusCounts.total; break;
            }

            testResults += `• ${type.toUpperCase()}: ${count} jobs - ${count > 0 ? '✅ Available' : '❌ Empty'}<br>`;
        } catch (error) {
            testResults += `• ${type.toUpperCase()}: ❌ Error - ${error.message}<br>`;
        }
    });

    showAlert('Bulk Delete Test', testResults, 'info');
}

// Debug function to check status counts
function debugStatusCounts() {
    fetch('{{ route("employee-jobs.status-counts") }}', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const counts = data.statusCounts;
            const message = `
                <strong>Current Status Counts from Database:</strong><br>
                • Total: ${counts.total}<br>
                • Pending: ${counts.pending}<br>
                • In Progress: ${counts.in_progress}<br>
                • Completed: ${counts.completed}<br>
                • Cancelled: ${counts.cancelled}<br><br>
                <strong>Counts from View:</strong><br>
                • Total: {{ $statusCounts['total'] }}<br>
                • Pending: {{ $statusCounts['pending'] }}<br>
                • In Progress: {{ $statusCounts['in_progress'] }}<br>
                • Completed: {{ $statusCounts['completed'] }}<br>
                • Cancelled: {{ $statusCounts['cancelled'] }}
            `;
            showAlert('Status Counts Debug', message, 'info');
        } else {
            showAlert('Debug Failed', 'Failed to fetch status counts.', 'danger');
        }
    })
    .catch(error => {
        console.error('Debug error:', error);
        showAlert('Debug Error', 'Error fetching status counts: ' + error.message, 'danger');
    });
}

// Enhanced loading state CSS
const style = document.createElement('style');
style.textContent = `
    .btn-loading {
        position: relative;
        pointer-events: none;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.1);
        border-radius: inherit;
    }
`;
document.head.appendChild(style);

function confirmDelete(itemName, deleteUrl) {
    if (confirm(`Are you sure you want to delete "${itemName}"?`)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = deleteUrl;

        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';

        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';

        form.appendChild(csrfToken);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endpush
