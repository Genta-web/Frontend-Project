<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Override layout styles for register page */
    .login-wrapper {
        max-width: 600px;
    }

    .login-card {
        padding: 3rem;
    }

    /* Register specific styles */
    .register-header {
        text-align: center;
        margin-bottom: 2.5rem;
    }

    .register-title {
        font-size: 2.25rem;
        font-weight: 800;
        background: linear-gradient(135deg, var(--sky-blue-600) 0%, var(--sky-blue-800) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 1rem;
    }

    .register-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.5rem;
        box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
        animation: float 3s ease-in-out infinite;
    }

    .register-subtitle {
        color: var(--sky-blue-700);
        font-size: 1.1rem;
        font-weight: 500;
    }

    /* Form styling */
    .form-section {
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--sky-blue-800);
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid var(--sky-blue-200);
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .section-icon {
        width: 24px;
        height: 24px;
        background: var(--sky-blue-500);
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.8rem;
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--sky-blue-800);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .label-icon {
        color: var(--sky-blue-500);
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border-radius: 14px;
        border: 2px solid var(--sky-blue-200);
        padding: 1rem 1.25rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background: rgba(240, 249, 255, 0.5);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--sky-blue-500);
        box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.15);
        background: white;
    }

    .form-control::placeholder {
        color: var(--sky-blue-400);
        opacity: 0.8;
    }

    .input-group .form-control {
        border-radius: 14px 0 0 14px;
        border-right: none;
    }

    .input-group .btn {
        border-radius: 0 14px 14px 0;
        border: 2px solid var(--sky-blue-200);
        border-left: none;
        background: var(--sky-blue-50);
        color: var(--sky-blue-600);
        transition: all 0.3s ease;
    }

    .input-group .btn:hover {
        background: var(--sky-blue-100);
        color: var(--sky-blue-700);
    }

    .input-group .form-control:focus + .btn {
        border-color: var(--sky-blue-500);
    }

    /* Error styling */
    .error-message {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Submit button */
    .btn-register {
        background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
        border: none;
        border-radius: 14px;
        padding: 1rem 1.5rem;
        font-weight: 700;
        font-size: 1.1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        width: 100%;
        color: white;
    }

    .btn-register::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-register:hover::before {
        left: 100%;
    }

    .btn-register:hover {
        transform: translateY(-3px);
        box-shadow: 0 15px 35px rgba(14, 165, 233, 0.4);
        background: linear-gradient(135deg, var(--sky-blue-600) 0%, var(--sky-blue-700) 100%);
        color: white;
    }

    .btn-register:active {
        transform: translateY(-1px);
    }

    /* Loading state */
    .btn-loading {
        position: relative;
        color: transparent !important;
    }

    .btn-loading::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 20px;
        top: 50%;
        left: 50%;
        margin-left: -10px;
        margin-top: -10px;
        border: 2px solid transparent;
        border-top-color: white;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="login-card">
    <!-- Register Header -->
    <div class="register-header">
        <div class="register-title">
            <div class="register-icon">
                <i class="fas fa-user-plus"></i>
            </div>
            Create Account
        </div>
        <p class="register-subtitle">Join our team and start your journey with us</p>
    </div>

    <!-- Error Messages -->
    <?php if($errors->has('general')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <div>
                    <strong>Registration Failed!</strong><br>
                    <?php echo e($errors->first('general')); ?>

                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if($errors->has('employee_code')): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    <strong>Employee Code Issue!</strong><br>
                    <?php echo e($errors->first('employee_code')); ?>

                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Registration Form -->
    <form method="POST" action="<?php echo e(route('register')); ?>" id="registerForm">
        <?php echo csrf_field(); ?>

        <!-- Personal Information Section -->
        <div class="form-section">
            <div class="section-title">
                <div class="section-icon">
                    <i class="fas fa-user"></i>
                </div>
                Personal Information
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-id-card label-icon"></i>
                        <?php echo e(__('Full Name')); ?>

                    </label>
                    <input id="name" type="text"
                           class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           name="name" value="<?php echo e(old('name')); ?>"
                           placeholder="Enter your full name"
                           required autocomplete="name" autofocus>
                    <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="username" class="form-label">
                        <i class="fas fa-at label-icon"></i>
                        <?php echo e(__('Username')); ?>

                    </label>
                    <input id="username" type="text"
                           class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           name="username" value="<?php echo e(old('username')); ?>"
                           placeholder="Choose a username"
                           required autocomplete="username">
                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope label-icon"></i>
                    <?php echo e(__('Email Address')); ?>

                </label>
                <input id="email" type="email"
                       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="email" value="<?php echo e(old('email')); ?>"
                       placeholder="Enter your email address"
                       required autocomplete="email">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <div class="error-message">
                        <i class="fas fa-exclamation-circle"></i>
                        <?php echo e($message); ?>

                    </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <!-- Work Information Section -->
        <div class="form-section">
            <div class="section-title">
                <div class="section-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                Work Information
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="department" class="form-label">
                        <i class="fas fa-building label-icon"></i>
                        <?php echo e(__('Department')); ?>

                    </label>
                    <select id="department" class="form-select <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                            name="department" required>
                        <option value=""><?php echo e(__('Select Department')); ?></option>
                        <option value="IT" <?php echo e(old('department') == 'IT' ? 'selected' : ''); ?>>Information Technology</option>
                        <option value="HR" <?php echo e(old('department') == 'HR' ? 'selected' : ''); ?>>Human Resources</option>
                        <option value="Finance" <?php echo e(old('department') == 'Finance' ? 'selected' : ''); ?>>Finance</option>
                        <option value="Marketing" <?php echo e(old('department') == 'Marketing' ? 'selected' : ''); ?>>Marketing</option>
                        <option value="Operations" <?php echo e(old('department') == 'Operations' ? 'selected' : ''); ?>>Operations</option>
                        <option value="Sales" <?php echo e(old('department') == 'Sales' ? 'selected' : ''); ?>>Sales</option>
                    </select>
                    <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="position" class="form-label">
                        <i class="fas fa-user-tie label-icon"></i>
                        <?php echo e(__('Position')); ?>

                    </label>
                    <input id="position" type="text"
                           class="form-control <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           name="position" value="<?php echo e(old('position')); ?>"
                           placeholder="Enter your job position"
                           required>
                    <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>
        </div>

        <!-- Security Section -->
        <div class="form-section">
            <div class="section-title">
                <div class="section-icon">
                    <i class="fas fa-shield-alt"></i>
                </div>
                Security Information
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock label-icon"></i>
                        <?php echo e(__('Password')); ?>

                    </label>
                    <div class="input-group">
                        <input id="password" type="password"
                               class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               name="password"
                               placeholder="Create a strong password"
                               required autocomplete="new-password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')">
                            <i class="fas fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="form-group">
                    <label for="password-confirm" class="form-label">
                        <i class="fas fa-lock label-icon"></i>
                        <?php echo e(__('Confirm Password')); ?>

                    </label>
                    <div class="input-group">
                        <input id="password-confirm" type="password"
                               class="form-control" name="password_confirmation"
                               placeholder="Confirm your password"
                               required autocomplete="new-password">
                        <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm" onclick="togglePasswordVisibility('password-confirm', 'togglePasswordConfirm')">
                            <i class="fas fa-eye" id="togglePasswordConfirmIcon"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="form-section">
            <button type="submit" class="btn-register" id="registerBtn">
                <i class="fas fa-user-plus me-2"></i>
                <?php echo e(__('Create Account')); ?>

            </button>
        </div>
    </form>

    <!-- Divider -->
    <div class="divider">
        <span>or</span>
    </div>

    <!-- Footer Links -->
    <div class="text-center">
        <p class="text-muted mb-0">
            <?php echo e(__('Already have an account?')); ?>

            <a href="<?php echo e(route('login')); ?>" class="register-link"><?php echo e(__('Sign in here')); ?></a>
        </p>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .register-title {
            font-size: 1.75rem;
            flex-direction: column;
            gap: 0.75rem;
        }

        .register-icon {
            width: 50px;
            height: 50px;
            font-size: 1.25rem;
        }

        .login-card {
            padding: 2rem 1.5rem;
        }

        .section-title {
            font-size: 1rem;
        }
    }

    @media (max-width: 480px) {
        .login-card {
            padding: 1.5rem 1rem;
        }

        .register-title {
            font-size: 1.5rem;
        }

        .form-control, .form-select {
            padding: 0.875rem 1rem;
        }
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    const registerBtn = document.getElementById('registerBtn');

    // Form submission with loading animation
    if (registerForm && registerBtn) {
        registerForm.addEventListener('submit', function(e) {
            // Add loading state
            registerBtn.classList.add('btn-loading');
            registerBtn.disabled = true;

            // Store original text
            const originalText = registerBtn.innerHTML;

            // Reset if form validation fails
            setTimeout(() => {
                if (registerBtn.classList.contains('btn-loading')) {
                    registerBtn.classList.remove('btn-loading');
                    registerBtn.disabled = false;
                    registerBtn.innerHTML = originalText;
                }
            }, 5000);
        });
    }

    // Initialize password toggle tooltips
    const toggleButtons = ['togglePassword', 'togglePasswordConfirm'];
    toggleButtons.forEach(function(buttonId) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.setAttribute('title', 'Show password');
            button.setAttribute('aria-label', 'Show password');
        }
    });

    // Auto-focus on name field
    const nameField = document.getElementById('name');
    if (nameField) {
        nameField.focus();
    }

    // Real-time password confirmation validation
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password-confirm');

    if (passwordField && confirmPasswordField) {
        confirmPasswordField.addEventListener('input', function() {
            if (this.value && passwordField.value) {
                if (this.value === passwordField.value) {
                    this.style.borderColor = 'var(--sky-blue-500)';
                    this.style.backgroundColor = '#f0fdf4';
                } else {
                    this.style.borderColor = '#ef4444';
                    this.style.backgroundColor = '#fef2f2';
                }
            } else {
                this.style.borderColor = 'var(--sky-blue-200)';
                this.style.backgroundColor = 'rgba(240, 249, 255, 0.5)';
            }
        });
    }
});

// Enhanced password visibility toggle function
function togglePasswordVisibility(passwordFieldId, toggleButtonId) {
    const passwordField = document.getElementById(passwordFieldId);
    const toggleButton = document.getElementById(toggleButtonId);
    const toggleIcon = toggleButton.querySelector('i');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
        toggleButton.setAttribute('title', 'Hide password');
        toggleButton.setAttribute('aria-label', 'Hide password');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
        toggleButton.setAttribute('title', 'Show password');
        toggleButton.setAttribute('aria-label', 'Show password');
    }
}
</script>

<?php if(session('login_success')): ?>
    <script>
        window.addEventListener('load', function () {
            setTimeout(function() {
                const userName = <?php echo json_encode(session('user_name'), 15, 512) ?>;
                const redirectUrl = <?php echo json_encode(session('redirect_url'), 15, 512) ?>;

                if (typeof window.triggerLoginSuccess === 'function') {
                    window.triggerLoginSuccess('Registrasi berhasil! Selamat datang, ' + userName + '!');

                    setTimeout(function() {
                        window.location.href = redirectUrl;
                    }, 2100);
                } else if (typeof window.showAlert === 'function') {
                    window.showAlert('Registrasi Berhasil', 'Selamat datang, ' + userName + '!', 'success');

                    setTimeout(function() {
                        window.location.href = redirectUrl;
                    }, 2100);
                } else {
                    alert('Registrasi berhasil! Selamat datang, ' + userName + '!');
                    window.location.href = redirectUrl;
                }
            }, 100);
        });
    </script>
<?php endif; ?>

<?php if($errors->any()): ?>
    <script>
        window.addEventListener('load', function () {
            setTimeout(function() {
                if (typeof window.showAlert === 'function') {
                    window.showAlert('Error', 'Terdapat kesalahan dalam form. Silakan periksa kembali.', 'error');
                }
            }, 100);
        });
    </script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Integrasi KP\backoffice-fasya\resources\views/auth/register.blade.php ENDPATH**/ ?>