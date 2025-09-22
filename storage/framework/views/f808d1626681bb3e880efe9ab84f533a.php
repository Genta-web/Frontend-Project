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

.summary-card {
    border-radius: 0.5rem;
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.progress-bar-custom {
    height: 8px;
    border-radius: 4px;
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

.stats-card.overdue { border-color: #f03d3dff; }
.stats-card.overdue .stats-icon { background-color: #f03d3dff; }
.stats-card.overdue .stats-info h3 { color: #f03d3dff; }

.stats-card.total-hours { border-color: #0dcaf0; }
.stats-card.total-hours .stats-icon { background-color: #0dcaf0; }
.stats-card.total-hours .stats-info h3 { color: #0dcaf0; }

.stats-card.completed { border-color: #198754; }
.stats-card.completed .stats-icon { background-color: #198754; }
.stats-card.completed .stats-info h3 { color: #198754; }

.stats-card.pending { border-color: #ffc107; }
.stats-card.pending .stats-icon { background-color: #ffc107; }
.stats-card.pending .stats-info h3 { color: #ffc107; }

.stats-card.in-progress { border-color: #0d6efd; }
.stats-card.in-progress .stats-icon { background-color: #0d6efd; }
.stats-card.in-progress .stats-info h3 { color: #0d6efd; }

.stats-card.days-worked { border-color: #6c757d; }
.stats-card.days-worked .stats-icon { background-color: #6c757d; }
.stats-card.days-worked .stats-info h3 { color: #6c757d; }

/* Variasi Warna Kartu (Tambahkan yang ini) */

.stats-card.total {
    border-color: #0d6efd;
}
.stats-card.total .stats-icon {
    background-color: #0d6efd;
}
.stats-card.total .stats-info h3 {
    color: #0d6efd;
}

.stats-card.in-progress {
    border-color: #0dcaf0;
}
.stats-card.in-progress .stats-icon {
    background-color: #0dcaf0;
}
.stats-card.in-progress .stats-info h3 {
    color: #0dcaf0;
}

.stats-card.days {
    border-color: #fd7e14;
}
.stats-card.days .stats-icon {
    background-color: #fd7e14;
}
.stats-card.days .stats-info h3 {
    color: #fd7e14;
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
                    <i class="fas fa-briefcase"></i> Jobs Report
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
            <div class="stats-card total">
                <div class="stats-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e($summary['total_jobs']); ?></h3>
                    <p>Total Jobs</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card pending">
                <div class="stats-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e($summary['pending']); ?></h3>
                    <p>Pending</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card in-progress">
                <div class="stats-icon">
                    <i class="fas fa-play"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e($summary['in_progress']); ?></h3>
                    <p>In Progress</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card completed">
                <div class="stats-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e($summary['completed']); ?></h3>
                    <p>Completed</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card overdue">
                <div class="stats-icon">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e($summary['overdue']); ?></h3>
                    <p>Overdue</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-6 mb-4">
            <div class="stats-card days">
                <div class="stats-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="stats-info">
                    <h3><?php echo e(number_format($summary['average_progress'], 1)); ?>%</h3>
                    <p>Avg Progress</p>
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
    <div class="row mt-4 mb-4">
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\backoffice-fasya\resources\views/reports/jobs.blade.php ENDPATH**/ ?>