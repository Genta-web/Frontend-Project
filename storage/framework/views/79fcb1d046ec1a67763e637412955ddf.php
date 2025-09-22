<?php $__env->startSection('title', 'Leaves Report'); ?>

<?php $__env->startPush('styles'); ?>
<style>
.status-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}
.status-approved { background-color: #d4edda; color: #155724; }
.status-pending { background-color: #fff3cd; color: #856404; }
.status-rejected { background-color: #f8d7da; color: #721c24; }
.leave-type-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    background-color: #e3f2fd;
    color: #1976d2;
}
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
.stats-card.total { border-color: #0d6efd; }
.stats-card.total .stats-icon { background-color: #0d6efd; }
.stats-card.total .stats-info h3 { color: #0d6efd; }

.stats-card.approved { border-color: #198754; }
.stats-card.approved .stats-icon { background-color: #198754; }
.stats-card.approved .stats-info h3 { color: #198754; }

.stats-card.pending { border-color: #ffc107; }
.stats-card.pending .stats-icon { background-color: #ffc107; }
.stats-card.pending .stats-info h3 { color: #ffc107; }

.stats-card.days { border-color: #fd7e14; }
.stats-card.days .stats-icon { background-color: #fd7e14; }
.stats-card.days .stats-info h3 { color: #fd7e14; }

.summary-card {
    border-radius: 0.5rem;
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}
.days-badge {
    background-color: #f8f9fa;
    color: #495057;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
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
                    <i class="fas fa-user-clock"></i> Leaves Report
                </h1>
                <p class="mb-0 mt-2">
                    Period: <?php echo e($startDate->format('M d, Y')); ?> - <?php echo e($endDate->format('M d, Y')); ?>

                </p>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <a href="<?php echo e(route('reports.index')); ?>" class="btn comprehensive-btn">
                        <i class="fas fa-arrow-left me-2"></i> Back to Reports
                    </a>
                    <a href="<?php echo e(route('reports.leaves', array_merge(request()->all(), ['format' => 'pdf']))); ?>"
                       class="btn comprehensive-btn">
                        <i class="fas fa-file-pdf me-2"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="stats-card total">
                        <div class="stats-icon">
                            <i class="fas fa-list-alt"></i>
                        </div>
                        <div class="stats-info">
                            <h3><?php echo e($summary['total_leaves']); ?></h3>
                            <p>Total Leaves</p>
                        </div>
                    </div>
                </div>
            <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card approved">
                        <div class="stats-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <div class="stats-info">
                            <h3><?php echo e($summary['approved']); ?></h3>
                            <p>Approved</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card pending">
                        <div class="stats-icon">
                            <i class="fas fa-hourglass-half"></i>
                        </div>
                        <div class="stats-info">
                            <h3><?php echo e($summary['pending']); ?></h3>
                            <p>Pending</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stats-card days">
                        <div class="stats-icon">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div class="stats-info">
                            <h3><?php echo e($summary['total_days']); ?></h3>
                            <p>Total Days</p>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Leave Types Distribution -->
    <?php if($summary['leave_types']->count() > 0): ?>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Leave Types Distribution</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <?php $__currentLoopData = $summary['leave_types']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-3 col-sm-6 mb-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="leave-type-badge"><?php echo e(ucfirst($type)); ?></span>
                                <span class="fw-bold"><?php echo e($count); ?></span>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Leaves Data Table -->
    <div class="card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Leave Records</h6>
        </div>
        <div class="card-body">
            <?php if($leaves->count() > 0): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Employee</th>
                                <th>Leave Type</th>
                                <th>Period</th>
                                <th>Days</th>
                                <th>Status</th>
                                <th>Reason</th>
                                <th>Approved By</th>
                                <th>Admin Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="fw-bold"><?php echo e($leave->employee->name); ?></div>
                                    <small class="text-muted"><?php echo e($leave->employee->employee_code); ?></small>
                                </td>
                                <td>
                                    <span class="leave-type-badge"><?php echo e(ucfirst($leave->leave_type)); ?></span>
                                </td>
                                <td>
                                    <div>
                                        <small class="text-success">From: <?php echo e($leave->start_date->format('M d, Y')); ?></small><br>
                                        <small class="text-danger">To: <?php echo e($leave->end_date->format('M d, Y')); ?></small>
                                    </div>
                                </td>
                                <td>
                                    <span class="days-badge"><?php echo e($leave->total_days); ?> days</span>
                                </td>
                                <td>
                                    <span class="status-badge status-<?php echo e($leave->status); ?>">
                                        <?php echo e(ucfirst($leave->status)); ?>

                                    </span>
                                </td>
                                <td>
                                    <?php if($leave->reason): ?>
                                        <div class="text-truncate" style="max-width: 200px;" title="<?php echo e($leave->reason); ?>">
                                            <?php echo e(Str::limit($leave->reason, 50)); ?>

                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($leave->approvedBy): ?>
                                        <div>
                                            <small class="fw-bold"><?php echo e($leave->approvedBy->username); ?></small><br>
                                            <?php if($leave->approved_at): ?>
                                                <small class="text-muted"><?php echo e($leave->approved_at->format('M d, Y')); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if($leave->admin_notes): ?>
                                        <div class="text-truncate" style="max-width: 150px;" title="<?php echo e($leave->admin_notes); ?>">
                                            <?php echo e(Str::limit($leave->admin_notes, 30)); ?>

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
                    <i class="fas fa-user-clock fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No leave records found</h5>
                    <p class="text-muted">No leave data available for the selected period.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Additional Statistics -->
    <?php if($leaves->count() > 0): ?>
    <div class="row mt-4 mb-4">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Approval Rate</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="h5 text-success">
                            <?php echo e($summary['total_leaves'] > 0 ? number_format(($summary['approved'] / $summary['total_leaves']) * 100, 1) : 0); ?>%
                        </div>
                        <div class="small text-muted">Applications Approved</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Average Duration</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <div class="h5 text-info">
                            <?php echo e($summary['approved'] > 0 ? number_format($summary['total_days'] / $summary['approved'], 1) : 0); ?>

                        </div>
                        <div class="small text-muted">Days per Leave</div>
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
                        <div class="h5 text-warning"><?php echo e($leaves->groupBy('employee_id')->count()); ?></div>
                        <div class="small text-muted">Employees on Leave</div>
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\backoffice-fasya\resources\views/reports/leaves.blade.php ENDPATH**/ ?>