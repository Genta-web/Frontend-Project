<?php $__env->startSection('title', 'Jobs Report'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.status-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}
.status-pending { background-color: #fff3cd; color: #856404; }
.status-in_progress { background-color: #cce7ff; color: #004085; }
.status-completed { background-color: #d4edda; color: #155724; }
.status-cancelled { background-color: #f8d7da; color: #721c24; }
.priority-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}
.priority-low { background-color: #e2e3e5; color: #383d41; }
.priority-medium { background-color: #fff3cd; color: #856404; }
.priority-high { background-color: #f5c6cb; color: #721c24; }
.priority-urgent { background-color: #dc3545; color: white; }


.report-header {
    background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
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
.progress-bar-custom {
    height: 8px;
    border-radius: 4px;
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
                    <i class="fas fa-briefcase"></i> Jobs Report
                </h1>
                <p class="mb-0 mt-2">
                    Period: <?php echo e($startDate->format('M d, Y')); ?> - <?php echo e($endDate->format('M d, Y')); ?>

                </p>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('reports.index')); ?>" class="btn btn-light">
                        <i class="fas fa-arrow-left"></i> Back to Reports
                    </a>
                    <a href="<?php echo e(route('reports.jobs', array_merge(request()->all(), ['format' => 'pdf']))); ?>"
                       class="btn btn-light">
                        <i class="fas fa-file-pdf"></i> Download PDF
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
                        <i class="fas fa-briefcase fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['total_jobs']); ?></div>
                    <div class="text-muted small">Total Jobs</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-warning">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['pending']); ?></div>
                    <div class="text-muted small">Pending</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-info">
                        <i class="fas fa-play fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['in_progress']); ?></div>
                    <div class="text-muted small">In Progress</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-success">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['completed']); ?></div>
                    <div class="text-muted small">Completed</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-danger">
                        <i class="fas fa-exclamation-triangle fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e($summary['overdue']); ?></div>
                    <div class="text-muted small">Overdue</div>
                </div>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 mb-3">
            <div class="card summary-card h-100">
                <div class="card-body text-center">
                    <div class="text-secondary">
                        <i class="fas fa-percentage fa-2x"></i>
                    </div>
                    <div class="h4 mt-2 mb-0"><?php echo e(number_format($summary['average_progress'], 1)); ?>%</div>
                    <div class="text-muted small">Avg Progress</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jobs Data Table -->
    <div class="card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Job Records</h6>
        </div>
        <div class="card-body">
            <?php if($jobs->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Job Title</th>
                                <th>Employee</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Start Date</th>
                                <th>Due Date</th>
                                <th>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="<?php echo e($job->due_date < now() && $job->job_status !== 'completed' ? 'table-warning' : ''); ?>">
                                <td>
                                    <div class="fw-bold"><?php echo e($job->name); ?></div>
                                    <?php if($job->due_date < now() && $job->job_status !== 'completed'): ?>
                                        <small class="text-danger">
                                            <i class="fas fa-exclamation-triangle"></i> Overdue
                                        </small>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="fw-bold"><?php echo e($job->employee->name); ?></div>
                                    <small class="text-muted"><?php echo e($job->employee->employee_code); ?></small>
                                </td>
                                <td>
                                    <span class="priority-badge priority-<?php echo e($job->priority); ?>">
                                        <?php echo e(ucfirst($job->priority)); ?>

                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo e($job->job_status); ?>">
                                        <?php echo e(ucfirst(str_replace('_', ' ', $job->job_status))); ?>

                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="progress progress-bar-custom flex-grow-1 me-2">
                                            <div class="progress-bar
                                                <?php if($job->progress_percentage >= 100): ?> bg-success
                                                <?php elseif($job->progress_percentage >= 75): ?> bg-info
                                                <?php elseif($job->progress_percentage >= 50): ?> bg-warning
                                                <?php else: ?> bg-danger
                                                <?php endif; ?>"
                                                role="progressbar"
                                                style="width: <?php echo e($job->progress_percentage); ?>%">
                                            </div>
                                        </div>
                                        <small class="text-muted"><?php echo e($job->progress_percentage); ?>%</small>
                                    </div>
                                </td>
                                <td>
                                    <?php if($job->start_date): ?>
                                        <?php echo e($job->start_date->format('M d, Y')); ?>

                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($job->due_date): ?>
                                        <div class="<?php echo e($job->due_date < now() && $job->job_status !== 'completed' ? 'text-danger fw-bold' : ''); ?>">
                                            <?php echo e($job->due_date->format('M d, Y')); ?>

                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($job->description): ?>
                                        <div class="text-truncate" style="max-width: 200px;" title="<?php echo e($job->description); ?>">
                                            <?php echo e(Str::limit($job->description, 50)); ?>

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
                    <i class="fas fa-briefcase fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No jobs found</h5>
                    <p class="text-muted">No job data available for the selected period.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Additional Statistics -->
    <?php if($jobs->count() > 0): ?>
    <div class="row mt-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Completion Rate</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="h5 text-success">
                            <?php echo e($summary['total_jobs'] > 0 ? number_format(($summary['completed'] / $summary['total_jobs']) * 100, 1) : 0); ?>%
                        </div>
                        <div class="small text-muted">Jobs Completed</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Priority Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="small text-muted">High/Urgent</div>
                            <div class="fw-bold"><?php echo e($jobs->whereIn('priority', ['high', 'urgent'])->count()); ?></div>
                        </div>
                        <div class="col-6">
                            <div class="small text-muted">Low/Medium</div>
                            <div class="fw-bold"><?php echo e($jobs->whereIn('priority', ['low', 'medium'])->count()); ?></div>
                        </div>
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
                        <div class="h5 text-info"><?php echo e($jobs->groupBy('employee_id')->count()); ?></div>
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
    // Add tooltips for truncated descriptions
    const truncatedElements = document.querySelectorAll('.text-truncate[title]');
    truncatedElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            // Could add custom tooltip logic here
        });
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Gitlab\backoffice-fasya\resources\views/reports/jobs.blade.php ENDPATH**/ ?>