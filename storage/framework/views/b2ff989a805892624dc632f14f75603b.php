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
    background: linear-gradient(135deg, #29b6f6 0%, #0288d1 100%);
    color: white;
    border-radius: 0.5rem;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}
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
                <h1 class="h3 mb-0">
                    <i class="fas fa-tasks"></i> Work Logs Report
                </h1>
                <p class="mb-0 mt-2">
                    Period: <?php echo e($startDate->format('M d, Y')); ?> - <?php echo e($endDate->format('M d, Y')); ?>

                </p>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-light">
                        <i class="fas fa-arrow-left me-2"></i> Back to Reports
                    </a>
                    <a href="<?php echo e(route('reports.work-logs', array_merge(request()->all(), ['format' => 'pdf']))); ?>"
                       class="btn btn-light">
                        <i class="fas fa-file-pdf me-2" ></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-primary">
                        <i class="fas fa-list-alt fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['total_logs']); ?></div>
                    <div class="text-muted small">Total Logs</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-info">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['total_hours']); ?></div>
                    <div class="text-muted small">Total Hours</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-success">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['completed_tasks']); ?></div>
                    <div class="text-muted small">Completed</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-warning">
                        <i class="fas fa-spinner fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['ongoing_tasks']); ?></div>
                    <div class="text-muted small">Ongoing</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-primary">
                        <i class="fas fa-play fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['in_progress_tasks']); ?></div>
                    <div class="text-muted small">In Progress</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-secondary">
                        <i class="fas fa-calendar-day fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['days_worked']); ?></div>
                    <div class="text-muted small">Days Worked</div>
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
    <div class="row mt-4 mb-4">
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Integrasi KP\backoffice-fasya\resources\views/reports/work-logs.blade.php ENDPATH**/ ?>