@extends('layouts.admin')

@section('title', 'Employee Jobs Management')



@push('styles')
<style>
    .jobs-page {
        background-color: #f8f9fa;
        min-height: calc(100vh - 120px);
        padding: 1.5rem;
    }

    .page-header-card {
        background: white;
        border-radius: 8px;
        padding: 2rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-left: 4px solid #007bff;
    }

    .page-title {
        color: #2c3e50;
        font-size: 1.75rem;
        font-weight: 600;
        margin: 0;
    }

    .page-subtitle {
        color: #6c757d;
        margin: 0.5rem 0 0 0;
        font-size: 0.95rem;
    }

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

    .btn-clean.outline-primary {
        background-color: transparent;
        color: #007bff;
        border: 1px solid #007bff;
    }

    .btn-clean.outline-primary:hover {
        background-color: #007bff;
        color: white;
    }

    /* Enhanced Bulk Actions Styling */
    .dropdown-menu {
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

    /* Professional Pagination Styling */
    .pagination-info {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        font-weight: 500;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Enhanced Table Styling */
    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f4;
    }

    .table tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.05);
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
    }

    /* Status Row Colors */
    .table-info {
        background-color: rgba(13, 202, 240, 0.05);
        border-left: 4px solid #0dcaf0;
    }

    .table-warning {
        background-color: rgba(255, 193, 7, 0.05);
        border-left: 4px solid #ffc107;
    }

    .table-success {
        background-color: rgba(25, 135, 84, 0.05);
        border-left: 4px solid #198754;
    }

    .table-danger {
        background-color: rgba(220, 53, 69, 0.05);
        border-left: 4px solid #dc3545;
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

    /* Responsive Design */
    @media (max-width: 768px) {
        .pagination-info {
            text-align: center;
            margin-bottom: 1rem;
        }

        .dropdown {
            width: 100%;
        }

        .dropdown .btn {
            width: 100%;
        }
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
</style>
@endpush

@section('content')
<div class="jobs-page">
    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <strong>Error!</strong> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Warning!</strong> {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Page Header -->
    <div class="page-header-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-briefcase me-2 text-primary"></i>
                    Employee Jobs Management
                </h1>
                <p class="page-subtitle">
                    Monitor and manage all employee job assignments and progress
                </p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn-clean outline-primary" onclick="refreshPage()">
                    <i class="fas fa-sync-alt"></i>
                    Refresh
                </button>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card-clean">
        <div class="card-header-clean">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filter Jobs
            </h6>
        </div>
        <div class="card-body-clean">
            <form method="GET" action="{{ route('job-batches.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label for="job_search" class="form-label">Search</label>
                        <input type="text" class="form-control" id="job_search" name="job_search"
                               value="{{ request('job_search') }}" placeholder="Search by job title or description...">
                    </div>
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
                    <div class="col-md-2">
                        <label for="job_status" class="form-label">Status</label>
                        <select class="form-control" id="job_status" name="job_status">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('job_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ request('job_status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="completed" {{ request('job_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('job_status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="job_priority" class="form-label">Priority</label>
                        <select class="form-control" id="job_priority" name="job_priority">
                            <option value="">All Priority</option>
                            <option value="urgent" {{ request('job_priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            <option value="high" {{ request('job_priority') == 'high' ? 'selected' : '' }}>High</option>
                            <option value="medium" {{ request('job_priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="low" {{ request('job_priority') == 'low' ? 'selected' : '' }}>Low</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-secondary">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                            <a href="{{ route('job-batches.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-undo me-1"></i> Clear
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Employee Jobs Table -->
    <div class="card shadow">
        <div class="card-header py-3">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-briefcase me-2"></i>Employee Jobs List
                        <span class="badge bg-light text-dark ms-2">{{ $employeeJobs->total() }}</span>
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end justify-content-start gap-2 flex-wrap">
                        <!-- Status Filter Buttons -->
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active" data-filter="all">
                                <i class="fas fa-list me-1"></i>All
                            </button>
                            <button type="button" class="btn btn-outline-info" data-filter="pending">
                                <i class="fas fa-clock me-1"></i>Pending
                            </button>
                            <button type="button" class="btn btn-outline-warning" data-filter="in_progress">
                                <i class="fas fa-play me-1"></i>In Progress
                            </button>
                        </div>
                        @if(Auth::user()->hasRole(['admin', 'hr']))
                            <!-- Bulk Actions -->
                            <div class="dropdown">
                                <button class="btn btn-outline-danger btn-sm dropdown-toggle" type="button" id="bulkActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-trash me-1"></i>
                                    Bulk Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="bulkActionsDropdown">
                                    <li>
                                        <button class="dropdown-item" type="button" onclick="showBulkDeleteModal('selected')">
                                            <i class="fas fa-trash-alt me-2 text-warning"></i>
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
                                            <i class="fas fa-times-circle me-2 text-danger"></i>
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
                                <th>Job Title</th>
                                <th>Employee</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Due Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($employeeJobs as $job)
                                <tr class="{{ $job->isOverdue() ? 'table-danger' : '' }}" data-job-id="{{ $job->id }}" data-status="{{ $job->job_status }}">
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
                                            <strong>{{ $job->name }}</strong>
                                            @if($job->isOverdue())
                                                <span class="badge bg-danger ms-1">OVERDUE</span>
                                            @endif
                                            @if($job->description)
                                                <br><small class="text-muted">{{ Str::limit($job->description, 60) }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($job->employee)
                                            <span class="badge bg-info">{{ $job->employee->name }}</span>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge {{ $job->priority_badge_class }}">
                                            {{ $job->priority_display }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $job->job_status_badge_class }}">
                                            {{ $job->job_status_display }}
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
                                        @if($job->due_date)
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
                                        @else
                                            <small class="text-muted">No due date</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-sm btn-outline-info"
                                                    onclick="showJobDetails('{{ $job->id }}', '{{ addslashes($job->name) }}', '{{ addslashes($job->description ?? '') }}', '{{ $job->priority }}', '{{ $job->job_status }}', {{ $job->progress_percentage }}, '{{ $job->due_date ? $job->due_date->format('d M Y') : '' }}', '{{ $job->start_date ? $job->start_date->format('d M Y') : '' }}', '{{ addslashes($job->notes ?? '') }}')"
                                                    title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </button>
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
                    <h5 class="text-muted">No Employee Jobs Found</h5>
                    <p class="text-muted">There are no employee jobs matching your criteria.</p>
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('hr'))
                        <p class="text-muted">Employees can create jobs from their "My Schedule" page.</p>
                    @endif
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Job Details Modal -->
<div class="modal fade" id="jobDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Job Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Job Name:</strong>
                        <p id="detail-name" class="text-muted"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Priority:</strong>
                        <p id="detail-priority" class="text-muted"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Status:</strong>
                        <p><span id="detail-status" class="badge"></span></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Progress:</strong>
                        <p id="detail-progress" class="text-muted"></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <strong>Start Date:</strong>
                        <p id="detail-start" class="text-muted"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Due Date:</strong>
                        <p id="detail-due" class="text-muted"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Description:</strong>
                    <p id="detail-description" class="text-muted"></p>
                </div>
                <div class="mb-3">
                    <strong>Notes:</strong>
                    <p id="detail-notes" class="text-muted"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


@endsection

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
                    <strong>Important:</strong> Deleted jobs cannot be recovered. This will permanently remove job records and any associated data.
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

function refreshPage() {
    window.location.reload();
}

function showJobDetails(id, name, description, priority, status, progress, dueDate, startDate, notes) {
    document.getElementById('detail-name').textContent = name;
    document.getElementById('detail-priority').textContent = priority.charAt(0).toUpperCase() + priority.slice(1);
    document.getElementById('detail-progress').textContent = progress + '%';
    document.getElementById('detail-start').textContent = startDate || 'Not set';
    document.getElementById('detail-due').textContent = dueDate || 'Not set';
    document.getElementById('detail-description').textContent = description || 'No description provided';
    document.getElementById('detail-notes').textContent = notes || 'No notes available';

    // Set status badge
    const statusBadge = document.getElementById('detail-status');
    statusBadge.textContent = status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    statusBadge.className = 'badge ' + getStatusBadgeClass(status);

    // Show modal
    const modal = new bootstrap.Modal(document.getElementById('jobDetailsModal'));
    modal.show();
}



function confirmDelete(jobName, jobId) {
    if (confirm(`Are you sure you want to delete "${jobName}"?`)) {
        fetch(`/my-jobs/${jobId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (typeof window.showAlert === 'function') {
                    window.showAlert('Success', data.message, 'success');
                } else {
                    alert(data.message);
                }
                // Reload page to show updated data
                setTimeout(() => window.location.reload(), 1000);
            } else {
                alert('Error deleting job');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting job');
        });
    }
}

function getStatusBadgeClass(status) {
    switch(status.toLowerCase()) {
        case 'completed': return 'bg-success';
        case 'in_progress': return 'bg-info';
        case 'pending': return 'bg-warning';
        case 'cancelled': return 'bg-danger';
        default: return 'bg-secondary';
    }
}


</script>
@endpush

@push('scripts')
<script>
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
    const modal = new bootstrap.Modal(document.getElementById('bulkDeleteModal'));
    const content = document.getElementById('bulkDeleteContent');
    const confirmBtn = document.getElementById('confirmBulkDelete');
    const modalTitle = document.getElementById('bulkDeleteModalLabel');

    let title = '';
    let description = '';
    let count = 0;
    let deleteType = type;

    if (type === 'selected') {
        const selectedCheckboxes = document.querySelectorAll('.job-checkbox:checked');
        count = selectedCheckboxes.length;

        if (count === 0) {
            // Ganti alert ke tampilan modal sederhana
            modalTitle.textContent = 'No Jobs Selected';
            content.innerHTML = `
                <div class="text-center p-3">
                    <i class="fas fa-info-circle fa-3x text-warning mb-3"></i>
                    <p class="mb-2 fs-5">Please select at least one job to delete.</p>
                </div>
            `;
            confirmBtn.style.display = 'none'; // Sembunyikan tombol "Delete"
            modal.show();
            return;
        }

        title = `Delete ${count} Selected Job${count > 1 ? 's' : ''}`;
        description = `You are about to delete ${count} selected job${count > 1 ? 's' : ''}. This action will permanently remove ${count > 1 ? 'these jobs' : 'this job'} and any associated data.`;
    } else if (type === 'completed') {
        const completedRows = document.querySelectorAll('[data-status="completed"]');
        count = completedRows.length;
        title = `Delete All Completed Jobs`;
        description = `You are about to delete all ${count} completed jobs. This will help clean up your database by removing finished tasks.`;
    } else if (type === 'cancelled') {
        const cancelledRows = document.querySelectorAll('[data-status="cancelled"]');
        count = cancelledRows.length;
        title = `Delete All Cancelled Jobs`;
        description = `You are about to delete all ${count} cancelled jobs. This will help clean up your database by removing cancelled tasks.`;
    } else if (type === 'all') {
        const allRows = document.querySelectorAll('[data-job-id]');
        count = allRows.length;
        title = `Delete ALL Jobs`;
        description = `⚠️ DANGER: You are about to delete ALL ${count} jobs in the system. This includes pending, in progress, completed, and cancelled jobs. This action will completely clear your job management database.`;
    }

    content.innerHTML = `
        <div class="text-center mb-3">
            <h6 class="text-danger">${title}</h6>
            <p class="text-muted">${description}</p>
            <div class="badge bg-danger fs-6 px-3 py-2">
                <i class="fas fa-exclamation-triangle me-1"></i>
                ${count} Job${count > 1 ? 's' : ''} will be deleted
            </div>
        </div>
    `;

    // Store delete type and count for confirmation
    confirmBtn.setAttribute('data-delete-type', deleteType);
    confirmBtn.setAttribute('data-count', count);

    modal.show();
}

// Handle bulk delete confirmation
document.getElementById('confirmBulkDelete').addEventListener('click', function() {
    const deleteType = this.getAttribute('data-delete-type');
    const count = this.getAttribute('data-count');

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
    }

    // Send delete request
    fetch('{{ route("job-batches.bulk-delete") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(deleteData)
    })
    .then(response => {
        // Check if response is ok
        if (!response.ok) {
            // Try to get error message from response
            return response.json().then(errorData => {
                throw new Error(errorData.message || `HTTP error! status: ${response.status}`);
            }).catch(() => {
                throw new Error(`HTTP error! status: ${response.status}`);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Close modal
            bootstrap.Modal.getInstance(document.getElementById('bulkDeleteModal')).hide();

            // Reload page immediately to show Bootstrap alert
            window.location.reload();
        } else {
            throw new Error(data.message || 'Delete operation failed');
        }
    })
    .catch(error => {
        console.error('Bulk delete error:', error);

        let errorMessage = 'Failed to delete jobs. Please try again.';
        if (error.message && error.message !== 'Failed to fetch') {
            errorMessage = error.message;
        }

        // Show error using simple alert for now, or you can create a temporary error display
        alert(errorMessage);

        // Reset button
        this.innerHTML = '<i class="fas fa-trash me-1"></i>Delete Jobs';
        this.disabled = false;
    });
});

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
