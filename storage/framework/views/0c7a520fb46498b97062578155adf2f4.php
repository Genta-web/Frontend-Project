<?php $__env->startSection('title', 'Reports Dashboard'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* Professional Reports Dashboard Styling - Sky Blue & White Theme */
.reports-dashboard {

    min-height: 100vh;
    padding: 2rem 0;
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

.comprehensive-btn {
    background: linear-gradient(135deg, #29b6f6 0%, #03a9f4 50%, #0288d1 100%);
    border: none;
    border-radius: 50px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(3, 169, 244, 0.4);
    color: white;
}

.comprehensive-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(3, 169, 244, 0.5);
    background: linear-gradient(135deg, #0288d1 0%, #03a9f4 50%, #29b6f6 100%);
    color: white;
}

/* Enhanced Statistics Cards */
.stat-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    position: relative;
    backdrop-filter: blur(10px);
    box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
    z-index: 1;
}

.stat-card .card-body {
    position: relative;
    z-index: 2;
    padding: 2rem;
}

.stat-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
}

.stat-card.attendance {
    background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%);
    color: white;
}

.stat-card.work-logs {
    background: linear-gradient(135deg, #29b6f6 0%, #039be5 100%);
    color: white;
}

.stat-card.jobs {
    background: linear-gradient(135deg, #4fc3f7 0%, #0277bd 100%);
    color: white;
}

.stat-card.leaves {
    background: linear-gradient(135deg, #81d4fa 0%, #0288d1 100%);
    color: white;
}

.stat-icon {
    font-size: 3rem;
    opacity: 0.8;
    transition: all 0.3s ease;
}

.stat-card:hover .stat-icon {
    opacity: 1;
    transform: scale(1.1) rotate(5deg);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 700;
    margin: 0.5rem 0;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.stat-label {
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    opacity: 0.9;
}

.stat-details {
    font-size: 0.85rem;
    opacity: 0.8;
    margin-top: 0.5rem;
}

/* Professional Report Cards */
.report-card {
    border: active;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    background: white;
    position: relative;
}

.report-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #03a9f4 0%, #0288d1 50%, #0277bd 100%);
    z-index: 1;
}

.report-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.report-card .card-header {
    background: linear-gradient(135deg, #ffffff 0%, #f8fcff 50%, #e3f2fd 100%);
    border-bottom: 2px solid #bbdefb;
    padding: 1.5rem;
    border-radius: 20px 20px 0 0;
}

.report-card .card-body {
    padding: 2rem;
}

.report-icon {
    font-size: 1.2rem;
    margin-right: 0.5rem;
}

.report-title {
    font-size: 1.1rem;
    font-weight: 700;
    margin: 0;
}

.report-description {
    color: #6c757d;
    font-size: 0.95rem;
    line-height: 1.6;
    margin-bottom: 1.5rem;
}

.report-btn {
    border-radius: 50px;
    padding: 0.75rem 1.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    border: none;
    position: relative;
    overflow: hidden;
}

.report-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.report-btn:hover::before {
    left: 100%;
}

.report-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

/* Enhanced Modals */
.modal-content {
    border: none;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    overflow: hidden;
}

.modal-header {
    background: linear-gradient(135deg, #03a9f4 0%, #0288d1 50%, #0277bd 100%);
    color: white;
    border-bottom: none;
    padding: 2rem;
}

.modal-title {
    font-size: 1.3rem;
    font-weight: 700;
}

.modal-body {
    padding: 2rem;
    background: #f8f9fa;
}

.modal-footer {
    background: white;
    border-top: 2px solid #e9ecef;
    padding: 1.5rem 2rem;
}

.form-label {
    font-weight: 600;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: #03a9f4;
    box-shadow: 0 0 0 0.2rem rgba(3, 169, 244, 0.25);
}

.btn-modal {
    border-radius: 50px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

/* Responsive Design */
@media (max-width: 768px) {
    .dashboard-title {
        font-size: 2rem;
    }

    .stat-card .card-body {
        padding: 1.5rem;
    }

    .stat-number {
        font-size: 2rem;
    }

    .report-card .card-body {
        padding: 1.5rem;
    }
}

/* Loading Animation */
/* .loading-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.9);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
}

.loading-overlay.show {
    opacity: 1;
    visibility: visible;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #e3f2fd;
    border-top: 4px solid #03a9f4;
    border-radius: 50%;
    animation: spin 1s linear infinite;
} */

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="reports-dashboard">
    <div class="container-fluid">

        <!-- Error Alert -->
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Error:</strong> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Success Alert -->
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Success:</strong> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <!-- Professional Dashboard Header -->
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="dashboard-title">
                        <i class="fas fa-chart-line me-3"></i>Reports Dashboard
                    </h1>
                    <p class="dashboard-subtitle">
                        Comprehensive analytics and insights for your organization
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="d-flex gap-2 justify-content-lg-end">
                        <button type="button" class="btn comprehensive-btn" data-bs-toggle="modal" data-bs-target="#comprehensiveReportModal">
                            <i class="fas fa-file-alt me-2"></i>Comprehensive Report
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Statistics Cards -->
        <div class="row mb-5">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card attendance h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <div class="stat-label">Attendance This Month</div>
                        <div class="stat-number"><?php echo e($stats['attendance']['total']); ?></div>
                        <div class="stat-details">
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-check-circle me-1"></i>Present: <?php echo e($stats['attendance']['present']); ?></span>
                                <span><i class="fas fa-times-circle me-1"></i>Absent: <?php echo e($stats['attendance']['absent']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card work-logs h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon">
                            <i class="fas fa-tasks"></i>
                        </div>
                        <div class="stat-label">Work Logs This Month</div>
                        <div class="stat-number"><?php echo e($stats['work_logs']['total']); ?></div>
                        <div class="stat-details">
                            <div class="d-flex justify-content-center">
                                <span><i class="fas fa-check-double me-1"></i>Completed: <?php echo e($stats['work_logs']['completed']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card jobs h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon">
                            <i class="fas fa-briefcase"></i>
                        </div>
                        <div class="stat-label">Jobs This Month</div>
                        <div class="stat-number"><?php echo e($stats['jobs']['total']); ?></div>
                        <div class="stat-details">
                            <div class="d-flex justify-content-center">
                                <span><i class="fas fa-trophy me-1"></i>Completed: <?php echo e($stats['jobs']['completed']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stat-card leaves h-100">
                    <div class="card-body text-center">
                        <div class="stat-icon">
                            <i class="fas fa-user-clock"></i>
                        </div>
                        <div class="stat-label">Leaves This Month</div>
                        <div class="stat-number"><?php echo e($stats['leaves']['total']); ?></div>
                        <div class="stat-details">
                            <div class="d-flex justify-content-between">
                                <span><i class="fas fa-thumbs-up me-1"></i>Approved: <?php echo e($stats['leaves']['approved']); ?></span>
                                <span><i class="fas fa-clock me-1"></i>Pending: <?php echo e($stats['leaves']['pending']); ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Professional Report Types -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card report-card h-100">
            <div class="card-header">
                <h6 class="report-title" style="color: #03a9f4;">
                    <i class="fas fa-calendar-check report-icon"></i>Attendance Reports
                </h6>
            </div>
            <div class="card-body d-flex flex-column">
                <p class="report-description">
                    Generate comprehensive attendance reports with advanced filtering options.
                    Track employee presence, absence patterns, and attendance trends over time.
                </p>
                <button type="button" class="btn btn-primary report-btn mt-auto" data-bs-toggle="modal"
                    data-bs-target="#attendanceReportModal"
                    style="background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%); border: none;">
                    <i class="fas fa-chart-bar me-2"></i>Generate Report
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card report-card h-100">
            <div class="card-header">
                <h6 class="report-title" style="color: #03a9f4;">
                    <i class="fas fa-tasks report-icon"></i>Work Logs Reports
                </h6>
            </div>
            <div class="card-body d-flex flex-column">
                <p class="report-description">
                    Analyze detailed work logs, hours worked, and task completion rates.
                    Monitor productivity trends and identify optimization opportunities.
                </p>
                <button type="button" class="btn btn-success report-btn mt-auto" data-bs-toggle="modal"
                    data-bs-target="#workLogsReportModal"
                    style="background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%); border: none;">
                    <i class="fas fa-chart-line me-2"></i>Generate Report
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card report-card h-100">
            <div class="card-header">
                <h6 class="report-title" style="color: #03a9f4;">
                    <i class="fas fa-briefcase report-icon"></i>Jobs Reports
                </h6>
            </div>
            <div class="card-body d-flex flex-column">
                <p class="report-description">
                    Track job progress, completion rates, and performance metrics.
                    Analyze job distribution, deadlines, and resource allocation efficiency.
                </p>
                <button type="button" class="btn btn-warning report-btn mt-auto" data-bs-toggle="modal"
                    data-bs-target="#jobsReportModal"
                    style="background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%); border: none; color: #fff;">
                    <i class="fas fa-chart-pie me-2"></i>Generate Report
                </button>
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-4">
        <div class="card report-card h-100">
            <div class="card-header">
                <h6 class="report-title" style="color: #03a9f4;">
                    <i class="fas fa-user-clock report-icon"></i>Leaves Reports
                </h6>
            </div>
            <div class="card-body d-flex flex-column">
                <p class="report-description">
                    Monitor leave applications, approvals, and leave balances.
                    Track leave patterns, seasonal trends, and team availability planning.
                </p>
                <button type="button" class="btn btn-info report-btn mt-auto" data-bs-toggle="modal"
                    data-bs-target="#leavesReportModal"
                    style="background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%); border: none; color: #fff;">
                    <i class="fas fa-chart-area me-2"></i>Generate Report
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Professional Comprehensive Report Modal -->
<div class="modal fade" id="comprehensiveReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-file-alt me-2"></i>Generate Comprehensive Report
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('reports.comprehensive')); ?>" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="comp_start_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="comp_start_date" name="start_date"
                                       value="<?php echo e(date('Y-m-01')); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="comp_end_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="comp_end_date" name="end_date"
                                       value="<?php echo e(date('Y-m-t')); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="comp_employee_id" class="form-label">
                            <i class="fas fa-user me-1"></i>Employee (Optional)
                        </label>
                        <select class="form-select" id="comp_employee_id" name="employee_id">
                            <option value="">All Employees</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->name); ?> (<?php echo e($employee->employee_code); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="comp_format" class="form-label">
                            <i class="fas fa-file-export me-1"></i>Format <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="comp_format" name="format" required>
                            <option value="web">📊 View in Browser</option>
                            <option value="pdf">📄 Download PDF</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modal" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary btn-modal" style="background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%); border: none; color: #fff; ">
                        <i class="fas fa-chart-line me-1"></i>Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Professional Attendance Report Modal -->
<div class="modal fade" id="attendanceReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-calendar-check me-2"></i>Generate Attendance Report
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('reports.attendance')); ?>" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="att_start_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="att_start_date" name="start_date"
                                       value="<?php echo e(date('Y-m-01')); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="att_end_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="att_end_date" name="end_date"
                                       value="<?php echo e(date('Y-m-t')); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="att_employee_id" class="form-label">
                            <i class="fas fa-user me-1"></i>Employee (Optional)
                        </label>
                        <select class="form-select" id="att_employee_id" name="employee_id">
                            <option value="">All Employees</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->name); ?> (<?php echo e($employee->employee_code); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="att_format" class="form-label">
                            <i class="fas fa-file-export me-1"></i>Format <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="att_format" name="format" required>
                            <option value="web">📊 View in Browser</option>
                            <option value="pdf">📄 Download PDF</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modal" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary btn-modal" style="background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%); border: none;">
                        <i class="fas fa-chart-bar me-1"></i>Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Professional Work Logs Report Modal -->
<div class="modal fade" id="workLogsReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-tasks me-2"></i>Generate Work Logs Report
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('reports.work-logs')); ?>" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="wl_start_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="wl_start_date" name="start_date"
                                       value="<?php echo e(date('Y-m-01')); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="wl_end_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="wl_end_date" name="end_date"
                                       value="<?php echo e(date('Y-m-t')); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="wl_employee_id" class="form-label">
                            <i class="fas fa-user me-1"></i>Employee (Optional)
                        </label>
                        <select class="form-select" id="wl_employee_id" name="employee_id">
                            <option value="">All Employees</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->name); ?> (<?php echo e($employee->employee_code); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="wl_format" class="form-label">
                            <i class="fas fa-file-export me-1"></i>Format <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="wl_format" name="format" required>
                            <option value="web">📊 View in Browser</option>
                            <option value="pdf">📄 Download PDF</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modal" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success btn-modal" style="background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%); border: none;">
                        <i class="fas fa-chart-line me-1"></i>Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Professional Jobs Report Modal -->
<div class="modal fade" id="jobsReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-briefcase me-2"></i>Generate Jobs Report
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('reports.jobs')); ?>" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="job_start_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="job_start_date" name="start_date"
                                       value="<?php echo e(date('Y-m-01')); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="job_end_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="job_end_date" name="end_date"
                                       value="<?php echo e(date('Y-m-t')); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="job_employee_id" class="form-label">
                            <i class="fas fa-user me-1"></i>Employee (Optional)
                        </label>
                        <select class="form-select" id="job_employee_id" name="employee_id">
                            <option value="">All Employees</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->name); ?> (<?php echo e($employee->employee_code); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="job_format" class="form-label">
                            <i class="fas fa-file-export me-1"></i>Format <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="job_format" name="format" required>
                            <option value="web">📊 View in Browser</option>
                            <option value="pdf">📄 Download PDF</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modal" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-warning btn-modal" style="background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%); border: none; color: #fff;">
                        <i class="fas fa-chart-pie me-1"></i>Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Professional Leaves Report Modal -->
<div class="modal fade" id="leavesReportModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-clock me-2"></i>Generate Leaves Report
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('reports.leaves')); ?>" method="GET">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="leave_start_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="leave_start_date" name="start_date"
                                       value="<?php echo e(date('Y-m-01')); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="leave_end_date" class="form-label">
                                    <i class="fas fa-calendar-alt me-1"></i>End Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control" id="leave_end_date" name="end_date"
                                       value="<?php echo e(date('Y-m-t')); ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="leave_employee_id" class="form-label">
                            <i class="fas fa-user me-1"></i>Employee (Optional)
                        </label>
                        <select class="form-select" id="leave_employee_id" name="employee_id">
                            <option value="">All Employees</option>
                            <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->name); ?> (<?php echo e($employee->employee_code); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="leave_format" class="form-label">
                            <i class="fas fa-file-export me-1"></i>Format <span class="text-danger">*</span>
                        </label>
                        <select class="form-select" id="leave_format" name="format" required>
                            <option value="web">📊 View in Browser</option>
                            <option value="pdf">📄 Download PDF</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-modal" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-info btn-modal" style="background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%); border: none; color: #fff;">
                        <i class="fas fa-chart-area me-1"></i>Generate Report
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner"></div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Professional loading and animations
    initializeReportsDashboard();

    // Set minimum date for end date inputs
    const startDateInputs = document.querySelectorAll('input[name="start_date"]');
    const endDateInputs = document.querySelectorAll('input[name="end_date"]');

    startDateInputs.forEach((startInput, index) => {
        startInput.addEventListener('change', function() {
            if (endDateInputs[index]) {
                endDateInputs[index].min = this.value;
            }
        });
    });

    // Enhanced form submission with loading and error handling
    const reportForms = document.querySelectorAll('form[action*="reports"]');
    reportForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Show loading state
            // showLoading();
            // submitBtn.disabled = true;
            // submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Generating...';

            // Set timeout for large reports
            const timeout = setTimeout(() => {
                hideLoading();
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
                showNotification('Report generation is taking longer than expected. Please wait...', 'warning');
            }, 30000); // 30 seconds

            // Clear timeout when page unloads (report completed)
            window.addEventListener('beforeunload', () => {
                clearTimeout(timeout);
            });
        });
    });

    // Professional modal animations
    const modals = document.querySelectorAll('.modal');
    modals.forEach(modal => {
        modal.addEventListener('show.bs.modal', function() {
            this.querySelector('.modal-dialog').style.transform = 'scale(0.8)';
            this.querySelector('.modal-dialog').style.opacity = '0';

            setTimeout(() => {
                this.querySelector('.modal-dialog').style.transition = 'all 0.3s ease';
                this.querySelector('.modal-dialog').style.transform = 'scale(1)';
                this.querySelector('.modal-dialog').style.opacity = '1';
            }, 50);
        });
    });

    // Animate statistics cards on load
    animateStatsCards();

    // Animate report cards on scroll
    observeReportCards();
});

function initializeReportsDashboard() {
    // Add entrance animations to elements
    const dashboardHeader = document.querySelector('.dashboard-header');
    const statCards = document.querySelectorAll('.stat-card');
    const reportCards = document.querySelectorAll('.report-card');

    // Animate header
    if (dashboardHeader) {
        dashboardHeader.style.opacity = '0';
        dashboardHeader.style.transform = 'translateY(-30px)';

        setTimeout(() => {
            dashboardHeader.style.transition = 'all 0.8s ease';
            dashboardHeader.style.opacity = '1';
            dashboardHeader.style.transform = 'translateY(0)';
        }, 100);
    }

    // Animate stat cards with stagger
    statCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';

        setTimeout(() => {
            card.style.transition = 'all 0.6s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, 300 + (index * 100));
    });
}

function animateStatsCards() {
    const statNumbers = document.querySelectorAll('.stat-number');

    statNumbers.forEach(numberElement => {
        const finalNumber = parseInt(numberElement.textContent);
        let currentNumber = 0;
        const increment = Math.ceil(finalNumber / 30);

        const timer = setInterval(() => {
            currentNumber += increment;
            if (currentNumber >= finalNumber) {
                currentNumber = finalNumber;
                clearInterval(timer);
            }
            numberElement.textContent = currentNumber;
        }, 50);
    });
}

function observeReportCards() {
    const reportCards = document.querySelectorAll('.report-card');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
            }
        });
    }, { threshold: 0.1 });

    reportCards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = 'all 0.6s ease';
        observer.observe(card);
    });
}

function showLoading() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.classList.add('show');
    }
}

function hideLoading() {
    const loadingOverlay = document.getElementById('loadingOverlay');
    if (loadingOverlay) {
        loadingOverlay.classList.remove('show');
    }
}

// Hide loading when page loads
window.addEventListener('load', function() {
    hideLoading();
});

// Professional hover effects for buttons
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.report-btn, .comprehensive-btn');

    buttons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Clear reports cache function
function clearReportsCache() {
    const btn = event.target.closest('button');
    const originalContent = btn.innerHTML;

    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Clearing...';

    fetch('<?php echo e(route("reports.clear-cache")); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Cache cleared successfully! Reports will load with fresh data.', 'success');
            // Reload the page to show fresh statistics
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showNotification('Failed to clear cache. Please try again.', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while clearing cache.', 'error');
    })
    .finally(() => {
        btn.disabled = false;
        btn.innerHTML = originalContent;
    });
}

// Notification system
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.custom-notification');
    existingNotifications.forEach(notification => notification.remove());

    const notification = document.createElement('div');
    notification.className = `custom-notification alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 10000;
        min-width: 300px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        border-radius: 8px;
    `;

    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'warning' ? 'exclamation-triangle' : type === 'error' ? 'times-circle' : 'info-circle'} me-2"></i>
            <span>${message}</span>
        </div>
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;

    document.body.appendChild(notification);

    // Auto remove after 5 seconds
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Performance monitoring
function monitorReportPerformance() {
    const startTime = performance.now();

    window.addEventListener('load', () => {
        const loadTime = performance.now() - startTime;
        console.log(`Reports dashboard loaded in ${loadTime.toFixed(2)}ms`);

        // Show performance indicator for slow loads
        if (loadTime > 3000) {
            showNotification('Dashboard loaded slowly. Consider clearing cache for better performance.', 'warning');
        }
    });
}

// Initialize performance monitoring
monitorReportPerformance();
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Integrasi KP\backoffice-fasya\resources\views/reports/index.blade.php ENDPATH**/ ?>