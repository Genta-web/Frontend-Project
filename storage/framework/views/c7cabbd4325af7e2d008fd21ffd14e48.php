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

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <!-- Profile Photo Section -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <img src="<?php echo e(route('profile.photo', $user->id)); ?>?v=<?php echo e(time()); ?>"
                             alt="Profile Photo"
                             class="rounded-circle border border-3 border-primary shadow"
                             style="width: 150px; height: 150px; object-fit: cover;"
                             data-user-id="<?php echo e($user->id); ?>"
                             id="profilePhotoDisplay">
                    </div>
                    <h5 class="card-title mb-1 fw-bold"><?php echo e($employee->name ?? 'N/A'); ?></h5>
                    <div class="mb-2">
                        <span class="badge bg-secondary me-1"><?php echo e($employee->position ?? 'N/A'); ?></span>
                        <span class="badge bg-info"><?php echo e($employee->department ?? 'N/A'); ?></span>
                    </div>
                    <form id="photoUploadForm" action="<?php echo e(route('profile.update-photo')); ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <div class="mb-2">
                            <input type="file" class="form-control form-control-sm" id="profilePhotoInput" name="profile_photo" accept="image/*" required>
                        </div>
                        <div id="photoPreview" class="mb-2" style="display: none;">
                            <img id="previewImage" src="" alt="Preview" class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                        <button type="submit" class="btn btn-outline-primary btn-sm w-100" id="uploadBtn">
                            <i class="fas fa-camera me-1"></i>Update Photo
                        </button>
                        <div id="uploadProgress" class="mt-2" style="display: none;">
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: 0%"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Profile Information Section -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-bottom-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 fw-bold"><i class="fas fa-user me-2"></i>Personal Information</h5>
                        <a href="<?php echo e(route('profile.edit')); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit Profile
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Employee Code</label>
                            <div class="form-control-plaintext"><?php echo e($employee->employee_code ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Username</label>
                            <div class="form-control-plaintext"><?php echo e($user->username); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Full Name</label>
                            <div class="form-control-plaintext"><?php echo e($employee->name ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Email</label>
                            <div class="form-control-plaintext"><?php echo e($employee->email ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Phone</label>
                            <div class="form-control-plaintext"><?php echo e($employee->phone ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Department</label>
                            <div class="form-control-plaintext"><?php echo e($employee->department ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Position</label>
                            <div class="form-control-plaintext"><?php echo e($employee->position ?? 'N/A'); ?></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Hire Date</label>
                            <div class="form-control-plaintext">
                                <?php echo e($employee->hire_date ? $employee->hire_date->format('d M Y') : 'N/A'); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Status</label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-<?php echo e($employee->status === 'active' ? 'success' : 'secondary'); ?>">
                                    <?php echo e(ucfirst($employee->status ?? 'N/A')); ?>

                                </span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Role</label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-primary"><?php echo e(ucfirst($user->role)); ?></span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Last Login</label>
                            <div class="form-control-plaintext">
                                <?php echo e($user->last_login ? $user->last_login->format('d M Y, H:i') : 'Never'); ?>

                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold mb-0">Account Status</label>
                            <div class="form-control-plaintext">
                                <span class="badge bg-<?php echo e($user->is_active ? 'success' : 'danger'); ?>">
                                    <?php echo e($user->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white border-bottom-0">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-key me-2"></i>Change Password</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('profile.update-password')); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PATCH'); ?>
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="current_password" class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="current_password" name="current_password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleCurrentPassword" onclick="togglePasswordVisibility('current_password', 'toggleCurrentPassword')">
                                        <i class="fas fa-eye" id="toggleCurrentPasswordIcon"></i>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
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
unset($__errorArgs, $__bag); ?>"
                                           id="password" name="password" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleNewPassword" onclick="togglePasswordVisibility('password', 'toggleNewPassword')">
                                        <i class="fas fa-eye" id="toggleNewPasswordIcon"></i>
                                    </button>
                                </div>
                                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control"
                                           id="password_confirmation" name="password_confirmation" required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword" onclick="togglePasswordVisibility('password_confirmation', 'toggleConfirmPassword')">
                                        <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <button type="submit" class="btn btn-warning">
                                <i class="fas fa-key me-1"></i>Update Password
                            </button>
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

    // Photo upload preview functionality
    const photoInput = document.getElementById('profilePhotoInput');
    const photoPreview = document.getElementById('photoPreview');
    const previewImage = document.getElementById('previewImage');
    const uploadBtn = document.getElementById('uploadBtn');

    if (photoInput) {
        photoInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    photoPreview.style.display = 'block';
                    uploadBtn.textContent = 'Upload New Photo';
                };
                reader.readAsDataURL(file);
            } else {
                photoPreview.style.display = 'none';
                uploadBtn.textContent = 'Choose Photo';
            }
        });
    }

    // Form submission handling with AJAX for better UX
    const photoForm = document.getElementById('photoUploadForm');
    if (photoForm) {
        photoForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(photoForm);
            uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Uploading & Syncing...';
            uploadBtn.disabled = true;

            fetch(photoForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update profile photo with cache busting
                    const profileImg = document.getElementById('profilePhotoDisplay');
                    const userId = profileImg.getAttribute('data-user-id');
                    profileImg.src = `/profile-photo/${userId}?v=${Date.now()}`;

                    // Reset form
                    photoForm.reset();
                    photoPreview.style.display = 'none';
                    uploadBtn.innerHTML = '<i class="fas fa-camera me-1"></i>Update Photo';
                    uploadBtn.disabled = false;

                    // Show success message
                    showSuccessMessage('Profile photo updated and synced successfully!');
                } else {
                    throw new Error(data.message || 'Upload failed');
                }
            })
            .catch(error => {
                console.error('Upload error:', error);
                uploadBtn.innerHTML = '<i class="fas fa-camera me-1"></i>Update Photo';
                uploadBtn.disabled = false;
                alert('Upload failed: ' + error.message);
            });
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

    // Function to show success message
    function showSuccessMessage(message) {
        // Create or update success popup
        let popup = document.getElementById('successPopup');
        if (!popup) {
            popup = document.createElement('div');
            popup.id = 'successPopup';
            popup.className = 'popup-overlay';
            popup.innerHTML = `
                <div class="popup-card">
                    <div class="popup-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>
                    <h2 class="popup-title">Success!</h2>
                    <p class="popup-message">${message}</p>
                    <button class="popup-button" onclick="this.closest('.popup-overlay').style.display='none'">OK</button>
                </div>
            `;
            document.body.appendChild(popup);
        } else {
            popup.querySelector('.popup-message').textContent = message;
        }
        popup.style.display = 'flex';
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



<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Integrasi KP\backoffice-fasya\resources\views/profile/show.blade.php ENDPATH**/ ?>