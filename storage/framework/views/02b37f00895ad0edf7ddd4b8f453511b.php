<?php $__env->startPush('head'); ?>
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">
<?php $__env->stopPush(); ?>

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
/* -- MODERN PROFILE STYLES -- */
:root {
    --profile-primary-color: #0d6efd; /* Warna biru utama Bootstrap */
    --profile-card-bg: #ffffff;
    --profile-text-color: #495057;
    --profile-label-color: #6c757d;
    --profile-border-color: #e9ecef;
    --profile-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
    --profile-border-radius: 1rem; /* 16px */
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
    background: linear-gradient(45deg, #3b82f6, #60a5fa); /* Gradient biru modern */
    border-radius: var(--profile-border-radius) var(--profile-border-radius) 0 0;
}

/* Styling untuk Avatar */
.profile-avatar-wrapper {
    position: relative;
    width: 150px;
    height: 150px;
    margin: -75px auto 1rem auto; /* Tarik ke atas untuk overlap */
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

/* Styling Info Personal */
.profile-info h4 {
    font-weight: 700;
    margin-bottom: 0.25rem;
}

.profile-info .text-muted {
    font-size: 1rem;
    margin-bottom: 1rem;
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    text-align: left;
    margin-top: 2rem;
}

.info-grid dl {
    margin-bottom: 0;
}

.info-grid dt {
    font-weight: 600;
    color: var(--profile-label-color);
    font-size: 0.875rem; /* 14px */
    margin-bottom: 0.25rem;
}

.info-grid dd {
    font-weight: 500;
    color: var(--profile-text-color);
    font-size: 1rem;
    margin-left: 0;
}

.info-grid .badge {
    font-size: 0.8rem;
    padding: 0.4em 0.8em;
}

/* Custom styling untuk form */
.form-control, .form-control:focus {
    background-color: #f8f9fa;
    border: 1px solid var(--profile-border-color);
}
.form-control:focus {
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
}
.input-group .btn {
    border-color: var(--profile-border-color);
}


/* -- ORIGINAL POPUP STYLES -- */
.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.6);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 1050;
    padding: 20px;
    box-sizing: border-box;
}

.popup-card {
    background: white;
    padding: 2.5rem;
    border-radius: 1.5rem;
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 420px;
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
    background-color: #D1FAE5;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
}

.popup-icon svg {
    width: 40px;
    height: 40px;
    color: #065F46;
}

.popup-title {
    font-size: 1.75rem;
    font-weight: 700;
    color: #1F2937;
    margin: 0 0 0.5rem 0;
}

.popup-message {
    font-size: 1rem;
    color: #6B7280;
    margin: 0 0 2rem 0;
    line-height: 1.6;
}

.popup-button {
    width: 100%;
    padding: 0.8rem 1rem;
    background-color: #1F2937;
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
</style>



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
                        <img src="<?php echo e(route('profile.photo', $user->id)); ?>" alt="Profile Photo" class="profile-avatar" data-user-id="<?php echo e($user->id); ?>">
                        <div class="profile-avatar-overlay">
                            <i class="fas fa-camera"></i>
                            <span>Ganti Foto</span>
                        </div>
                        <input type="file" id="profilePhotoInput" name="profile_photo" class="d-none" accept="image/*" onchange="document.getElementById('photoUploadForm').submit();">
                    </div>
                    
                    <button type="submit" id="uploadBtn" class="d-none">Upload</button>
                </form>

                <div class="profile-info">
                    <h4 class="mb-1"><?php echo e($employee->name ?? 'N/A'); ?></h4>
                    <p class="text-muted"><?php echo e($employee->position ?? 'N/A'); ?> • <?php echo e($employee->department ?? 'N/A'); ?></p>
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit Profile
                    </a>
                </div>

                <hr>

                <div class="mt-4">
                    <h5 class="text-start fw-bold mb-3"><i class="fas fa-user-circle me-2"></i>Personal Information</h5>
                    <div class="info-grid">
                        <dl><dt>Employee Code</dt><dd><?php echo e($employee->employee_code ?? 'N/A'); ?></dd></dl>
                        <dl><dt>Username</dt><dd><?php echo e($user->username); ?></dd></dl>
                        <dl><dt>Full Name</dt><dd><?php echo e($employee->name ?? 'N/A'); ?></dd></dl>
                        <dl><dt>Email Address</dt><dd><?php echo e($employee->email ?? 'N/A'); ?></dd></dl>
                        <dl><dt>Phone</dt><dd><?php echo e($employee->phone ?? 'N/A'); ?></dd></dl>
                        <dl><dt>Hire Date</dt><dd><?php echo e($employee->hire_date ? $employee->hire_date->format('d M Y') : 'N/A'); ?></dd></dl>
                        <dl><dt>Last Login</dt><dd><?php echo e($user->last_login ? $user->last_login->format('d M Y, H:i') : 'Never'); ?></dd></dl>
                        <dl><dt>Role</dt><dd><span class="badge bg-primary"><?php echo e(ucfirst($user->role)); ?></span></dd></dl>
                        <dl><dt>Employee Status</dt><dd><span class="badge bg-<?php echo e($employee->status === 'active' ? 'success' : 'secondary'); ?>"><?php echo e(ucfirst($employee->status ?? 'N/A')); ?></span></dd></dl>
                        <dl><dt>Account Status</dt><dd><span class="badge bg-<?php echo e($user->is_active ? 'success' : 'danger'); ?>"><?php echo e($user->is_active ? 'Active' : 'Inactive'); ?></span></dd></dl>
                    </div>
                </div>

                <hr class="my-4">

                <div class="mt-2">
                    <h5 class="text-start fw-bold mb-3"><i class="fas fa-key me-2"></i>Change Password</h5>
                    <form action="<?php echo e(route('profile.update-password')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <div class="row g-3 text-start">
                            <div class="col-12">
                                <label for="current_password" class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="current_password" name="current_password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword" onclick="togglePasswordVisibility('current_password', 'toggleCurrentPassword')"><i class="fas fa-eye"></i></button>
                                </div>
                                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword" onclick="togglePasswordVisibility('password', 'toggleNewPassword')"><i class="fas fa-eye"></i></button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" onclick="togglePasswordVisibility('password_confirmation', 'toggleConfirmPassword')"><i class="fas fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="submit" class="btn btn-warning"><i class="fas fa-save me-1"></i>Update Password</button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
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

// Password visibility toggle function
function togglePasswordVisibility(passwordFieldId, toggleButtonId) {
    const passwordField = document.getElementById(passwordFieldId);
    const toggleButton = document.getElementById(toggleButtonId);
    const toggleIcon = toggleButton.querySelector('i');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
        toggleButton.setAttribute('title', 'Hide password');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
        toggleButton.setAttribute('title', 'Show password');
    }
}

// Initialize tooltips and form enhancements
document.addEventListener('DOMContentLoaded', function() {
    // Initialize password toggle buttons
    const toggleButtons = ['toggleCurrentPassword', 'toggleNewPassword', 'toggleConfirmPassword'];
    toggleButtons.forEach(function(buttonId) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.setAttribute('title', 'Show password');
        }
    });

    // Form submission handling for photo upload
    const photoForm = document.getElementById('photoUploadForm');
    if (photoForm) {
        photoForm.addEventListener('submit', function(e) {
            // Optional: Show a loading state on the avatar itself
            const avatarWrapper = document.querySelector('.profile-avatar-wrapper');
            if (avatarWrapper) {
                avatarWrapper.style.opacity = '0.7';
            }
        });
    }

    // Password form validation
    const passwordForm = document.querySelector('form[action*="update-password"]');
    if (passwordForm) {
        passwordForm.addEventListener('submit', function(e) {
            const newPassword = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;

            if (newPassword !== confirmPassword) {
                e.preventDefault();
                alert('New password and confirmation password do not match.');
                return false;
            }

            // Show loading state
            const submitBtn = passwordForm.querySelector('button[type="submit"]');
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Updating...';
                submitBtn.disabled = true;
            }
        });
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// Profile show page is handled by global profile-photo.js
// Additional page-specific functionality can be added here if needed
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\backoffice-fasya\resources\views/profile/show.blade.php ENDPATH**/ ?>