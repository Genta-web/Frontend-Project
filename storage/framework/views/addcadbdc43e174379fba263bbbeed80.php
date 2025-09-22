<?php $__env->startSection('title', 'Work Logs'); ?>


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
    background-color: rgba(0, 0, 0, 0.6); /* Sedikit lebih gelap untuk fokus */
    display: none; /* Diubah dari flex ke none, dikontrol oleh JS */
    justify-content: center;
    align-items: center;
    z-index: 1050; /* Pastikan di atas elemen lain */
    padding: 20px;
    box-sizing: border-box;
}

.popup-card {
    background: white;
    padding: 2.5rem;
    border-radius: 1.5rem; /* Sudut lebih bulat */
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 420px; /* Sedikit lebih lebar */
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

/*delete */
.popup-icon-warning {
    width: 80px;
    height: 80px;
    margin: 0 auto 1.5rem auto;
    background-color: #FEE2E2; /* Merah muda */
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-icon-warning svg {
    width: 40px;
    height: 40px;
    color: #B91C1C; /* Merah tua */
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

/* Style untuk grup tombol (delete) */
.popup-button-group {
    display: flex;
    gap: 1rem;
    margin-top: 2rem;
}
.popup-button-secondary, .popup-button-danger {
    flex: 1;
    padding: 0.8rem 1rem;
    border: none;
    border-radius: 0.75rem;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}
.popup-button-secondary {
    background-color: #E5E7EB;
    color: #374151;
}
.popup-button-secondary:hover {
    background-color: #D1D5DB;
}
.popup-button-danger {
    background-color: #DC2626;
    color: white;
}
.popup-button-danger:hover {
    background-color: #B91C1C;
}
</style>

<?php $__env->startPush('styles'); ?>
<style>
    /* Work Logs Page Styles */
    .work-logs-container {
        padding: 1.5rem;
        background-color: #f8f9fa;
        min-height: calc(100vh - 120px);
    }

    .page-header-card {
        background: linear-gradient(135deg, #03a9f4 0%, #0288d1 50%, #0277bd 100%);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(3, 169, 244, 0.4);
        position: relative;
        overflow: hidden;
    }

    .page-header-card::before {
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

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .btn-clean {
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

    .btn-clean:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(3, 169, 244, 0.5);
        background: linear-gradient(135deg, #0288d1 0%, #03a9f4 50%, #29b6f6 100%);
        color: white;
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
    .stat-icon-simple.success { background-color: #28a745; }
    .stat-icon-simple.warning { background-color: #ffc107; }
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

    /* Modal Improvements */
    .modal-content {
        border-radius: 10px;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        border-radius: 10px 10px 0 0;
    }

    .modal-title {
        font-weight: 600;
        color: #2c3e50;
    }

    .modal-body {
        padding: 2rem;
    }

    .modal-footer {
        background-color: #f8f9fa;
        border-top: 1px solid #e9ecef;
        border-radius: 0 0 10px 10px;
    }

    /* Form Improvements */
    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
    }

    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Status Display */
    .status-display {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        text-align: center;
        display: inline-block;
    }

    .status-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeaa7;
    }

    .status-in-progress {
        background-color: #cce5ff;
        color: #004085;
        border: 1px solid #99d6ff;
    }

    .status-done {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    /* Live Time Display */
    .live-time-display {
        background: linear-gradient(45deg, #28a745, #20c997);
        color: white;
        padding: 0.75rem 1rem;
        border-radius: 8px;
        text-align: center;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .live-indicator {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        font-size: 0.875rem;
    }

    .live-indicator .fas {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }

    /* Image Preview */
    .image-preview {
        max-width: 100%;
        max-height: 300px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    /* Button Improvements */
    .btn-group .btn {
        margin-right: 0.25rem;
    }

    .btn-group .btn:last-child {
        margin-right: 0;
    }
</style>
<?php $__env->stopPush(); ?>


<?php $__env->startSection('content'); ?>
<div class="work-logs-container">
    <!-- Page Header -->
        <div class="page-header-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">
                        <i class="fas fa-tasks me-2" style="color: #fff;"></i>Work Logs
                    </h1>
                    <p class="page-subtitle">
                        Track and manage daily work activities
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo e(route('worklogs.create')); ?>" class="btn-clean primary" style="border-radius: 50px;">
                        <i class="fas fa-plus"></i>
                        Add Work Log
                    </a>
                </div>
            </div>
        </div>

    <!-- Statistics Cards -->
    <div class="stats-container">
        <div class="stat-card-simple primary">
            <div class="stat-content-simple">
                <div class="stat-icon-simple primary">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-info-simple">
                    <h3><?php echo e($stats['total_logs']); ?></h3>
                    <p>Total Logs</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple success">
            <div class="stat-content-simple">
                <div class="stat-icon-simple success">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stat-info-simple">
                    <h3><?php echo e($stats['logs_today']); ?></h3>
                    <p>Today</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple info">
            <div class="stat-content-simple">
                <div class="stat-icon-simple info">
                    <i class="fas fa-calendar-week"></i>
                </div>
                <div class="stat-info-simple">
                    <h3><?php echo e($stats['logs_this_week']); ?></h3>
                    <p>This Week</p>
                </div>
            </div>
        </div>

        <div class="stat-card-simple warning">
            <div class="stat-content-simple">
                <div class="stat-icon-simple warning">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <div class="stat-info-simple">
                    <h3><?php echo e($stats['logs_this_month']); ?></h3>
                    <p>This Month</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Add Form for Employees -->
    <?php if(Auth::user()->hasRole('employee')): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-plus me-2"></i>Quick Add Work Log
            </h6>
        </div>
        <div class="card-body">
            <form action="<?php echo e(route('worklogs.quickadd')); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-md-2">
                        <label for="work_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="work_date" name="work_date"
                               value="<?php echo e(date('Y-m-d')); ?>" max="<?php echo e(date('Y-m-d')); ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="time" class="form-control" id="start_time" name="start_time" required>
                    </div>
                    <div class="col-md-2">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="time" class="form-control" id="end_time" name="end_time" required>
                    </div>
                    <div class="col-md-4">
                        <label for="task_summary" class="form-label">Task Summary</label>
                        <input type="text" class="form-control" id="task_summary" name="task_summary"
                               placeholder="Brief description of work done..." maxlength="500" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-plus me-1"></i> Add
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Filters -->
    <?php if(!Auth::user()->hasRole('employee')): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-filter me-2"></i>Filters
            </h6>
        </div>
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('worklogs.index')); ?>">
                <div class="row">
                    <div class="col-md-4">
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
                        <label for="date_from" class="form-label">From Date</label>
                        <input type="date" class="form-control" id="date_from" name="date_from"
                               value="<?php echo e(request('date_from')); ?>">
                    </div>
                    <div class="col-md-3">
                        <label for="date_to" class="form-label">To Date</label>
                        <input type="date" class="form-control" id="date_to" name="date_to"
                               value="<?php echo e(request('date_to')); ?>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-12">
                        <a href="<?php echo e(route('worklogs.index')); ?>" class="btn btn-secondary btn-sm">
                            <i class="fas fa-undo me-1"></i> Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <!-- Work Logs Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-table me-2"></i>Work Logs
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <?php if(!Auth::user()->hasRole('employee')): ?>
                                <th>Employee</th>
                            <?php endif; ?>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                            <th>Task Summary</th>
                            <th>Attachment</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $workLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $workLog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                <td><?php echo e($workLogs->firstItem() + $index); ?></td>
                                <?php if(!Auth::user()->hasRole('employee')): ?>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar me-2">
                                                <i class="fas fa-user-circle text-secondary" style="font-size: 1.5rem;"></i>
                                            </div>
                                            <div>
                                                <strong><?php echo e($workLog->employee->name ?? 'N/A'); ?></strong><br>
                                                <small class="text-muted"><?php echo e($workLog->employee->employee_code ?? 'N/A'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif; ?>
                                <td><?php echo e($workLog->work_date ? $workLog->work_date->format('d M Y') : 'N/A'); ?></td>
                                <td>
                                    <small>
                                        <strong>Start:</strong> <?php echo e($workLog->start_time ? \Carbon\Carbon::parse($workLog->start_time)->format('H:i') : '-'); ?><br>
                                        <strong>End:</strong> <?php echo e($workLog->end_time ? \Carbon\Carbon::parse($workLog->end_time)->format('H:i') : '-'); ?>

                                    </small>
                                </td>
                                <td>
                                    <span class="badge <?php echo e($workLog->status_badge_class); ?>">
                                        <?php echo e($workLog->status_display); ?>

                                    </span>
                                    <?php if($workLog->status_updated_at): ?>
                                        <br><small class="text-muted">
                                            Updated: <?php echo e($workLog->status_updated_at->format('d/m H:i')); ?>

                                        </small>
                                    <?php endif; ?>
                                    <?php if($workLog->status_update_image): ?>
                                        <br><small class="text-info">
                                            <i class="fas fa-image"></i> Has image
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span title="<?php echo e($workLog->task_summary); ?>">
                                        <?php echo e(Str::limit($workLog->task_summary, 50)); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($workLog->attachment_image): ?>
                                        <a href="<?php echo e(asset('uploads/worklogs/' . $workLog->attachment_image)); ?>"
                                           target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-image"></i>
                                        </a>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-info"
                                                onclick="showDetailModal(<?php echo e($workLog->id); ?>, '<?php echo e($workLog->employee->name ?? 'N/A'); ?>', '<?php echo e($workLog->work_date ? $workLog->work_date->format('d M Y') : 'N/A'); ?>', '<?php echo e(addslashes($workLog->task_summary)); ?>', '<?php echo e(addslashes($workLog->action_details ?? '')); ?>', '<?php echo e($workLog->status_display); ?>', '<?php echo e($workLog->status_update_image ?? ''); ?>', '<?php echo e($workLog->status_updated_at ? $workLog->status_updated_at->format('d M Y H:i:s') : ''); ?>')"
                                                title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <?php if(Auth::user()->hasRole(['admin', 'hr', 'manager']) || $workLog->employee_id == Auth::user()->employee?->id): ?>
                                            <?php if(!$workLog->isDone()): ?>
                                                <button type="button" class="btn btn-sm btn-outline-success"
                                                        onclick="showUpdateStatusModal(<?php echo e($workLog->id); ?>, '<?php echo e($workLog->status); ?>', '<?php echo e($workLog->action_details ?? ''); ?>')"
                                                        title="Update Status">
                                                    <i class="fas fa-sync"></i>
                                                </button>
                                            <?php endif; ?>


                                            <button type="button" class="btn btn-sm btn-outline-danger"
                                                    onclick="showDeleteConfirmation('<?php echo e($workLog->employee->name ?? 'Work Log'); ?> - <?php echo e($workLog->work_date ? $workLog->work_date->format('d M Y') : 'N/A'); ?>', '<?php echo e(route('worklogs.destroy', $workLog)); ?>')"
                                                    title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e(Auth::user()->hasRole('employee') ? '7' : '8'); ?>" class="text-center py-4">
                                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No work logs found</h5>
                                    <p class="text-muted">Start by adding your daily work activities</p>
                                    <a href="<?php echo e(route('worklogs.create')); ?>" class="btn btn-primary">
                                        <i class="fas fa-plus me-1"></i> Add Work Log
                                    </a>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <?php if($workLogs->hasPages()): ?>
                <div class="d-flex justify-content-center">
                    <?php echo e($workLogs->appends(request()->query())->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Detail Modal -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Work Log Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Employee:</strong>
                        <p id="detail-employee" class="text-muted"></p>
                    </div>
                    <div class="col-md-6">
                        <strong>Date:</strong>
                        <p id="detail-date" class="text-muted"></p>
                    </div>
                </div>
                <div class="mb-3">
                    <strong>Status:</strong>
                    <p><span id="detail-status" class="badge"></span></p>
                </div>
                <div class="mb-3">
                    <strong>Task Summary:</strong>
                    <p id="detail-task" class="text-muted"></p>
                </div>
                <div class="mb-3">
                    <strong>Action Details:</strong>
                    <p id="detail-action" class="text-muted"></p>
                </div>
                <div class="mb-3">
                    <strong>Status Update Image:</strong>
                    <div id="detail-status-image"></div>
                </div>
                <div class="mb-3">
                    <strong>Last Status Update:</strong>
                    <p id="detail-status-time" class="text-muted"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Status Modal -->
<div class="modal fade" id="updateStatusModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-sync me-2 text-primary"></i>
                    Update Work Log Status
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="updateStatusForm" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PATCH'); ?>
                <div class="modal-body">
                    <!-- Live Time Display -->
                    <div class="live-time-display">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <strong>Current Time:</strong>
                                <span id="current-time">Loading...</span>
                            </div>
                            <div class="live-indicator">
                                <i class="fas fa-circle"></i>
                                Live
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    <i class="fas fa-tasks me-1"></i>
                                    Status <span class="text-danger">*</span>
                                </label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="ongoing">📋 Ongoing</option>
                                    <option value="in_progress">⚡ In Progress</option>
                                    <option value="done">✅ Done</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status_update_image" class="form-label">
                                    <i class="fas fa-camera me-1"></i>
                                    Progress Image
                                </label>
                                <input type="file" class="form-control" id="status_update_image" name="status_update_image"
                                       accept="image/*" onchange="previewImage(this)">
                                <div class="form-text">
                                    <small>Optional. Upload screenshot or photo (Max 2MB)</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="action_details" class="form-label">
                            <i class="fas fa-edit me-1"></i>
                            Action Details
                        </label>
                        <textarea class="form-control" id="action_details" name="action_details" rows="4"
                                  placeholder="Describe what actions were taken or what needs to be done..."></textarea>
                        <div class="form-text">
                            <small>Optional. Provide detailed information about your progress (Max 1000 characters).</small>
                        </div>
                    </div>

                    <!-- Image Preview -->
                    <div id="imagePreview" style="display: none;">
                        <label class="form-label">
                            <i class="fas fa-eye me-1"></i>
                            Image Preview
                        </label>
                        <div class="text-center">
                            <img id="previewImg" class="image-preview" alt="Preview">
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removePreview()">
                                    <i class="fas fa-trash me-1"></i>Remove Image
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Update Status
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- HTML untuk Modal Konfirmasi Delete -->
<div class="popup-overlay" id="deleteConfirmOverlay">
    <div class="popup-card">
        <div class="popup-icon-warning">
            
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </div>
        <h2 class="popup-title">Are you sure?</h2>
        <p class="popup-message" id="deleteConfirmMessage">You are about to delete this item. This action cannot be undone.</p>
        <div class="popup-button-group">
            <button class="popup-button-secondary" id="cancelDeleteButton">Cancel</button>
            <form id="deleteForm" method="POST" style="display: contents;">
                <?php echo csrf_field(); ?>
                <?php echo method_field('DELETE'); ?>
                <button type="submit" class="popup-button-danger">Delete</button>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const successPopup = document.getElementById('successPopup');
    if (successPopup) {
        successPopup.style.display = 'flex'; // Tampilkan jika ada
        const closeButton = document.getElementById('closePopup');
        const closePopupFunc = () => { successPopup.style.display = 'none'; };
        closeButton.addEventListener('click', closePopupFunc);
        successPopup.addEventListener('click', (e) => {
            if (e.target === successPopup) closePopupFunc();
        });
    }

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

function showDeleteConfirmation(itemName, deleteUrl) {
    // Dapatkan elemen-elemen modal
    const overlay = document.getElementById('deleteConfirmOverlay');
    const messageEl = document.getElementById('deleteConfirmMessage');
    const formEl = document.getElementById('deleteForm');
    const cancelButton = document.getElementById('cancelDeleteButton');

    // Atur konten modal
    messageEl.innerHTML = `You are about to permanently delete:<br><strong>"${itemName}"</strong><br>This action cannot be undone.`;
    formEl.action = deleteUrl;

    // Tampilkan modal
    overlay.style.display = 'flex';

    // Fungsi untuk menyembunyikan modal
    const hideModal = () => {
        overlay.style.display = 'none';
    };

    // Tambahkan event listener untuk tombol cancel dan area luar
    cancelButton.onclick = hideModal;
    overlay.onclick = (event) => {
        if (event.target === overlay) {
            hideModal();
        }
    };
}

function showDetailModal(id, employee, date, taskSummary, actionDetails, status, statusUpdateImage, statusUpdatedAt) {
    document.getElementById('detail-employee').textContent = employee;
    document.getElementById('detail-date').textContent = date;
    document.getElementById('detail-task').textContent = taskSummary;
    document.getElementById('detail-action').textContent = actionDetails || 'No action details provided';

    const statusBadge = document.getElementById('detail-status');
    statusBadge.textContent = status;
    statusBadge.className = 'badge ' + getStatusBadgeClass(status);

    // Handle status update image
    const statusImageDiv = document.getElementById('detail-status-image');
    if (statusUpdateImage) {
        statusImageDiv.innerHTML = `
            <a href="/uploads/worklogs/status/${statusUpdateImage}" target="_blank" class="btn btn-sm btn-outline-info">
                <i class="fas fa-image me-1"></i> View Status Image
            </a>
        `;
    } else {
        statusImageDiv.innerHTML = '<span class="text-muted">No status update image</span>';
    }

    // Handle status update time
    const statusTimeP = document.getElementById('detail-status-time');
    if (statusUpdatedAt) {
        statusTimeP.textContent = statusUpdatedAt;
    } else {
        statusTimeP.textContent = 'No status update time recorded';
    }

    const modal = new bootstrap.Modal(document.getElementById('detailModal'));
    modal.show();
}

function showUpdateStatusModal(id, currentStatus, actionDetails) {
    const form = document.getElementById('updateStatusForm');
    form.action = `/worklogs/${id}/status`;

    document.getElementById('status').value = currentStatus;
    document.getElementById('action_details').value = actionDetails || '';

    // Clear previous file input
    document.getElementById('status_update_image').value = '';
    removePreview(); // Hapus juga preview jika ada

    const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
    modal.show();
}

function getStatusBadgeClass(status) {
    switch(status.toLowerCase()) {
        case 'ongoing': return 'bg-warning text-dark';
        case 'in progress': return 'bg-info text-dark';
        case 'done': return 'bg-success';
        default: return 'bg-secondary';
    }
}

// Image preview function
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');

    if (input.files && input.files[0]) {
        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };

        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

// Remove image preview
function removePreview() {
    const preview = document.getElementById('imagePreview');
    const fileInput = document.getElementById('status_update_image');

    preview.style.display = 'none';
    fileInput.value = '';
}

document.addEventListener('DOMContentLoaded', function() {
    // Validate end time is after start time
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');

    if (startTimeInput && endTimeInput) {
        endTimeInput.addEventListener('change', function() {
            const startTime = startTimeInput.value;
            const endTime = this.value;

            if (startTime && endTime && endTime <= startTime) {
                alert('End time must be after start time');
                this.value = '';
            }
        });
    }

    // Live time clock for update modal
    const updateStatusModalEl = document.getElementById('updateStatusModal');
    let timeInterval;

    if (updateStatusModalEl) {
        const currentTimeEl = document.getElementById('current-time');
        const updateCurrentTime = () => {
            if(currentTimeEl) {
                currentTimeEl.textContent = new Date().toLocaleString('id-ID', { dateStyle: 'medium', timeStyle: 'medium' });
            }
        };

        updateStatusModalEl.addEventListener('shown.bs.modal', function() {
            if (!timeInterval) {
                timeInterval = setInterval(updateCurrentTime, 1000);
            }
        });

        updateStatusModalEl.addEventListener('hidden.bs.modal', function() {
            if (timeInterval) {
                clearInterval(timeInterval);
                timeInterval = null;
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backoffice-fasya\resources\views/worklogs/index.blade.php ENDPATH**/ ?>