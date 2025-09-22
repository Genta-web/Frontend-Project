<?php $__env->startSection('title', 'Request Leave'); ?>

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

    .btn-clean {
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

    .btn-clean:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(3, 169, 244, 0.5);
        background: linear-gradient(135deg, #0288d1 0%, #03a9f4 50%, #29b6f6 100%);
        color: white;
    }

    .form-container {
        width: 100%;
        margin: 0;
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

    .employee-info {
        background: var(--light-blue);
        border: 1px solid rgba(14, 165, 233, 0.2);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
    }

    .employee-info-label {
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .employee-info-value {
        color: var(--text-dark);
        font-weight: 500;
        font-size: 1.125rem;
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

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-light);
    }

    .image-preview-container {
        margin-top: 1rem;
        padding: 1rem;
        background: var(--light-blue);
        border-radius: 12px;
        border: 1px solid rgba(14, 165, 233, 0.2);
    }

    .image-preview-item {
        background: var(--white);
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 8px rgba(14, 165, 233, 0.1);
    }

    .image-preview-item img {
        border-radius: 8px;
    }

    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
            text-align: center;
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

<div class="container-fluid">
    <div class="row">
        <main class="px-4">
            <!-- Page Header -->
            <div class="page-header d-flex flex-column flex-md-row justify-content-between align-items-center">
                <h1 class="page-title mb-3 mb-md-0" style="color: #fff;">
                    <i class="fas fa-calendar-plus me-3" style="color: #fff;"></i>
                    Request Leave
                </h1>
                <a href="<?php echo e(route('leave.index')); ?>" class="btn-clean primary" style="border-radius: 50px;">
                    <i class="fas fa-arrow-left me-1"></i>
                    Back to Leave
                </a>
            </div>

            <!-- Form Container -->
            <div class="form-container">
                <form action="<?php echo e(route('leave.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <!-- Employee Information Card -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <i class="fas fa-user"></i>
                                Employee Information
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <?php if(!Auth::user()->isEmployee()): ?>
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-users"></i>
                                    <h3>Select Employee</h3>
                                </div>
                                <div class="form-group">
                                    <label for="employee_id" class="form-label">
                                        <i class="fas fa-user"></i>
                                        Employee
                                        <span class="required">*</span>
                                    </label>
                                    <select class="form-select <?php $__errorArgs = ['employee_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="employee_id" name="employee_id" required>
                                        <option value="">Select Employee</option>
                                        <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($employee->id); ?>"
                                                    <?php echo e(old('employee_id') == $employee->id ? 'selected' : ''); ?>>
                                                <?php echo e($employee->name); ?> (<?php echo e($employee->employee_code); ?>)
                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['employee_id'];
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
                            <?php else: ?>
                            <input type="hidden" name="employee_id" value="<?php echo e(Auth::user()->employee->id ?? ''); ?>">
                            <div class="employee-info">
                                <div class="employee-info-label">
                                    <i class="fas fa-user me-2"></i>Employee Information
                                </div>
                                <div class="employee-info-value">
                                    <?php echo e(Auth::user()->employee->name ?? 'N/A'); ?>

                                    <small class="text-muted">(<?php echo e(Auth::user()->employee->employee_code ?? 'N/A'); ?>)</small>
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Leave Details Card -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <i class="fas fa-calendar-alt"></i>
                                Leave Details
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-list"></i>
                                    <h3>Leave Type & Duration</h3>
                                </div>

                                <div class="form-group">
                                    <label for="leave_type" class="form-label">
                                        <i class="fas fa-umbrella-beach"></i>
                                        Leave Type
                                        <span class="required">*</span>
                                    </label>
                                    <select class="form-select <?php $__errorArgs = ['leave_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="leave_type"
                                            name="leave_type"
                                            required>
                                        <option value="">Select Leave Type</option>
                                        <option value="annual" <?php echo e(old('leave_type') == 'annual' ? 'selected' : ''); ?>>Annual Leave</option>
                                        <option value="sick" <?php echo e(old('leave_type') == 'sick' ? 'selected' : ''); ?>>Sick Leave</option>
                                        <option value="emergency" <?php echo e(old('leave_type') == 'emergency' ? 'selected' : ''); ?>>Emergency Leave</option>
                                        <option value="maternity" <?php echo e(old('leave_type') == 'maternity' ? 'selected' : ''); ?>>Maternity Leave</option>
                                        <option value="paternity" <?php echo e(old('leave_type') == 'paternity' ? 'selected' : ''); ?>>Paternity Leave</option>
                                        <option value="personal" <?php echo e(old('leave_type') == 'personal' ? 'selected' : ''); ?>>Personal Leave</option>
                                    </select>
                                    <?php $__errorArgs = ['leave_type'];
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

                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="start_date" class="form-label">
                                            <i class="fas fa-calendar-plus"></i>
                                            Start Date
                                            <span class="required">*</span>
                                        </label>
                                        <input type="date"
                                               class="form-control <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="start_date"
                                               name="start_date"
                                               value="<?php echo e(old('start_date')); ?>"
                                               min="<?php echo e(date('Y-m-d')); ?>"
                                               required>
                                        <?php $__errorArgs = ['start_date'];
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
                                        <label for="end_date" class="form-label">
                                            <i class="fas fa-calendar-minus"></i>
                                            End Date
                                            <span class="required">*</span>
                                        </label>
                                        <input type="date"
                                               class="form-control <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                               id="end_date"
                                               name="end_date"
                                               value="<?php echo e(old('end_date')); ?>"
                                               min="<?php echo e(date('Y-m-d')); ?>"
                                               required>
                                        <?php $__errorArgs = ['end_date'];
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

                                <!-- Total Days Display -->
                                <div id="total_days_display" class="info-alert" style="display: none;">
                                    <div class="info-alert-header">
                                        <i class="fas fa-calculator"></i>
                                        Total Leave Days
                                    </div>
                                    <p id="total_days_text" style="margin: 0; font-size: 1.125rem; font-weight: 500;"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reason & Supporting Documents Card -->
                    <div class="form-card">
                        <div class="form-card-header">
                            <h2 class="form-card-title">
                                <i class="fas fa-comment-alt"></i>
                                Reason & Supporting Documents
                            </h2>
                        </div>
                        <div class="form-card-body">
                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-edit"></i>
                                    <h3>Leave Reason</h3>
                                </div>

                                <div class="form-group">
                                    <label for="reason" class="form-label">
                                        <i class="fas fa-comment"></i>
                                        Detailed Reason
                                        <span class="required">*</span>
                                    </label>
                                    <textarea class="form-control <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                              id="reason"
                                              name="reason"
                                              rows="4"
                                              placeholder="Please provide a detailed reason for your leave request..."
                                              required><?php echo e(old('reason')); ?></textarea>
                                    <?php $__errorArgs = ['reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Maximum 1000 characters. Be specific about your leave requirements.
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="section-header">
                                    <i class="fas fa-paperclip"></i>
                                    <h3>Supporting Documents</h3>
                                </div>

                                <div class="form-group">
                                    <label for="attachment" class="form-label">
                                        <i class="fas fa-file-upload"></i>
                                        Document Attachment
                                    </label>
                                    <input type="file"
                                           class="form-control <?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="attachment"
                                           name="attachment"
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif,.webp">
                                    <?php $__errorArgs = ['attachment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Optional. Upload supporting documents (PDF, DOC, DOCX, Images - Max 5MB)
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="images" class="form-label">
                                        <i class="fas fa-images"></i>
                                        Additional Images
                                    </label>
                                    <input type="file"
                                           class="form-control <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                           id="images"
                                           name="images[]"
                                           accept=".jpg,.jpeg,.png,.gif,.webp"
                                           multiple>
                                    <?php $__errorArgs = ['images.*'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Upload up to 5 images (JPG, PNG, GIF, WebP - Max 5MB each)
                                    </div>

                                    <!-- Image preview container -->
                                    <div id="imagePreviewContainer" class="image-preview-container" style="display: none;">
                                        <div class="row" id="imagePreviewRow"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Information Notice -->
                    <div class="info-alert">
                        <div class="info-alert-header">
                            <i class="fas fa-info-circle"></i>
                            Important Information
                        </div>
                        <p style="margin: 0; line-height: 1.6;">
                            Your leave request will be submitted for approval by management.
                            You will receive notifications about the status of your request via email and system notifications.
                            Please ensure all information is accurate before submitting.
                        </p>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions" style="display: flex; justify-content: flex-end; gap: 1.25rem; padding-top: 1rem; margin-bottom: 1.5rem; border-top: 1px solid var(--border-light); flex-wrap: wrap;">
                        <a href="<?php echo e(route('leave.index')); ?>" class="btn-modern btn-secondary-modern shadow-sm" style="min-width: 140px; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 1rem; font-weight: 600;">
                            <i class="fas fa-times"></i>
                            Cancel
                        </a>
                        <button type="submit" class="btn-modern btn-primary-modern shadow-sm" style="min-width: 170px; display: flex; align-items: center; justify-content: center; gap: 0.5rem; font-size: 1rem; font-weight: 600;">
                            <i class="fas fa-paper-plane"></i>
                            Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Date calculation functionality
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const totalDaysDisplay = document.getElementById('total_days_display');
    const totalDaysText = document.getElementById('total_days_text');

    function calculateDays() {
        const startDate = startDateInput.value;
        const endDate = endDateInput.value;

        if (startDate && endDate) {
            const start = new Date(startDate);
            const end = new Date(endDate);

            if (end >= start) {
                const timeDiff = end.getTime() - start.getTime();
                const daysDiff = Math.ceil(timeDiff / (1000 * 3600 * 24)) + 1;

                totalDaysDisplay.style.display = 'block';
                totalDaysText.textContent = `${daysDiff} day${daysDiff > 1 ? 's' : ''} requested`;
            } else {
                totalDaysDisplay.style.display = 'block';
                totalDaysText.textContent = 'Invalid date range - End date must be after start date';
                totalDaysText.style.color = 'var(--danger-red)';
            }
        } else {
            totalDaysDisplay.style.display = 'none';
        }
    }

    // Update end date minimum when start date changes
    startDateInput.addEventListener('change', function() {
        endDateInput.min = this.value;
        calculateDays();
    });

    endDateInput.addEventListener('change', calculateDays);

    // Character counter for reason
    const reasonTextarea = document.getElementById('reason');
    const maxLength = 1000;

    reasonTextarea.addEventListener('input', function() {
        const remaining = maxLength - this.value.length;
        const formText = this.parentNode.querySelector('.form-text');

        if (remaining < 100) {
            formText.innerHTML = `<i class="fas fa-exclamation-triangle me-1"></i>${remaining} characters remaining`;
            formText.className = remaining < 0 ? 'form-text text-danger' : 'form-text text-warning';
        } else {
            formText.innerHTML = '<i class="fas fa-info-circle me-1"></i>Maximum 1000 characters. Be specific about your leave requirements.';
            formText.className = 'form-text';
        }
    });

    // Image preview functionality
    const imageInput = document.getElementById('images');
    const previewContainer = document.getElementById('imagePreviewContainer');
    const previewRow = document.getElementById('imagePreviewRow');

    imageInput.addEventListener('change', function(e) {
        const files = Array.from(e.target.files);
        previewRow.innerHTML = '';

        if (files.length === 0) {
            previewContainer.style.display = 'none';
            return;
        }

        previewContainer.style.display = 'block';

        files.forEach((file, index) => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 col-sm-4 col-6 mb-3';

                    col.innerHTML = `
                        <div class="image-preview-item">
                            <img src="${e.target.result}"
                                 class="img-fluid"
                                 style="height: 150px; width: 100%; object-fit: cover;">
                            <div class="mt-2">
                                <small class="text-muted d-block">${file.name}</small>
                                <small class="text-muted">${(file.size / 1024).toFixed(1)} KB</small>
                            </div>
                        </div>
                    `;

                    previewRow.appendChild(col);
                };
                reader.readAsDataURL(file);
            }
        });
    });

    // Form enhancement
    const form = document.querySelector('form');
    const submitBtn = document.querySelector('.btn-primary-modern');

    // Add loading state to submit button
    form.addEventListener('submit', function() {
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Submitting...';
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
});

// Success/Error message handling
<?php if(session('success')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    });
<?php endif; ?>

<?php if(session('error')): ?>
    document.addEventListener('DOMContentLoaded', function() {
        const alertDiv = document.createElement('div');
        alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        alertDiv.innerHTML = `
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alertDiv);

        setTimeout(() => {
            alertDiv.remove();
        }, 5000);
    });
<?php endif; ?>
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\backoffice-fasya\resources\views/leave/create.blade.php ENDPATH**/ ?>