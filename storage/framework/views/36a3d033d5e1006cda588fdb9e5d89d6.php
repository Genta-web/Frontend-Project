<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <main class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0"><i class="fas fa-user-edit me-2"></i>Edit Profile</h2>
                <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Profile
                </a>
            </div>

            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <div class="row g-4">
                <!-- Profile Photo Section -->
                <div class="col-md-4">
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
                            <p class="text-muted mb-2"><?php echo e($employee->position ?? 'N/A'); ?></p>
                            <form id="photoUploadForm" action="<?php echo e(route('profile.update-photo')); ?>" method="POST" enctype="multipart/form-data" class="mt-3">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <div class="mb-2">
                                    <label for="profile_photo" class="form-label">Choose New Photo</label>
                                    <input type="file" class="form-control form-control-sm <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="profilePhotoInput" name="profile_photo" accept="image/*" required>
                                    <div id="photoPreview" class="mt-2" style="display: none;">
                                        <img id="previewImage" src="" alt="Preview" class="rounded-circle border" style="width: 80px; height: 80px; object-fit: cover;">
                                    </div>
                                    <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text">Max 2MB. JPEG, PNG, JPG, GIF</div>
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

                <!-- Profile Information Form -->
                <div class="col-md-8">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-white border-bottom-0">
                            <h5 class="mb-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Edit Personal Information</h5>
                        </div>
                        <div class="card-body">
                            <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('PATCH'); ?>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="employee_code" class="form-label">Employee Code</label>
                                        <input type="text" class="form-control" id="employee_code"
                                               value="<?php echo e($employee->employee_code ?? 'N/A'); ?>" readonly>
                                        <div class="form-text">Employee code cannot be changed</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username"
                                               value="<?php echo e($user->username); ?>" readonly>
                                        <div class="form-text">Username cannot be changed</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="name" name="name" value="<?php echo e(old('name', $employee->name)); ?>" required>
                                        <?php $__errorArgs = ['name'];
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
                                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="email" name="email" value="<?php echo e(old('email', $employee->email)); ?>" required>
                                        <?php $__errorArgs = ['email'];
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
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="phone" name="phone" value="<?php echo e(old('phone', $employee->phone)); ?>">
                                        <?php $__errorArgs = ['phone'];
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
                                        <label for="department" class="form-label">Department</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="department" name="department" value="<?php echo e(old('department', $employee->department)); ?>">
                                        <?php $__errorArgs = ['department'];
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
                                        <label for="position" class="form-label">Position</label>
                                        <input type="text" class="form-control <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="position" name="position" value="<?php echo e(old('position', $employee->position)); ?>">
                                        <?php $__errorArgs = ['position'];
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
                                        <label for="hire_date" class="form-label">Hire Date</label>
                                        <input type="text" class="form-control" id="hire_date"
                                               value="<?php echo e($employee->hire_date ? $employee->hire_date->format('d M Y') : 'N/A'); ?>" readonly>
                                        <div class="form-text">Hire date cannot be changed</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status</label>
                                        <input type="text" class="form-control" id="status"
                                               value="<?php echo e(ucfirst($employee->status ?? 'N/A')); ?>" readonly>
                                        <div class="form-text">Status can only be changed by admin</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="role" class="form-label">Role</label>
                                        <input type="text" class="form-control" id="role"
                                               value="<?php echo e(ucfirst($user->role)); ?>" readonly>
                                        <div class="form-text">Role can only be changed by admin</div>
                                    </div>
                                </div>
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                                    <a href="<?php echo e(route('profile.show')); ?>" class="btn btn-secondary me-md-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Update Profile
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
                    alert('Profile photo updated and synced successfully!');
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
});
</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Integrasi KP\backoffice-fasya\resources\views/profile/edit.blade.php ENDPATH**/ ?>