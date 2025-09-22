<?php $__env->startSection('content'); ?>
<style>

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

    body {
        background-color: #f0faff;
    }
    .sidebar {
        background-color: #ffffff;
        border-right: 1px solid #e0e0e0;
        min-height: 100vh;
        padding-top: 1rem;
    }
    .nav-link {
        color: #333;
        transition: all 0.2s ease;
    }
    .nav-link.active, .nav-link:hover {
        background-color: #e0f5ff;
        color: #0d6efd;
        border-radius: 0.375rem;
    }
    .card {
        border: none;
        border-radius: 1rem;
    }
    .card .card-body {
        padding: 1.5rem;
    }
    .card-header {
        background-color: #e6f4ff;
        border-bottom: 1px solid #d0ebff;
        border-radius: 1rem 1rem 0 0;
        font-weight: 600;
        color: #0d6efd;
    }
    .border-left-primary {
        border-left: 4px solid #87CEEB;
    }
    .border-left-success {
        border-left: 4px solid #1cc88a;
    }
    .border-left-info {
        border-left: 4px solid #36b9cc;
    }
    .border-left-warning {
        border-left: 4px solid #f6c23e;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <!--

        <!- Main content -->
        <main class=" ms-sm-auto px-md-4">
            <div class="dashboard-header">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="dashboard-title">
                            Admin Dashboard
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow border-left-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase">Total Employees</h6>
                                    <h4><?php echo e($stats['total_employees']); ?></h4>
                                </div>
                                <i class="fas fa-users fa-2x text-sky-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow border-left-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase">Active Employees</h6>
                                    <h4><?php echo e($stats['active_employees']); ?></h4>
                                </div>
                                <i class="fas fa-user-check fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow border-left-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase">Present Today</h6>
                                    <h4><?php echo e($stats['present_today']); ?></h4>
                                </div>
                                <i class="fas fa-clock fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow border-left-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase">Inactive Employees</h6>
                                    <h4><?php echo e($stats['inactive_employees']); ?></h4>
                                </div>
                                <i class="fas fa-user-times fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            Recent Employees
                        </div>
                        <div class="card-body">
                            <?php if($recent_employees->count() > 0): ?>
                                <?php $__currentLoopData = $recent_employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-user-circle fa-2x text-sky-300 me-3"></i>
                                        <div>
                                            <strong><?php echo e($employee->name); ?></strong><br>
                                            <small class="text-muted"><?php echo e($employee->department); ?> - <?php echo e($employee->position); ?></small>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <p class="text-muted">No employees found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Today's Attendance</span>
                            <a href="<?php echo e(route('attendance.index')); ?>" class="btn btn-sm btn-primary">
                                <i class="fas fa-list me-1"></i> View All
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if($recent_attendance->count() > 0): ?>
                                <?php $__currentLoopData = $recent_attendance; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock fa-lg text-primary me-3"></i>
                                            <div>
                                                <strong><?php echo e($attendance->employee->name); ?></strong><br>
                                                <small class="text-muted">
                                                    <?php if($attendance->check_in && $attendance->check_out): ?>
                                                        In: <?php echo e($attendance->check_in); ?> | Out: <?php echo e($attendance->check_out); ?>

                                                    <?php elseif($attendance->check_in): ?>
                                                        In: <?php echo e($attendance->check_in); ?> | <span class="text-warning">Still working</span>
                                                    <?php else: ?>
                                                        <span class="text-danger">Not checked in</span>
                                                    <?php endif; ?>
                                                </small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-<?php echo e($attendance->status === 'present' ? 'success' : ($attendance->status === 'absent' ? 'danger' : 'warning')); ?>">
                                                <?php echo e(ucfirst($attendance->status)); ?>

                                            </span>
                                            <?php if($attendance->check_in && $attendance->check_out): ?>
                                                <?php
                                                    $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                                                    $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                                                    $workHours = $checkOut->diff($checkIn)->format('%H:%I');
                                                ?>
                                                <br><small class="text-muted"><?php echo e($workHours); ?>h</small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <p class="text-muted">No attendance records for today.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php if(session('error')): ?>
    <script>
        window.addEventListener('load', function () {
            setTimeout(function() {
                if (typeof window.showAlert === 'function') {
                    window.showAlert('Error', <?php echo json_encode(session('error'), 15, 512) ?>, 'error');
                } else {
                    alert(<?php echo json_encode(session('error'), 15, 512) ?>);
                }
            }, 100);
        });
    </script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\backoffice-fasya\resources\views/dashboard/admin.blade.php ENDPATH**/ ?>