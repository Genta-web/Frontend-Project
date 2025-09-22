<?php $__env->startSection('content'); ?>
<style>
    :root {
        --primary-blue: #0ea5e9;
        --light-blue: #e0f2fe;
        --dark-blue: #0284c7;
        --sky-blue: #38bdf8;
        --white: #ffffff;
        --light-gray: #f8fafc;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --border-light: #e2e8f0;
        --success-green: #10b981;
        --warning-orange: #f59e0b;
        --danger-red: #ef4444;
    }

    body {
        background-color: var(--light-gray);
    }

    .page-header {
        background: linear-gradient(135deg, #03a9f4 0%, #0288d1 50%, #0277bd 100%);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(3, 169, 244, 0.4);
        position: relative;
        overflow: hidden;
    }

    .page-header::before {
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

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
        position: relative;
        z-index: 2;
    }

    .btn-header {
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
        text-decoration: none;
    }

    .btn-header:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(3, 169, 244, 0.5);
        background: linear-gradient(135deg, #0288d1 0%, #03a9f4 50%, #29b6f6 100%);
        color: white;
    }

    .form-container {
        max-width: 900px;
        margin: 0 auto;
    }

    .form-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        border: 1px solid var(--border-light);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .form-card-header {
        background: linear-gradient(135deg, var(--light-blue), rgba(14, 165, 233, 0.1));
        padding: 2rem;
        border-bottom: 1px solid var(--border-light);
    }

    .form-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .form-card-title i {
        color: var(--primary-blue);
        font-size: 1.25rem;
    }

    .form-card-body {
        padding: 2.5rem;
    }

    .form-section {
        margin-bottom: 2.5rem;
    }

    .form-section:last-child {
        margin-bottom: 0;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--light-blue);
    }

    .section-header i {
        color: var(--primary-blue);
        font-size: 1.125rem;
    }

    .section-header h3 {
        color: var(--text-dark);
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .form-label i {
        color: var(--primary-blue);
        width: 16px;
    }

    .required {
        color: var(--danger-red);
        margin-left: 0.25rem;
    }

    .form-control, .form-select {
        border: 2px solid var(--border-light);
        border-radius: 12px;
        padding: 0.875rem 1rem;
        font-size: 1rem;
        transition: all 0.3s ease;
        background-color: var(--white);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        background-color: var(--light-blue);
    }

    .form-control.is-invalid, .form-select.is-invalid {
        border-color: var(--danger-red);
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.1);
    }

    .invalid-feedback {
        color: var(--danger-red);
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .invalid-feedback::before {
        content: '\f071';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
    }

    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
    }

    .info-alert {
        background: linear-gradient(135deg, var(--light-blue), rgba(14, 165, 233, 0.05));
        border: 1px solid rgba(14, 165, 233, 0.2);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .info-alert-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: var(--primary-blue);
        font-weight: 600;
        font-size: 1.125rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
    }

    .info-label {
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.875rem;
    }

    .info-value {
        color: var(--text-dark);
        font-weight: 500;
    }

    .status-badge {
        padding: 0.375rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-success { background: #dcfce7; color: #166534; }
    .status-warning { background: #fef3c7; color: #92400e; }
    .status-info { background: #dbeafe; color: #1e40af; }
    .status-danger { background: #fee2e2; color: #991b1b; }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-light);
    }

    .btn-modern {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        position: relative;
        overflow: hidden;
    }

    .btn-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
        transition: left 0.5s;
    }

    .btn-modern:hover::before {
        left: 100%;
    }

    .btn-primary-modern {
        background: linear-gradient(135deg, var(--primary-blue), var(--sky-blue));
        color: white;
    }

    .btn-primary-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(14, 165, 233, 0.3);
        color: white;
    }

    .btn-secondary-modern {
        background: var(--white);
        color: var(--text-muted);
        border: 2px solid var(--border-light);
    }

    .btn-secondary-modern:hover {
        background: var(--light-gray);
        color: var(--text-dark);
        border-color: var(--primary-blue);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
            text-align: center;
        }

        .page-title {
            font-size: 1.75rem;
        }

        .header-actions {
            flex-direction: column;
            align-items: center;
        }

        .form-card-body {
            padding: 1.5rem;
        }

        .form-row {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .form-actions {
            flex-direction: column-reverse;
        }

        .btn-modern {
            justify-content: center;
        }
    }
</style>


<div class="container-fluid py-4" style="max-width: 100vw;">
    <!-- Page Header -->
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
                <div class="pe-3">
                    <h1 class="mb-2" style="font-size: 2rem; font-weight: 700; color: #fff;">
                        <i class="fas fa-edit me-3"></i>
                        Edit Employee
                    </h1>
                    <p class="mb-0" style="opacity: 0.9; color: #fff;">Update employee information and details</p>
                </div>
                    <div class="header-actions" style="display:flex; gap:1rem; justify-content:flex-end; flex:1; width:100%;">
                <a href="<?php echo e(route('employees.show', $employee->id)); ?>" class="btn-header">
                    <i class="fas fa-eye"></i> View Profile
                </a>
                <a href="<?php echo e(route('employees.index')); ?>" class="btn-header">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

    <!-- Basic Information Card -->
    <div class="form-card" style="margin-bottom: 2.5rem;">
        <div class="form-card-header">
            <h2 class="form-card-title">
                <i class="fas fa-user"></i>
                Basic Information
            </h2>
        </div>
        <div class="form-card-body">
            <form method="POST" action="<?php echo e(route('employees.update', $employee)); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-id-card"></i>
                        <h3>Employee Identification</h3>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="employee_code" class="form-label">
                                <i class="fas fa-barcode"></i>
                                Employee Code
                                <span class="required">*</span>
                            </label>
                            <input type="text"
                                   class="form-control <?php $__errorArgs = ['employee_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   id="employee_code"
                                   name="employee_code"
                                   value="<?php echo e(old('employee_code', $employee->employee_code)); ?>"
                                   required
                                   placeholder="Enter employee code">
                            <?php $__errorArgs = ['employee_code'];
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
                        <div class="form-group">
                            <label for="status" class="form-label">
                                <i class="fas fa-toggle-on"></i>
                                Employment Status
                                <span class="required">*</span>
                            </label>
                            <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    id="status"
                                    name="status"
                                    required>
                                <option value="">Select Status</option>
                                <option value="active" <?php echo e(old('status', $employee->status) == 'active' ? 'selected' : ''); ?>>Active</option>
                                <option value="inactive" <?php echo e(old('status', $employee->status) == 'inactive' ? 'selected' : ''); ?>>Inactive</option>
                            </select>
                            <?php $__errorArgs = ['status'];
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
                    </div>
                </div>
                <div class="form-section">
                    <div class="section-header">
                        <i class="fas fa-user-circle"></i>
                        <h3>Personal Details</h3>
                    </div>
                    <div class="form-group">
                        <label for="name" class="form-label">
                            <i class="fas fa-user"></i>
                            Full Name
                            <span class="required">*</span>
                        </label>
                        <input type="text"
                               class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               id="name"
                               name="name"
                               value="<?php echo e(old('name', $employee->name)); ?>"
                               required
                               placeholder="Enter full name">
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
                </div>
                <!-- Form Actions (for this section only) -->
                <div class="form-actions" style="justify-content: flex-start;">
                    <button type="submit" class="btn-modern btn-primary-modern">
                        <i class="fas fa-save"></i>
                        Update Employee
                    </button>
                    <a href="<?php echo e(route('employees.index')); ?>" class="btn-modern btn-secondary-modern">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Section: Contact Information, Employment Details, User Account, etc. -->
    <div class="form-container" style="max-width: 100vw; margin-top: 2.5rem;">
        <form method="POST" action="<?php echo e(route('employees.update', $employee)); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>
            <!-- Contact Information Card -->

                    <!-- Contact Information Card -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <i class="fas fa-address-book"></i>
                                Contact Information
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-envelope"></i>
                                    <h3>Communication Details</h3>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="email" class="form-label">
                                            <i class="fas fa-envelope"></i>
                                            Email Address
                                            <span class="required">*</span>
                                        </label>
                                        <input type="email"
                                               class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="email"
                                               name="email"
                                               value="<?php echo e(old('email', $employee->email)); ?>"
                                               required
                                               placeholder="Enter email address">
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

                                    <div class="form-group">
                                        <label for="phone" class="form-label">
                                            <i class="fas fa-phone"></i>
                                            Phone Number
                                        </label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="phone"
                                               name="phone"
                                               value="<?php echo e(old('phone', $employee->phone)); ?>"
                                               placeholder="Enter phone number">
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Employment Details Card -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <i class="fas fa-briefcase"></i>
                                Employment Details
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-building"></i>
                                    <h3>Work Information</h3>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="department" class="form-label">
                                            <i class="fas fa-building"></i>
                                            Department
                                            <span class="required">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['department'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="department"
                                               name="department"
                                               value="<?php echo e(old('department', $employee->department)); ?>"
                                               required
                                               placeholder="Enter department">
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

                                    <div class="form-group">
                                        <label for="position" class="form-label">
                                            <i class="fas fa-user-tie"></i>
                                            Position
                                            <span class="required">*</span>
                                        </label>
                                        <input type="text"
                                               class="form-control <?php $__errorArgs = ['position'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="position"
                                               name="position"
                                               value="<?php echo e(old('position', $employee->position)); ?>"
                                               required
                                               placeholder="Enter position">
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
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-calendar-plus"></i>
                                    <h3>Employment Timeline</h3>
                                </div>
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="hire_date" class="form-label">
                                            <i class="fas fa-calendar-plus"></i>
                                            Hire Date
                                            <span class="required">*</span>
                                        </label>
                                        <input type="date"
                                               class="form-control <?php $__errorArgs = ['hire_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="hire_date"
                                               name="hire_date"
                                               value="<?php echo e(old('hire_date', $employee->hire_date ? $employee->hire_date->format('Y-m-d') : '')); ?>"
                                               required>
                                        <?php $__errorArgs = ['hire_date'];
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
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Account Information Card -->
                    <?php if($employee->user): ?>
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <i class="fas fa-user-cog"></i>
                                User Account Information
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="info-alert">
                                <div class="info-alert-header">
                                    <i class="fas fa-info-circle"></i>
                                    System Access Details
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">Username</div>
                                        <div class="info-value"><?php echo e($employee->user->username); ?></div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">System Role</div>
                                        <div class="info-value">
                                            <span class="status-badge status-info"><?php echo e(ucfirst($employee->user->role)); ?></span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Account Status</div>
                                        <div class="info-value">
                                            <span class="status-badge status-<?php echo e($employee->user->is_active ? 'success' : 'danger'); ?>">
                                                <?php echo e($employee->user->is_active ? 'Active' : 'Inactive'); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Last Login</div>
                                        <div class="info-value">
                                            <?php echo e($employee->user->last_login ? $employee->user->last_login->format('M d, Y H:i') : 'Never logged in'); ?>

                                        </div>
                                    </div>
                                </div>
                                <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(14, 165, 233, 0.2);">
                                    <small style="color: var(--text-muted); display: flex; align-items: center; gap: 0.5rem;">
                                        <i class="fas fa-info-circle"></i>
                                        User account settings can be managed separately through the user management section.
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <i class="fas fa-user-slash"></i>
                                User Account Status
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="info-alert" style="background: linear-gradient(135deg, #fef3c7, rgba(245, 158, 11, 0.05)); border-color: rgba(245, 158, 11, 0.2);">
                                <div class="info-alert-header" style="color: var(--warning-orange);">
                                    <i class="fas fa-exclamation-triangle"></i>
                                    No User Account
                                </div>
                                <p style="margin: 0; color: var(--text-muted);">
                                    This employee does not have a user account for system access.
                                    A user account can be created separately if needed.
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="<?php echo e(route('employees.index')); ?>" class="btn-modern btn-secondary-modern">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn-modern btn-primary-modern">
                            <i class="fas fa-save"></i>
                            Update Employee
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation enhancement
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('.btn-primary-modern');

    // Add loading state to submit button
    form.addEventListener('submit', function() {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating...';
        submitBtn.disabled = true;
    });

    // Enhanced form field interactions
    const formControls = document.querySelectorAll('.form-control, .form-select');

    formControls.forEach(control => {
        // Add focus effects
        control.addEventListener('focus', function() {
            this.parentElement.style.transform = 'translateY(-2px)';
            this.parentElement.style.transition = 'transform 0.3s ease';
        });

        control.addEventListener('blur', function() {
            this.parentElement.style.transform = 'translateY(0)';
        });

        // Real-time validation feedback
        control.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            } else {
                this.classList.remove('is-valid');
            }
        });
    });

    // Animate form cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);

    // Observe form cards for animation
    document.querySelectorAll('.form-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });

    // Auto-save draft functionality (optional)
    let autoSaveTimeout;
    formControls.forEach(control => {
        control.addEventListener('input', function() {
            clearTimeout(autoSaveTimeout);
            autoSaveTimeout = setTimeout(() => {
                // Could implement auto-save to localStorage here
                console.log('Auto-saving draft...');
            }, 2000);
        });
    });

    // Confirm navigation away with unsaved changes
    let formChanged = false;
    formControls.forEach(control => {
        control.addEventListener('change', () => formChanged = true);
    });

    window.addEventListener('beforeunload', function(e) {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // Reset form changed flag on submit
    form.addEventListener('submit', () => formChanged = false);
});
</script>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\backoffice-fasya\resources\views/employees/edit.blade.php ENDPATH**/ ?>