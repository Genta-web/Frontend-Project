<?php $__env->startSection('title', 'Forgot Password'); ?>

<style>
    body {
        background: linear-gradient(135deg, #87CEEB 0%, #E0F6FF 50%, #FFFFFF 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .forgot-password-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .forgot-password-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 3rem;
        width: 100%;
        max-width: 500px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .forgot-password-title {
        text-align: center;
        margin-bottom: 2rem;
        color: #333;
        font-weight: 600;
        font-size: 1.8rem;
    }

    .forgot-password-subtitle {
        text-align: center;
        margin-bottom: 2rem;
        color: #666;
        font-size: 1rem;
        line-height: 1.5;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e1e5e9;
        padding: 12px 15px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #87CEEB;
        box-shadow: 0 0 0 0.2rem rgba(135, 206, 235, 0.25);
    }

    .btn-sky {
        background: linear-gradient(135deg, #87CEEB 0%, #5DADE2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 16px;
    }

    .btn-sky:hover {
        background: linear-gradient(135deg, #5DADE2 0%, #3498DB 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(135, 206, 235, 0.4);
        color: white;
    }

    .btn-sky:focus {
        box-shadow: 0 0 0 0.2rem rgba(135, 206, 235, 0.5);
        color: white;
    }

    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .back-to-login {
        text-align: center;
        margin-top: 1.5rem;
    }

    .back-to-login a {
        color: #87CEEB;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .back-to-login a:hover {
        color: #5DADE2;
        text-decoration: underline;
    }

    .icon-container {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .icon-container i {
        font-size: 3rem;
        color: #87CEEB;
        opacity: 0.8;
    }

    @media (max-width: 576px) {
        .forgot-password-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }

        .forgot-password-title {
            font-size: 1.5rem;
        }
    }
</style>

<?php $__env->startSection('content'); ?>
<div class="forgot-password-container">
    <div class="forgot-password-card">
        <div class="icon-container">
            <i class="fas fa-key"></i>
        </div>

        <h3 class="forgot-password-title"><?php echo e(__('Reset Password')); ?></h3>

        <p class="forgot-password-subtitle">
            <?php echo e(__('Enter your username to verify your account and reset your password.')); ?>

        </p>

        <?php if(session('status')): ?>
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong><?php echo e(__('Email Sent!')); ?></strong> <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong><?php echo e(__('Error!')); ?></strong>
                <ul class="mb-0 mt-2">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('password.verify-user')); ?>" id="verifyUserForm">
            <?php echo csrf_field(); ?>

            <div class="form-group mb-3">
                <label for="username" class="form-label"><?php echo e(__('Username')); ?></label>
                <input id="username" type="text"
                       class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                       name="username"
                       value="<?php echo e(old('username')); ?>"
                       required
                       autocomplete="username"
                       autofocus
                       placeholder="Enter your username">

                <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span class="text-danger small mt-1"><?php echo e($message); ?></span>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group mb-3">
                <button type="submit" class="btn btn-sky" id="submitBtn">
                    <i class="fas fa-search me-2"></i>
                    <?php echo e(__('Verify Account')); ?>

                </button>
            </div>
        </form>

        <div class="back-to-login">
            <a href="<?php echo e(route('login')); ?>">
                <i class="fas fa-arrow-left me-1"></i>
                <?php echo e(__('Back to Login')); ?>

            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forgotPasswordForm');
    const submitBtn = document.getElementById('submitBtn');

    if (form) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitBtn.disabled = true;

            // Re-enable button after 10 seconds in case of network issues
            setTimeout(function() {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send Reset Link';
                    submitBtn.disabled = false;
                }
            }, 10000);
        });
    }

    // Auto-hide success message after 10 seconds
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(function() {
                successAlert.remove();
            }, 500);
        }, 10000);
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Integrasi KP\backoffice-fasya\resources\views/auth/passwords/email.blade.php ENDPATH**/ ?>