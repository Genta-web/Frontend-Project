<?php $__env->startPush('styles'); ?>
<style>
/* -- MODERN PROFILE STYLES (Konsisten dengan halaman View Profile) -- */
:root {
    --profile-primary-color: #0d6efd;
    --profile-card-bg: #ffffff;
    --profile-text-color: #495057;
    --profile-label-color: #6c757d;
    --profile-border-color: #e9ecef;
    --profile-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
    --profile-border-radius: 1rem;
}

body {
    background-color: #f8fafc; /* Latar belakang halaman yang netral */
}

.profile-container {
    padding-top: 50px; /* Memberi ruang untuk avatar */
}

.profile-card {
    background-color: var(--profile-card-bg);
    border-radius: var(--profile-border-radius);
    box-shadow: var(--profile-shadow);
    border: none;
    text-align: center;
    position: relative;
    padding: 2rem;
    margin-top: -50px; /* Menarik kartu ke atas */
}

/* Header di belakang avatar */
.profile-header-placeholder {
    height: 120px;
    background: linear-gradient(45deg, #3b82f6, #60a5fa);
    border-radius: var(--profile-border-radius) var(--profile-border-radius) 0 0;
}

/* Styling untuk Avatar */
.profile-avatar-wrapper {
    position: relative;
    width: 150px;
    height: 150px;
    margin: -75px auto 1rem auto;
    border-radius: 50%;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    border: 5px solid white;
}

.profile-avatar {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.profile-avatar-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border-radius: 50%;
    background-color: rgba(0, 0, 0, 0.5);
    color: white;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    opacity: 0;
    transition: opacity 0.3s ease;
    cursor: pointer;
}

.profile-avatar-wrapper:hover .profile-avatar-overlay {
    opacity: 1;
}

.profile-avatar-overlay i {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

/* Info dasar di bawah avatar */
.profile-info h4 {
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.profile-info .text-muted {
    font-size: 1rem;
    margin-bottom: 1rem;
}

/* Styling untuk form */
.form-label {
    font-weight: 600;
    color: #334155;
}

.form-control, .form-control:focus {
    background-color: #f8f9fa;
    border-color: var(--profile-border-color);
}

.form-control:focus {
    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.15);
}

.form-control[readonly] {
    background-color: #e9ecef; /* Sedikit lebih gelap agar terlihat non-aktif */
    cursor: not-allowed;
}

.btn-primary {
    background-color: var(--profile-primary-color);
    border-color: var(--profile-primary-color);
}
.btn-primary:hover {
    background-color: #0b5ed7;
    border-color: #0a58ca;
}
.btn-light {
    background-color: #f8f9fa;
    border-color: var(--profile-border-color);
}
.btn-light:hover {
    background-color: #e9ecef;
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5 profile-container">
    <div class="row justify-content-center">
        <div class="col-xl-9 col-lg-10">

            <div class="profile-header-placeholder"></div>

            <div class="card profile-card">

                <form id="photoUploadForm" action="<?php echo e(route('profile.update-photo')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>
                    <div class="profile-avatar-wrapper" onclick="document.getElementById('profilePhotoInput').click();">
                        <img src="<?php echo e(route('profile.photo', $user->id)); ?>" alt="Profile Photo" class="profile-avatar">
                        <div class="profile-avatar-overlay">
                            <i class="fas fa-camera"></i>
                            <span>Ganti Foto</span>
                        </div>
                        <input type="file" id="profilePhotoInput" name="profile_photo" class="d-none" accept="image/*">
                    </div>
                </form>

                <div class="profile-info">
                    <h4 class="mb-1"><?php echo e($employee->name ?? 'N/A'); ?></h4>
                    <p class="text-muted"><?php echo e($employee->position ?? 'N/A'); ?> • <?php echo e($employee->department ?? 'N/A'); ?></p>
                </div>

                <hr>

                <form action="<?php echo e(route('profile.update')); ?>" method="POST" class="mt-4 text-start">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PATCH'); ?>

                    <h5 class="fw-bold mb-4"><i class="fas fa-user-edit me-2"></i>Edit Personal Details</h5>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="name" name="name" value="<?php echo e(old('name', $employee->name)); ?>" required>
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email" name="email" value="<?php echo e(old('email', $employee->email)); ?>" required>
                            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="phone" name="phone" value="<?php echo e(old('phone', $employee->phone)); ?>">
                            <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label">Position</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="position" name="position" value="<?php echo e(old('position', $employee->position)); ?>">
                            <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="department" name="department" value="<?php echo e(old('department', $employee->department)); ?>">
                            <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="invalid-feedback"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <div class="col-md-6">
                            <label for="employee_code" class="form-label">Employee Code</label>
                            <input type="text" class="form-control" id="employee_code" value="<?php echo e($employee->employee_code ?? 'N/A'); ?>" readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-5 pt-4 border-top">
                        <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-light">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Changes
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const photoInput = document.getElementById('profilePhotoInput');
    // Secara otomatis submit form foto ketika file dipilih
    if (photoInput) {
        photoInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                // Menampilkan notifikasi loading sederhana
                const avatarWrapper = document.querySelector('.profile-avatar-wrapper');
                if(avatarWrapper) {
                    avatarWrapper.style.opacity = '0.6';
                    avatarWrapper.style.cursor = 'wait';
                }
                document.getElementById('photoUploadForm').submit();
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\backoffice-fasya\resources\views/profile/edit.blade.php ENDPATH**/ ?>