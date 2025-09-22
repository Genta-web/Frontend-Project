<?php $__env->startSection('title', 'Work Logs Report'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.status-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}
.status-done { background-color: #d4edda; color: #155724; }
.status-ongoing { background-color: #fff3cd; color: #856404; }
.status-in_progress { background-color: #cce7ff; color: #004085; }
.report-header {
    background: linear-gradient(135deg, #03a9f4 0%, #0288d1 50%, #0277bd 100%);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(3, 169, 244, 0.4);
    position: relative;
    overflow: hidden;
}

.report-header::before {
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

/* CSS untuk Kartu Statistik */
.stats-card {
    background-color: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border-left: 5px solid;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
}

.stats-info h3 {
    font-size: 2.25rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
}

.stats-info p {
    font-size: 1rem;
    color: #6c757d;
    margin: 0;
}

/* Variasi Warna Kartu */
.stats-card.total-logs { border-color: #0d6efd; }
.stats-card.total-logs .stats-icon { background-color: #0d6efd; }
.stats-card.total-logs .stats-info h3 { color: #0d6efd; }

.stats-card.total-hours { border-color: #0dcaf0; }
.stats-card.total-hours .stats-icon { background-color: #0dcaf0; }
.stats-card.total-hours .stats-info h3 { color: #0dcaf0; }

.stats-card.completed { border-color: #198754; }
.stats-card.completed .stats-icon { background-color: #198754; }
.stats-card.completed .stats-info h3 { color: #198754; }

.stats-card.ongoing { border-color: #ffc107; }
.stats-card.ongoing .stats-icon { background-color: #ffc107; }
.stats-card.ongoing .stats-info h3 { color: #ffc107; }

.stats-card.in-progress { border-color: #0d6efd; }
.stats-card.in-progress .stats-icon { background-color: #0d6efd; }
.stats-card.in-progress .stats-info h3 { color: #0d6efd; }

.stats-card.days-worked { border-color: #6c757d; }
.stats-card.days-worked .stats-icon { background-color: #6c757d; }
.stats-card.days-worked .stats-info h3 { color: #6c757d; }

.summary-card {
    border-radius: 0.5rem;
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.hours-badge {
    background-color: #e3f2fd;
    color: #1976d2;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Report Header -->
    <div class="report-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="dashboard-title">
                    <i class="fas fa-tasks"></i> Work Logs Report
                </h1>
                <p class="dashboard-subtitle">
                    Period: <?php echo e($startDate->format('M d, Y')); ?> - <?php echo e($endDate->format('M d, Y')); ?>

                </p>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('reports.index')); ?>" class="btn comprehensive-btn">
                        <i class="fas fa-arrow-left me-2"></i> Back to Reports
                    </a>
                    <a href="<?php echo e(route('reports.attendance', array_merge(request()->all(), ['format' => 'pdf']))); ?>"
                       class="btn comprehensive-btn">
                        <i class="fas fa-file-pdf me-2"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card total-logs">
                <div class="stats-icon">
                    <i class="fas fa-list-alt"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e($summary['total_logs']); ?></h3>
                    <p>Total Logs</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card total-hours">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e(number_format($summary['total_hours'], 2)); ?></h3>
                    <p>Total Hours</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card completed">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e($summary['completed_tasks']); ?></h3>
                    <p>Completed</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card ongoing">
                <div class="stats-icon">
                    <i class="fas fa-spinner"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e($summary['ongoing_tasks']); ?></h3>
                    <p>Ongoing</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card in-progress">
                <div class="stats-icon">
                    <i class="fas fa-play"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e($summary['in_progress_tasks']); ?></h3>
                    <p>In Progress</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card days-worked">
                <div class="stats-icon">
                    <i class="fas fa-calendar-day"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e($summary['days_worked']); ?></h3>
                    <p>Days Worked</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Work Logs Data Table -->
    <div class="card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Work Log Records</h6>
        </div>
        <div class="card-body">
            <?php if($workLogs->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>Time</th>
                                <th>Duration</th>
                                <th>Task Summary</th>
                                <th>Status</th>
                                <th>Action Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $workLogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workLog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($workLog->work_date->format('M d, Y')); ?></td>
                                <td>
                                    <div class="fw-bold"><?php echo e($workLog->employee->name); ?></div>
                                    <small class="text-muted"><?php echo e($workLog->employee->employee_code); ?></small>
                                </td>
                                <td>
                                    <?php if($workLog->start_time && $workLog->end_time): ?>
                                        <div>
                                            <small class="text-success">Start: <?php echo e($workLog->start_time->format('H:i')); ?></small><br>
                                            <small class="text-danger">End: <?php echo e($workLog->end_time->format('H:i')); ?></small>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($workLog->start_time && $workLog->end_time): ?>
                                        <?php
                                            $start = \Carbon\Carbon::parse($workLog->start_time);
                                            $end = \Carbon\Carbon::parse($workLog->end_time);
                                            $duration = $end->diffInHours($start);
                                        ?>
                                        <span class="hours-badge"><?php echo e($duration); ?>h</span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="text-truncate" style="max-width: 200px;" title="<?php echo e($workLog->task_summary); ?>">
                                        <?php echo e($workLog->task_summary); ?>

                                    </div>
                                </td>
                                <td>
                                    <?php if($workLog->status): ?>
                                        <span class="status-badge status-<?php echo e($workLog->status); ?>">
                                            <?php echo e(ucfirst(str_replace('_', ' ', $workLog->status))); ?>

                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($workLog->action_details): ?>
                                        <div class="text-truncate" style="max-width: 150px;" title="<?php echo e($workLog->action_details); ?>">
                                            <?php echo e(Str::limit($workLog->action_details, 30)); ?>

                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No work logs found</h5>
                    <p class="text-muted">No work log data available for the selected period.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Additional Statistics -->
    <?php if($workLogs->count() > 0): ?>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Productivity Metrics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-12 mb-2">
                            <div class="h5 text-info"><?php echo e($summary['average_hours_per_day']); ?></div>
                            <div class="small text-muted">Avg Hours/Day</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Task Completion</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="h5 text-success">
                            <?php echo e($summary['total_logs'] > 0 ? number_format(($summary['completed_tasks'] / $summary['total_logs']) * 100, 1) : 0); ?>%
                        </div>
                        <div class="small text-muted">Completion Rate</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Employee Count</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="h5 text-warning"><?php echo e($workLogs->groupBy('employee_id')->count()); ?></div>
                        <div class="small text-muted">Active Employees</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add tooltips for truncated text
    const truncatedElements = document.querySelectorAll('.text-truncate[title]');
    truncatedElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            // Could add custom tooltip logic here
        });
    });

    // Handle PDF download links - prevent loading overlay
    const pdfDownloadLinks = document.querySelectorAll('a[href*="format=pdf"]');
    pdfDownloadLinks.forEach(link => {
        // Add event listener with high priority (capture phase)
        link.addEventListener('click', function(e) {
            // Prevent any loading overlay from showing
            e.stopPropagation();
            e.stopImmediatePropagation();

            // Hide any existing loading overlay immediately
            const loadingOverlay = document.getElementById('loadingOverlay');
            if (loadingOverlay) {
                loadingOverlay.classList.remove('show');
                loadingOverlay.style.display = 'none';
            }

            // Override any global showLoading function temporarily
            const originalShowLoading = window.showLoading;
            window.showLoading = function() {
                console.log('Loading prevented for PDF download');
            };

            // Restore original function after a short delay
            setTimeout(() => {
                window.showLoading = originalShowLoading;
            }, 1000);

            // Add CSS rule to force hide loading overlay
            const style = document.createElement('style');
            style.id = 'pdf-download-style';
            style.textContent = `
                .loading-overlay, #loadingOverlay {
                    display: none !important;
                    opacity: 0 !important;
                    visibility: hidden !important;
                }
            `;
            document.head.appendChild(style);

            // Remove the style after download starts
            setTimeout(() => {
                const styleElement = document.getElementById('pdf-download-style');
                if (styleElement) {
                    styleElement.remove();
                }
            }, 2000);

            // Allow the link to proceed normally
            return true;
        }, true); // Use capture phase for higher priority
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\backoffice-fasya\resources\views/reports/work-logs.blade.php ENDPATH**/ ?>