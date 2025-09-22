@extends('layouts.admin')

@section('title', 'My Job Schedule')

{{-- HTML untuk Popup Notifikasi Kustom (Sukses & Error) --}}
<div class="popup-overlay" id="notificationPopup" style="display: none;">
    <div class="popup-card">
        <div id="notificationPopupIcon"></div>
        <h2 class="popup-title" id="notificationPopupTitle"></h2>
        <p class="popup-message" id="notificationPopupMessage"></p>
        <button class="popup-button" id="closeNotificationPopup">OK</button>
    </div>
</div>

<style>
/* Style untuk pop-up notifikasi */
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: none; /* Dikelola oleh JS */
    justify-content: center;
    align-items: center;
    z-index: 1050;
    padding: 20px;
    box-sizing: border-box;
}

.popup-card {
    background: white;
    padding: 2.5rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 420px;
    width: 100%;
    transform: scale(0.95);
    animation: popup-animation 0.3s ease-out forwards;
}

@keyframes popup-animation {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

.popup-icon {
    width: 80px; height: 80px; margin: 0 auto 1.5rem auto;
    background-color: #D1FAE5; border-radius: 50%;
    display: flex; justify-content: center; align-items: center;
}
.popup-icon svg { width: 40px; height: 40px; color: #065F46; }

.popup-icon-warning {
    width: 80px; height: 80px; margin: 0 auto 1.5rem auto;
    background-color: #FEE2E2; border-radius: 50%;
    display: flex; justify-content: center; align-items: center;
}
.popup-icon-warning svg { width: 40px; height: 40px; color: #B91C1C; }

.popup-title {
    font-size: 1.75rem; font-weight: 700; color: #1F2937;
    margin: 0 0 0.5rem 0;
}

.popup-message {
    font-size: 1rem; color: #6B7280; margin: 0 0 2rem 0;
    line-height: 1.6;
}

.popup-button {
    width: 100%; padding: 0.8rem 1rem; background-color: #1F2937;
    color: white; border: none; border-radius: 0.75rem;
    font-size: 1rem; font-weight: 500; cursor: pointer;
    transition: background-color 0.2s;
}
.popup-button:hover { background-color: #374151; }
</style>

@push('styles')
<style>
    /* Simple Schedule Page Styling */
    .schedule-page {
        padding: 1.5rem;
        background-color: #f8f9fa;
        min-height: calc(100vh - 120px);
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

    .stats-grid {
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
    .stat-card-simple.info { border-left-color: #17a2b8; }
    .stat-card-simple.danger { border-left-color: #dc3545; }
    .stat-card-simple.success { border-left-color: #28a745; }

    .stat-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .stat-icon {
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

    .stat-icon.primary { background-color: #007bff; }
    .stat-icon.warning { background-color: #ffc107; }
    .stat-icon.info { background-color: #17a2b8; }
    .stat-icon.danger { background-color: #dc3545; }
    .stat-icon.success { background-color: #28a745; }

    .stat-info h3 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        color: #2c3e50;
    }

    .stat-info p {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0.25rem 0 0 0;
        font-weight: 500;
    }
</style>
@endpush

@section('content')
<div class="schedule-page">
    <div class="page-header-card">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-calendar-check me-2 text-primary" style="color: #0d6efd;"></i>
                    My Job Schedule
                </h1>
                <p class="page-subtitle">
                    View and manage your assigned jobs and work schedule
                </p>
            </div>
        </div>
    </div>


    <!-- Tab Content -->
    <div class="tab-content" id="scheduleTabContent">
        <!-- My Jobs Tab -->
        <div class="tab-pane fade show active" id="my-jobs" role="tabpanel" aria-labelledby="my-jobs-tab">
            <!-- Job Statistics Cards -->
            <div class="stats-grid">
                <div class="stat-card-simple primary">
                    <div class="stat-content">
                        <div class="stat-icon primary">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $jobStats['total'] }}</h3>
                            <p>Total Jobs</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card-simple warning">
                    <div class="stat-content">
                        <div class="stat-icon warning">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $jobStats['pending'] }}</h3>
                            <p>Pending</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card-simple info">
                    <div class="stat-content">
                        <div class="stat-icon info">
                            <i class="fas fa-spinner"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $jobStats['in_progress'] }}</h3>
                            <p>In Progress</p>
                        </div>
                    </div>
                </div>

                <div class="stat-card-simple danger">
                    <div class="stat-content">
                        <div class="stat-icon danger">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <div class="stat-info">
                            <h3>{{ $jobStats['overdue'] }}</h3>
                            <p>Overdue</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- My Jobs Filters -->
            <div class="card mb-4">
                <div class="card-body">
                    <form method="GET" action="{{ route('job-batches.schedule') }}">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <label for="job_search" class="form-label">Search</label>
                                <input type="text" class="form-control" id="job_search" name="job_search"
                                       value="{{ request('job_search') }}" placeholder="Search jobs...">
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

                           <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div class="d-flex align-items-end gap-2">
                                <button type="submit" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i> Filters
                                </button>
                                <a href="{{ route('job-batches.schedule') }}" class="btn btn-secondary text-nowrap">
                                    <i class="fas fa-times me-2"></i> Clear
                                    </a>
                                <button type="button" class="btn btn-success text-nowrap" onclick="showCreateJobModal()">
                                     <i class="fas fa-plus me-2"></i> Add Job
                                </button>
                           </div>
                </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- My Jobs List -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-briefcase me-2"></i>My Jobs
                    </h6>
                </div>
                <div class="card-body">
                    @if($employeeJobs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Title</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Due Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employeeJobs as $job)
                                        <tr class="{{ $job->isOverdue() ? 'table-danger' : '' }}">
                                            <td>
                                                <div>
                                                    <strong>{{ $job->name }}</strong>
                                                    @if($job->isOverdue())
                                                        <span class="badge bg-danger ms-1">OVERDUE</span>
                                                    @endif
                                                    <br><small class="text-muted">{{ Str::limit($job->description, 60) }}</small>
                                                </div>
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
                                                    <button type="button" class="btn btn-sm btn-outline-info"
                                                            onclick="showJobDetails('{{ $job->id }}', '{{ addslashes($job->name) }}', '{{ addslashes($job->description) }}', '{{ $job->priority }}', '{{ $job->job_status }}', {{ $job->progress_percentage }}, '{{ $job->due_date ? $job->due_date->format('d M Y') : '' }}', '{{ $job->start_date ? $job->start_date->format('d M Y') : '' }}', '{{ addslashes($job->notes ?? '') }}')"
                                                            title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm btn-outline-warning"
                                                            onclick="showEditJobModal('{{ $job->id }}', '{{ addslashes($job->name) }}', '{{ addslashes($job->description) }}', '{{ $job->priority }}', '{{ $job->job_status }}', {{ $job->progress_percentage }}, '{{ $job->due_date ? $job->due_date->format('Y-m-d') : '' }}', '{{ $job->start_date ? $job->start_date->format('Y-m-d') : '' }}', '{{ addslashes($job->notes ?? '') }}')"
                                                            title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </button>
                                                    @if(!$job->isJobCompleted())
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                                onclick="showProgressModal('{{ $job->id }}', '{{ addslashes($job->name) }}', {{ $job->progress_percentage }}, '{{ $job->job_status }}')"
                                                                title="Update Progress">
                                                            <i class="fas fa-tasks"></i>
                                                        </button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <small class="text-muted">
                                    Showing {{ $employeeJobs->firstItem() }} to {{ $employeeJobs->lastItem() }}
                                    of {{ $employeeJobs->total() }} results
                                </small>
                            </div>
                            <div>
                                {{ $employeeJobs->appends(request()->query())->links() }}
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No Jobs Found</h5>
                            <p class="text-muted">You don't have any jobs assigned yet.</p>
                            <button type="button" class="btn btn-primary" onclick="showCreateJobModal()">
                                <i class="fas fa-plus me-1"></i> Create First Job
                            </button>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Job Modal -->
<div class="modal fade" id="createJobModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="createJobForm" action="{{ route('my-jobs.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('hr'))
                    <div class="mb-3">
                        <label for="create_employee_id" class="form-label">Assign to Employee <span class="text-danger">*</span></label>
                        <select class="form-control" id="create_employee_id" name="employee_id" required>
                            <option value="">Select Employee</option>
                            @if(isset($employees))
                                @foreach($employees as $emp)
                                    <option value="{{ $emp->id }}">{{ $emp->name }} ({{ $emp->employee_code }})</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    @endif
                    <div class="mb-3">
                        <label for="create_title" class="form-label">Job Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="create_title" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="create_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="create_priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select class="form-control" id="create_priority" name="priority" required>
                                    <option value="">Select Priority</option>
                                    <option value="low">Low</option>
                                    <option value="medium" selected>Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="create_start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="create_start_date" name="start_date"
                                       value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="create_due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="create_due_date" name="due_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="create_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="create_notes" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Job</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Job Modal -->
<div class="modal fade" id="editJobModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editJobForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_title" class="form-label">Job Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_title" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Description <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_priority" name="priority" required>
                                    <option value="low">Low</option>
                                    <option value="medium">Medium</option>
                                    <option value="high">High</option>
                                    <option value="urgent">Urgent</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-control" id="edit_status" name="job_status" required>
                                    <option value="pending">Pending</option>
                                    <option value="in_progress">In Progress</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="edit_due_date" class="form-label">Due Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" id="edit_due_date" name="due_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_progress" class="form-label">Progress</label>
                        <input type="range" class="form-range" id="edit_progress" name="progress_percentage"
                               min="0" max="100" value="0" oninput="updateEditProgressDisplay(this.value)">
                        <div class="d-flex justify-content-between">
                            <small>0%</small>
                            <small id="edit-progress-display">0%</small>
                            <small>100%</small>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="edit_notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="edit_notes" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Job</button>
                </div>
            </form>
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
                        <select class="form-control" id="status" name="job_status" required>
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

@push('scripts')
<script>
// --- Custom Popup System ---
function showNotification(type, message) {
    const popup = document.getElementById('notificationPopup');
    const iconDiv = document.getElementById('notificationPopupIcon');
    const titleEl = document.getElementById('notificationPopupTitle');
    const messageEl = document.getElementById('notificationPopupMessage');
    const closeButton = document.getElementById('closeNotificationPopup');

    if (!popup || !iconDiv || !titleEl || !messageEl || !closeButton) return;

    if (type === 'success') {
        iconDiv.innerHTML = `<div class="popup-icon"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" /></svg></div>`;
        titleEl.textContent = 'Success!';
        closeButton.className = 'popup-button';
    } else {
        iconDiv.innerHTML = `<div class="popup-icon-warning"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" /></svg></div>`;
        titleEl.textContent = 'Error!';
        closeButton.className = 'popup-button-danger';
    }

    messageEl.textContent = message;
    popup.style.display = 'flex';

    const close = () => popup.style.display = 'none';
    closeButton.onclick = close;
    popup.onclick = (e) => { if (e.target === popup) close(); };
}

// --- DOMContentLoaded: Initializations ---
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showNotification('success', @json(session('success')));
    @endif
    @if(session('error'))
        showNotification('error', @json(session('error')));
    @endif
});

let currentJobId = null;

// --- Modal & Form Logic ---
function showCreateJobModal() {
    const modal = new bootstrap.Modal(document.getElementById('createJobModal'));
    document.getElementById('createJobForm').reset();
    document.getElementById('create_start_date').value = new Date().toISOString().split('T')[0];
    modal.show();
}

function showEditJobModal(id, title, description, priority, status, progress, dueDate, startDate, notes) {
    const form = document.getElementById('editJobForm');
    form.action = `/my-jobs/${id}`;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_description').value = description;
    document.getElementById('edit_priority').value = priority;
    document.getElementById('edit_status').value = status;
    document.getElementById('edit_progress').value = progress;
    document.getElementById('edit_due_date').value = dueDate;
    document.getElementById('edit_start_date').value = startDate;
    document.getElementById('edit_notes').value = notes;
    updateEditProgressDisplay(progress);
    const modal = new bootstrap.Modal(document.getElementById('editJobModal'));
    modal.show();
}

function showProgressModal(jobId, jobTitle, currentProgress, currentStatus) {
    currentJobId = jobId;
    document.querySelector('#progressModal .modal-title').textContent = `Update Progress: ${jobTitle}`;
    document.getElementById('progress_percentage').value = currentProgress;
    document.getElementById('status').value = currentStatus;
    updateProgressDisplay(currentProgress);
    const modal = new bootstrap.Modal(document.getElementById('progressModal'));
    modal.show();
}

function showJobDetails(id, name, description, priority, status, progress, dueDate, startDate, notes) {
    document.getElementById('detail-name').textContent = name;
    document.getElementById('detail-priority').textContent = priority.charAt(0).toUpperCase() + priority.slice(1);
    document.getElementById('detail-progress').textContent = progress + '%';
    document.getElementById('detail-start').textContent = startDate || 'Not set';
    document.getElementById('detail-due').textContent = dueDate || 'Not set';
    document.getElementById('detail-description').textContent = description || 'No description provided';
    document.getElementById('detail-notes').textContent = notes || 'No notes available';

    const statusBadge = document.getElementById('detail-status');
    statusBadge.textContent = status.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    statusBadge.className = 'badge ' + getJobStatusBadgeClass(status);

    const modal = new bootstrap.Modal(document.getElementById('jobDetailsModal'));
    modal.show();
}

function getJobStatusBadgeClass(status) {
    switch(status.toLowerCase()) {
        case 'completed': return 'bg-success';
        case 'in_progress': return 'bg-info';
        case 'pending': return 'bg-warning';
        case 'cancelled': return 'bg-danger';
        default: return 'bg-secondary';
    }
}

function updateProgressDisplay(value) {
    document.getElementById('progress-display').textContent = value + '%';
    const statusSelect = document.getElementById('status');
    if (value == 100) statusSelect.value = 'completed';
    else if (value > 0) statusSelect.value = 'in_progress';
    else statusSelect.value = 'pending';
}

function updateEditProgressDisplay(value) {
    document.getElementById('edit-progress-display').textContent = value + '%';
    const statusSelect = document.getElementById('edit_status');
    if (value == 100) statusSelect.value = 'completed';
    else if (value > 0) statusSelect.value = 'in_progress';
    else statusSelect.value = 'pending';
}

// --- Form Submissions ---
document.getElementById('progressForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Updating...';

    fetch(`/my-jobs/${currentJobId}/progress`, {
        method: 'POST',
        body: new FormData(form),
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        bootstrap.Modal.getInstance(document.getElementById('progressModal')).hide();
        if (data.success) {
            showNotification('success', data.message || 'Progress updated successfully.');
            setTimeout(() => window.location.reload(), 1500);
        } else {
            showNotification('error', data.message || 'An error occurred.');
        }
    })
    .catch(error => {
        showNotification('error', 'An unexpected network error occurred. Please try again.');
        console.error('Error:', error);
    })
    .finally(() => {
        submitButton.disabled = false;
        submitButton.innerHTML = 'Update Progress';
    });
});
</script>
@endpush
