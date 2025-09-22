<?php $__env->startSection('title', 'Attendance Details'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    :root {
        --sky-blue-50: #f0f9ff;
        --sky-blue-100: #e0f2fe;
        --sky-blue-200: #bae6fd;
        --sky-blue-300: #7dd3fc;
        --sky-blue-400: #38bdf8;
        --sky-blue-500: #0ea5e9;
        --sky-blue-600: #0284c7;
        --sky-blue-700: #0369a1;
        --sky-blue-800: #075985;
        --sky-blue-900: #0c4a6e;
    }

    body {
        background: linear-gradient(135deg, var(--sky-blue-50) 0%, #ffffff 100%);
        font-family: 'Inter', sans-serif;
    }

    .attendance-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .page-header {
        background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
        color: white;
        padding: 2rem;
        border-radius: 20px 20px 0 0;
        margin-bottom: 0;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.15);
    }

    .page-title {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .main-content {
        background: white;
        border-radius: 0 0 20px 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(14, 165, 233, 0.1);
        border: 1px solid var(--sky-blue-100);
        border-top: none;
    }

    .info-card {
        background: linear-gradient(135deg, var(--sky-blue-50) 0%, #ffffff 100%);
        border: 2px solid var(--sky-blue-100);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(14, 165, 233, 0.15);
        border-color: var(--sky-blue-300);
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: var(--sky-blue-700);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }

    .btn-sky {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-right: 1rem;
    }

    .btn-sky:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="attendance-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title">
            <i class="fas fa-user-clock"></i>
            Attendance Details
        </h1>
        <div style="margin-top: 1.5rem;">
            <a href="<?php echo e(route('attendance.edit', $attendance)); ?>" class="btn-sky">
                <i class="fas fa-edit"></i>
                Edit Record
            </a>
            <a href="<?php echo e(route('attendance.index')); ?>" class="btn-sky">
                <i class="fas fa-arrow-left"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Employee Information -->
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-user"></i>
                </div>
                <span>Employee Information</span>
            </div>
            <div>
                <h3 style="color: var(--sky-blue-800); margin-bottom: 0.5rem;">
                    <?php echo e($attendance->employee->name ?? 'N/A'); ?>

                </h3>
                <p style="color: var(--sky-blue-600); margin: 0;">
                    Employee Code: <?php echo e($attendance->employee->employee_code ?? 'N/A'); ?>

                </p>
            </div>
        </div>

        <!-- Date and Status -->
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <span>Date & Status</span>
            </div>
            <div>
                <p style="font-size: 1.25rem; font-weight: 600; color: var(--sky-blue-700); margin-bottom: 0.5rem;">
                    <?php echo e(\Carbon\Carbon::parse($attendance->date)->format('l, d F Y')); ?>

                </p>
                <span style="padding: 0.5rem 1rem; border-radius: 25px; font-weight: 600;
                    background: <?php echo e($attendance->status === 'present' ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)'); ?>;
                    color: white;">
                    <i class="fas fa-<?php echo e($attendance->status === 'present' ? 'check-circle' : 'times-circle'); ?>"></i>
                    <?php echo e(ucfirst($attendance->status)); ?>

                </span>
            </div>
        </div>

        <!-- Check In Details -->
        <?php if($attendance->check_in): ?>
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <span>Check In Details</span>
            </div>
            <div>
                <p style="font-size: 1.5rem; font-weight: 700; color: var(--sky-blue-700); margin-bottom: 0.5rem;">
                    <?php echo e(\Carbon\Carbon::parse($attendance->check_in)->format('H:i:s')); ?>

                </p>
                <?php if($attendance->check_in_location): ?>
                    <p style="margin-bottom: 0.5rem;">
                        <i class="fas fa-map-marker-alt text-success me-2"></i>
                        <?php echo e($attendance->check_in_location); ?>

                    </p>
                <?php endif; ?>
                <?php if($attendance->check_in_latitude && $attendance->check_in_longitude): ?>
                    <p style="margin-bottom: 0.5rem;">
                        <i class="fas fa-crosshairs me-2"></i>
                        <?php echo e(number_format($attendance->check_in_latitude, 6)); ?>, <?php echo e(number_format($attendance->check_in_longitude, 6)); ?>

                    </p>
                    <a href="https://maps.google.com/?q=<?php echo e($attendance->check_in_latitude); ?>,<?php echo e($attendance->check_in_longitude); ?>"
                       target="_blank" style="color: var(--sky-blue-600); text-decoration: none;">
                        <i class="fas fa-external-link-alt me-2"></i>
                        View on Google Maps
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Check Out Details -->
        <?php if($attendance->check_out): ?>
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <span>Check Out Details</span>
            </div>
            <div>
                <p style="font-size: 1.5rem; font-weight: 700; color: var(--sky-blue-700); margin-bottom: 0.5rem;">
                    <?php echo e(\Carbon\Carbon::parse($attendance->check_out)->format('H:i:s')); ?>

                </p>
                <?php if($attendance->check_out_location): ?>
                    <p style="margin-bottom: 0.5rem;">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                        <?php echo e($attendance->check_out_location); ?>

                    </p>
                <?php endif; ?>
                <?php if($attendance->check_out_latitude && $attendance->check_out_longitude): ?>
                    <p style="margin-bottom: 0.5rem;">
                        <i class="fas fa-crosshairs me-2"></i>
                        <?php echo e(number_format($attendance->check_out_latitude, 6)); ?>, <?php echo e(number_format($attendance->check_out_longitude, 6)); ?>

                    </p>
                    <a href="https://maps.google.com/?q=<?php echo e($attendance->check_out_latitude); ?>,<?php echo e($attendance->check_out_longitude); ?>"
                       target="_blank" style="color: var(--sky-blue-600); text-decoration: none;">
                        <i class="fas fa-external-link-alt me-2"></i>
                        View on Google Maps
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <!-- Notes -->
        <?php if($attendance->notes): ?>
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-sticky-note"></i>
                </div>
                <span>Notes</span>
            </div>
            <div style="background: var(--sky-blue-50); padding: 1rem; border-radius: 8px; border-left: 4px solid var(--sky-blue-400);">
                <?php echo e($attendance->notes); ?>

            </div>
        </div>
        <?php endif; ?>

        <!-- Attendance Photo -->
        <?php if($attendance->attachment_image): ?>
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-camera"></i>
                </div>
                <span>Attendance Photo</span>
                <small style="margin-left: auto; color: var(--sky-blue-600); font-weight: normal;">
                    <i class="fas fa-sync-alt me-1"></i>
                    Synced from Mobile App
                </small>
            </div>
            <div style="text-align: center;">
                <img src="<?php echo e(route('attendance.photo', $attendance->attachment_image)); ?>?v=<?php echo e(time()); ?>"
                     alt="Attendance Photo"
                     style="max-width: 100%; max-height: 500px; height: auto; border-radius: 12px;
                            box-shadow: 0 4px 15px rgba(14, 165, 233, 0.15);
                            border: 2px solid var(--sky-blue-100);"
                     onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <div style="display: none; padding: 2rem; background: var(--sky-blue-50); border-radius: 12px; color: var(--sky-blue-600);">
                    <i class="fas fa-image fa-3x mb-3"></i>
                    <p>Photo not available</p>
                    <small>Filename: <?php echo e($attendance->attachment_image); ?></small>
                </div>
            </div>
            <div style="margin-top: 1rem; text-align: center;">
                <small style="color: var(--sky-blue-600);">
                    <i class="fas fa-info-circle me-1"></i>
                    Photo taken during attendance check-in
                </small>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Integrasi KP\backoffice-fasya\resources\views/attendance/show.blade.php ENDPATH**/ ?>