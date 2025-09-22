<?php $__env->startSection('title', 'Attendance Management'); ?>

<?php $__env->startPush('styles'); ?>
<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<?php $__env->stopPush(); ?>

<?php if(session('success')): ?>
<div class="popup-overlay" id="successPopup">
    <div class="popup-card">
        <div class="popup-icon">
            
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>
        <h2 class="popup-title">Success!</h2>
        <p class="popup-message"><?php echo e(session('success')); ?></p>
        <button class="popup-button" id="closePopup">OK</button>
    </div>
</div>
<?php endif; ?>

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

.pagination { margin-bottom: 0; }
</style>

<?php $__env->startPush('styles'); ?>
<style>
    .attendance-page {
        background-color: #f8f9fa;
        min-height: calc(100vh - 120px);
        padding: 1.5rem;
    }

    .dashboard-header {
        background: linear-gradient(135deg, #03a9f4 0%, #0288d1 50%, #0277bd 100%);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(3, 169, 244, 0.4);
        position: relative;
        overflow: hidden;
    }

    .dashboard-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        animation: float 6s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px) rotate(0deg); }
        50% { transform: translateY(-20px) rotate(180deg); }
    }

    .dashboard-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .dashboard-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

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
    .stat-card-simple.success { border-left-color: #28a745; }
    .stat-card-simple.warning { border-left-color: #ffc107; }
    .stat-card-simple.danger { border-left-color: #dc3545; }

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
    .stat-icon-simple.success { background-color: #28a745; }
    .stat-icon-simple.warning { background-color: #ffc107; }
    .stat-icon-simple.danger { background-color: #dc3545; }

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

    /* Employee Analytics Styling */
    .employee-analytics-link {
        transition: all 0.2s ease;
    }

    .employee-analytics-link:hover {
        color: #0056b3 !important;
        text-decoration: underline !important;
    }

    .employee-analytics-link:hover i {
        transform: scale(1.2);
    }

    .modal-xl {
        max-width: 1200px;
    }

    .progress {
        border-radius: 10px;
        overflow: hidden;
    }

    .progress-bar {
        transition: width 0.6s ease;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
    }

    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.75em;
    }

    /* Chart container styles */
    .chart-container {
        position: relative;
        height: 300px;
        margin-bottom: 20px;
    }

    .chart-container canvas {
        max-height: 100%;
    }

    /* Card styling for charts */
    .card {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        border: 1px solid rgba(0, 0, 0, 0.125);
        transition: box-shadow 0.15s ease-in-out;
    }

    .card:hover {
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.125);
        font-weight: 600;
    }

    /* Responsive chart adjustments */
    @media (max-width: 768px) {
        .chart-container {
            height: 250px;
        }
    }

    /* Chart specific styling */
    #weeklyChart, #monthlyChart, #timeChart, #performanceChart {
        max-height: 300px;
    }

    /* Animation for summary cards */
    .card {
        animation: fadeInUp 0.6s ease-out;
    }

    .card:nth-child(1) { animation-delay: 0.1s; }
    .card:nth-child(2) { animation-delay: 0.2s; }
    .card:nth-child(3) { animation-delay: 0.3s; }
    .card:nth-child(4) { animation-delay: 0.4s; }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Loading animation for charts */
    .chart-loading {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 200px;
        color: #6c757d;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="attendance-page">
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="dashboard-title">
                    <i class="fas fa-clock me-3"></i>Attendance Management
                </h1>
                <p class="dashboard-subtitle">
                     Track and manage employee attendance records
                </p>
            </div>
        </div>
    </div>

    <div class="stats-container">
        <div class="stat-card-simple primary">
            <div class="stat-content-simple">
                <div class="stat-icon-simple primary">
                    <i class="fas fa-users"></i>
                </div>
                <div class="stat-info-simple">
                    <h3><?php echo e($stats['total_today']); ?></h3>
                    <p>Total Today</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple success">
            <div class="stat-content-simple">
                <div class="stat-icon-simple success">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info-simple">
                    <h3><?php echo e($stats['present_today']); ?></h3>
                    <p>Present Today</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple danger">
            <div class="stat-content-simple">
                <div class="stat-icon-simple danger">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info-simple">
                    <h3><?php echo e($stats['absent_today']); ?></h3>
                    <p>Absent Today</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple warning">
            <div class="stat-content-simple">
                <div class="stat-icon-simple warning">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info-simple">
                    <h3><?php echo e($stats['late_today']); ?></h3>
                    <p>Late Today</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card-clean">
        <div class="card-header-clean">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filters
            </h6>
        </div>
        <div class="card-body-clean">
            <form method="GET" action="<?php echo e(route('attendance.index')); ?>">
                <div class="row">
                    <div class="col-md-3">
                        <label for="date_from" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="date_from" name="date_from"
                               value="<?php echo e(request('date_from')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="date_to" name="date_to"
                               value="<?php echo e(request('date_to')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="employee_id" class="form-label">Employee</label>
                        <select class="form-control" id="employee_id" name="employee_id">
                            <option value="">All Employees</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>"
                                        <?php echo e(request('employee_id') == $employee->id ? 'selected' : ''); ?>>
                                    <?php echo e($employee->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">All Status</option>
                            <option value="present" <?php echo e(request('status') == 'present' ? 'selected' : ''); ?>>Present</option>
                            <option value="sick" <?php echo e(request('status') == 'sick' ? 'selected' : ''); ?>>Sick</option>
                            <option value="leave" <?php echo e(request('status') == 'leave' ? 'selected' : ''); ?>>Leave</option>
                            <option value="absent" <?php echo e(request('status') == 'absent' ? 'selected' : ''); ?>>Absent</option>
                        </select>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i> Filter
                        </button>
                        <a href="<?php echo e(route('attendance.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-clean">
        <div class="card-header-clean">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Attendance Records
            </h6>
        </div>
        <div class="card-body-clean">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($attendances->firstItem() + $index); ?></td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar me-2">
                                            <i class="fas fa-user-circle text-secondary" style="font-size: 1.5rem;"></i>
                                        </div>
                                        <div>
                                            <?php if(Auth::user()->role === 'admin' || Auth::user()->role === 'hr' || Auth::user()->role === 'manager'): ?>
                                                <strong>
                                                    <a href="javascript:void(0)"
                                                       class="employee-analytics-link text-primary text-decoration-none"
                                                       data-employee-id="<?php echo e($attendance->employee->id ?? ''); ?>"
                                                       data-employee-name="<?php echo e($attendance->employee->name ?? 'N/A'); ?>"
                                                       title="View Analytics">
                                                        <?php echo e($attendance->employee->name ?? 'N/A'); ?>

                                                        <i class="fas fa-chart-line ms-1" style="font-size: 0.8rem;"></i>
                                                    </a>
                                                </strong>
                                            <?php else: ?>
                                                <strong><?php echo e($attendance->employee->name ?? 'N/A'); ?></strong>
                                            <?php endif; ?>
                                            <br>
                                            <small class="text-muted"><?php echo e($attendance->employee->employee_code ?? 'N/A'); ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo e($attendance->date ? $attendance->date->format('d M Y') : 'N/A'); ?></td>
                                <td>
                                    <?php if($attendance->check_in): ?>
                                        <span class="badge bg-info"><?php echo e($attendance->check_in); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($attendance->check_out): ?>
                                        <span class="badge bg-secondary"><?php echo e($attendance->check_out); ?></span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                        $badgeClass = match($attendance->status) {
                                            'present' => 'bg-success',
                                            'sick' => 'bg-warning',
                                            'leave' => 'bg-info',
                                            'absent' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    ?>
                                    <span class="badge <?php echo e($badgeClass); ?>">
                                        <?php echo e(ucfirst($attendance->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($attendance->notes): ?>
                                        <span title="<?php echo e($attendance->notes); ?>">
                                            <?php echo e(Str::limit($attendance->notes, 30)); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="<?php echo e(route('attendance.show', $attendance)); ?>"
                                           class="btn btn-sm btn-outline-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo e(route('attendance.edit', $attendance)); ?>"
                                           class="btn btn-sm btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-danger"
                                                onclick="confirmDelete('<?php echo e($attendance->employee->name ?? 'Record'); ?> - <?php echo e($attendance->date ? $attendance->date->format('d M Y') : 'N/A'); ?>', '<?php echo e(route('attendance.destroy', $attendance)); ?>')"
                                                title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4"> <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No attendance records found</h5>
                                    <p class="text-muted">Start by adding attendance records for employees</p>
                                    <a href="<?php echo e(route('attendance.create')); ?>" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Add First Record
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($attendances->hasPages()): ?>
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-3 gap-2">
                    <div class="text-muted small mb-2 mb-md-0">
                        Showing <?php echo e($attendances->firstItem()); ?> to <?php echo e($attendances->lastItem()); ?> of <?php echo e($attendances->total()); ?> results
                    </div>
                    <nav>
                        <?php echo e($attendances->onEachSide(1)->links('pagination::bootstrap-5')); ?>

                    </nav>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Employee Analytics Modal -->
    <div class="modal fade" id="employeeAnalyticsModal" tabindex="-1" aria-labelledby="employeeAnalyticsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen-lg-down modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="employeeAnalyticsModalLabel">
                        <i class="fas fa-chart-line me-2"></i>
                        Employee Attendance Analytics
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="analyticsContent">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading analytics data...</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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

    // Employee Analytics functionality
    const analyticsLinks = document.querySelectorAll('.employee-analytics-link');
    const analyticsModal = new bootstrap.Modal(document.getElementById('employeeAnalyticsModal'));
    const analyticsContent = document.getElementById('analyticsContent');

    analyticsLinks.forEach(link => {
        link.addEventListener('click', function() {
            const employeeId = this.getAttribute('data-employee-id');
            const employeeName = this.getAttribute('data-employee-name');

            // Update modal title
            document.getElementById('employeeAnalyticsModalLabel').innerHTML =
                `<i class="fas fa-chart-line me-2"></i>Attendance Analytics - ${employeeName}`;

            // Show loading state
            analyticsContent.innerHTML = `
                <div class="text-center py-4">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Loading analytics data...</p>
                </div>
            `;

            // Show modal
            analyticsModal.show();

            // Fetch analytics data
            fetch(`/attendance/analytics/${employeeId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.error) {
                        throw new Error(data.message || 'Unknown error occurred');
                    }
                    displayAnalytics(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                    analyticsContent.innerHTML = `
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Error loading analytics data:</strong><br>
                            ${error.message}<br>
                            <small class="text-muted">Please check the console for more details.</small>
                        </div>
                    `;
                });
        });
    });

    function displayAnalytics(data) {
        console.log('Analytics data received:', data);
        const { employee, weekly_analytics, monthly_analytics } = data;

        analyticsContent.innerHTML = `
            <!-- Employee Info -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-1">Employee Name</h6>
                                    <p class="mb-0 fw-bold">${employee.name}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-1">Employee Code</h6>
                                    <p class="mb-0">${employee.employee_code}</p>
                                </div>
                                <div class="col-md-4">
                                    <h6 class="text-muted mb-1">Position</h6>
                                    <p class="mb-0">${employee.position}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            <div class="row mb-4" id="summaryCards">
                <!-- Summary cards will be populated by JavaScript -->
            </div>

            <!-- Charts Section -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-line me-2"></i>
                                Weekly Attendance Rate
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="weeklyChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-bar me-2"></i>
                                Monthly Attendance Rate
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="monthlyChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Time Trends Chart -->
            <div class="row mb-4">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-clock me-2"></i>
                                Check-in & Check-out Time Trends (Weekly)
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="timeChart" width="400" height="150"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-pie me-2"></i>
                                Overall Performance
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="performanceChart" width="300" height="150"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Weekly Analytics -->
            <div class="row mb-4">
                <div class="col-12">
                    <h5 class="mb-3">
                        <i class="fas fa-calendar-week text-primary me-2"></i>
                        Weekly Analytics (Last 4 Weeks)
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-primary">
                                <tr>
                                    <th>Week Period</th>
                                    <th>Days Present</th>
                                    <th>Avg Check-in</th>
                                    <th>Avg Check-out</th>
                                    <th>Attendance Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${weekly_analytics.map(week => `
                                    <tr>
                                        <td>${week.week_start} - ${week.week_end}</td>
                                        <td>
                                            <span class="badge bg-info">${week.total_days} days</span>
                                        </td>
                                        <td>
                                            ${week.avg_check_in ? `<span class="badge bg-success">${week.avg_check_in}</span>` : '<span class="text-muted">-</span>'}
                                        </td>
                                        <td>
                                            ${week.avg_check_out ? `<span class="badge bg-secondary">${week.avg_check_out}</span>` : '<span class="text-muted">-</span>'}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 100px; height: 20px;">
                                                    <div class="progress-bar ${week.attendance_rate >= 80 ? 'bg-success' : week.attendance_rate >= 60 ? 'bg-warning' : 'bg-danger'}"
                                                         style="width: ${week.attendance_rate}%"></div>
                                                </div>
                                                <span class="fw-bold">${week.attendance_rate}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Monthly Analytics -->
            <div class="row">
                <div class="col-12">
                    <h5 class="mb-3">
                        <i class="fas fa-calendar-alt text-success me-2"></i>
                        Monthly Analytics (Last 6 Months)
                    </h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th>Month</th>
                                    <th>Days Present</th>
                                    <th>Working Days</th>
                                    <th>Avg Check-in</th>
                                    <th>Avg Check-out</th>
                                    <th>Attendance Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${monthly_analytics.map(month => `
                                    <tr>
                                        <td class="fw-bold">${month.month}</td>
                                        <td>
                                            <span class="badge bg-info">${month.total_days} days</span>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark">${month.working_days} days</span>
                                        </td>
                                        <td>
                                            ${month.avg_check_in ? `<span class="badge bg-success">${month.avg_check_in}</span>` : '<span class="text-muted">-</span>'}
                                        </td>
                                        <td>
                                            ${month.avg_check_out ? `<span class="badge bg-secondary">${month.avg_check_out}</span>` : '<span class="text-muted">-</span>'}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress me-2" style="width: 100px; height: 20px;">
                                                    <div class="progress-bar ${month.attendance_rate >= 80 ? 'bg-success' : month.attendance_rate >= 60 ? 'bg-warning' : 'bg-danger'}"
                                                         style="width: ${month.attendance_rate}%"></div>
                                                </div>
                                                <span class="fw-bold">${month.attendance_rate}%</span>
                                            </div>
                                        </td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        `;

        // Create summary cards and charts after DOM is updated
        setTimeout(() => {
            createSummaryCards(weekly_analytics, monthly_analytics);
            createWeeklyChart(weekly_analytics);
            createMonthlyChart(monthly_analytics);
            createTimeChart(weekly_analytics);
            createPerformanceChart(monthly_analytics);
        }, 100);
    }

    // Global chart variables to store chart instances
    let weeklyChartInstance = null;
    let monthlyChartInstance = null;
    let timeChartInstance = null;
    let performanceChartInstance = null;

    function createSummaryCards(weeklyData, monthlyData) {
        const summaryContainer = document.getElementById('summaryCards');
        if (!summaryContainer) return;

        // Calculate summary statistics
        const totalWeeklyDays = weeklyData.reduce((sum, week) => sum + week.total_days, 0);
        const avgWeeklyRate = weeklyData.length > 0
            ? weeklyData.reduce((sum, week) => sum + week.attendance_rate, 0) / weeklyData.length
            : 0;

        const totalMonthlyDays = monthlyData.reduce((sum, month) => sum + month.total_days, 0);
        const totalWorkingDays = monthlyData.reduce((sum, month) => sum + month.working_days, 0);
        const avgMonthlyRate = monthlyData.length > 0
            ? monthlyData.reduce((sum, month) => sum + month.attendance_rate, 0) / monthlyData.length
            : 0;

        // Find best and worst performing weeks
        const bestWeek = weeklyData.reduce((best, week) =>
            week.attendance_rate > best.attendance_rate ? week : best, weeklyData[0] || {attendance_rate: 0});
        const worstWeek = weeklyData.reduce((worst, week) =>
            week.attendance_rate < worst.attendance_rate ? week : worst, weeklyData[0] || {attendance_rate: 100});

        summaryContainer.innerHTML = `
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Weekly Average</h6>
                                <h3 class="mb-0">${avgWeeklyRate.toFixed(1)}%</h3>
                                <small>Last 4 weeks</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar-week fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Monthly Average</h6>
                                <h3 class="mb-0">${avgMonthlyRate.toFixed(1)}%</h3>
                                <small>Last 6 months</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-calendar-alt fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Total Present</h6>
                                <h3 class="mb-0">${totalMonthlyDays}</h3>
                                <small>of ${totalWorkingDays} working days</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-user-check fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h6 class="card-title">Best Week</h6>
                                <h3 class="mb-0">${bestWeek.attendance_rate}%</h3>
                                <small>${bestWeek.week_start || 'N/A'}</small>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-trophy fa-2x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }

    function createWeeklyChart(weeklyData) {
        const ctx = document.getElementById('weeklyChart');
        if (!ctx) return;

        // Destroy existing chart if it exists
        if (weeklyChartInstance) {
            weeklyChartInstance.destroy();
        }

        const labels = weeklyData.map(week => `${week.week_start} - ${week.week_end.split(',')[0]}`);
        const attendanceRates = weeklyData.map(week => week.attendance_rate);
        const totalDays = weeklyData.map(week => week.total_days);

        weeklyChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Attendance Rate (%)',
                    data: attendanceRates,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1,
                    fill: true
                }, {
                    label: 'Days Present',
                    data: totalDays,
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.1,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Weekly Attendance Trends'
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Attendance Rate (%)'
                        },
                        min: 0,
                        max: 100
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Days Present'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        min: 0,
                        max: 7
                    }
                }
            }
        });
    }

    function createMonthlyChart(monthlyData) {
        const ctx = document.getElementById('monthlyChart');
        if (!ctx) return;

        // Destroy existing chart if it exists
        if (monthlyChartInstance) {
            monthlyChartInstance.destroy();
        }

        const labels = monthlyData.map(month => month.month.split(' ')[0]); // Get month name only
        const attendanceRates = monthlyData.map(month => month.attendance_rate);
        const totalDays = monthlyData.map(month => month.total_days);
        const workingDays = monthlyData.map(month => month.working_days);

        monthlyChartInstance = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Attendance Rate (%)',
                    data: attendanceRates,
                    backgroundColor: 'rgba(54, 162, 235, 0.8)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1,
                    yAxisID: 'y'
                }, {
                    label: 'Days Present',
                    data: totalDays,
                    backgroundColor: 'rgba(255, 206, 86, 0.8)',
                    borderColor: 'rgba(255, 206, 86, 1)',
                    borderWidth: 1,
                    yAxisID: 'y1'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Attendance Overview'
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Attendance Rate (%)'
                        },
                        min: 0,
                        max: 100
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Days Present'
                        },
                        grid: {
                            drawOnChartArea: false,
                        },
                        min: 0
                    }
                }
            }
        });
    }

    function createTimeChart(weeklyData) {
        const ctx = document.getElementById('timeChart');
        if (!ctx) return;

        // Destroy existing chart if it exists
        if (timeChartInstance) {
            timeChartInstance.destroy();
        }

        const labels = weeklyData.map(week => `${week.week_start} - ${week.week_end.split(',')[0]}`);

        // Convert time strings to minutes for plotting
        function timeToMinutes(timeStr) {
            if (!timeStr) return null;
            const [hours, minutes] = timeStr.split(':').map(Number);
            return hours * 60 + minutes;
        }

        // Convert minutes back to time string for display
        function minutesToTime(minutes) {
            if (minutes === null) return 'N/A';
            const hours = Math.floor(minutes / 60);
            const mins = minutes % 60;
            return `${hours.toString().padStart(2, '0')}:${mins.toString().padStart(2, '0')}`;
        }

        const checkInTimes = weeklyData.map(week => timeToMinutes(week.avg_check_in));
        const checkOutTimes = weeklyData.map(week => timeToMinutes(week.avg_check_out));

        timeChartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Average Check-in Time',
                    data: checkInTimes,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }, {
                    label: 'Average Check-out Time',
                    data: checkOutTimes,
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.1,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Check-in & Check-out Time Trends'
                    },
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.dataset.label || '';
                                const timeStr = minutesToTime(context.parsed.y);
                                return `${label}: ${timeStr}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        type: 'linear',
                        display: true,
                        title: {
                            display: true,
                            text: 'Time'
                        },
                        min: 480, // 8:00 AM
                        max: 1080, // 6:00 PM
                        ticks: {
                            callback: function(value) {
                                return minutesToTime(value);
                            },
                            stepSize: 60 // 1 hour steps
                        }
                    }
                }
            }
        });
    }

    function createPerformanceChart(monthlyData) {
        const ctx = document.getElementById('performanceChart');
        if (!ctx) return;

        // Destroy existing chart if it exists
        if (performanceChartInstance) {
            performanceChartInstance.destroy();
        }

        // Calculate overall performance metrics
        const totalWorkingDays = monthlyData.reduce((sum, month) => sum + month.working_days, 0);
        const totalPresentDays = monthlyData.reduce((sum, month) => sum + month.total_days, 0);
        const totalAbsentDays = totalWorkingDays - totalPresentDays;

        // Calculate average attendance rate
        const avgAttendanceRate = monthlyData.length > 0
            ? monthlyData.reduce((sum, month) => sum + month.attendance_rate, 0) / monthlyData.length
            : 0;

        performanceChartInstance = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Present Days', 'Absent Days'],
                datasets: [{
                    data: [totalPresentDays, totalAbsentDays],
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.8)',
                        'rgba(255, 99, 132, 0.8)'
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 99, 132, 1)'
                    ],
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: `Overall Attendance: ${avgAttendanceRate.toFixed(1)}%`,
                        font: {
                            size: 14,
                            weight: 'bold'
                        }
                    },
                    legend: {
                        display: true,
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                return `${label}: ${value} days (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    }
});

    // Fungsi untuk menampilkan SweetAlert2 untuk konfirmasi delete
    function confirmDelete(itemName, deleteUrl) {
        Swal.fire({
            title: 'Are you sure?',
            text: `You will delete ${itemName} attendance, deleted data cannot be restored.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Buat form tersembunyi dan kirim permintaan DELETE
                let form = document.createElement('form');
                form.action = deleteUrl;
                form.method = 'POST';
                form.style.display = 'none'; // Sembunyikan form

                // Tambahkan CSRF token untuk Laravel
                let csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = '<?php echo e(csrf_token()); ?>';
                form.appendChild(csrfInput);

                // Tambahkan method spoofing untuk DELETE request di Laravel
                let methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                form.appendChild(methodInput);

                document.body.appendChild(form);
                form.submit();
            }
        });
    }

    // Skrip untuk showAlert (jika Anda memiliki fungsi ini di layout utama)
    <?php if(session('error')): ?>
        window.addEventListener('load', function () {
            setTimeout(function() {
                if (typeof Swal === 'object' && typeof Swal.fire === 'function') { // Gunakan SweetAlert jika ada
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: <?php echo json_encode(session('error'), 15, 512) ?>
                    });
                } else if (typeof window.showAlert === 'function') { // Fallback ke showAlert jika ada
                    window.showAlert('Error', <?php echo json_encode(session('error'), 15, 512) ?>, 'error');
                } else { // Fallback ke alert bawaan browser
                    alert(<?php echo json_encode(session('error'), 15, 512) ?>);
                }
            }, 100);
        });
    <?php endif; ?>

    // Optional: Jika Anda ingin menggunakan SweetAlert untuk pesan success/info/warning dari session

    <?php if(session('status')): ?>
        window.addEventListener('load', function () {
            setTimeout(function() {
                if (typeof Swal === 'object' && typeof Swal.fire === 'function') {
                    Swal.fire({
                        icon: 'info', // Atau 'success' tergantung jenis 'status'
                        title: 'Informasi',
                        text: <?php echo json_encode(session('status'), 15, 512) ?>
                    });
                } else if (typeof window.showAlert === 'function') {
                    window.showAlert('Info', <?php echo json_encode(session('status'), 15, 512) ?>, 'info');
                } else {
                    alert(<?php echo json_encode(session('status'), 15, 512) ?>);
                }
            }, 100);
        });
    <?php endif; ?>
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Gitlab\backoffice-fasya\resources\views/attendance/index.blade.php ENDPATH**/ ?>