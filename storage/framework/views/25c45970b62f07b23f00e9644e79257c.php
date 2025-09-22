<?php $__env->startSection('title', 'Add Work Log'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .work-logs-container {
        padding: 1.5rem;
        background-color: #f8f9fa;
        min-height: calc(100vh - 120px);
    }


    body { background: #f8fafc; }
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s cubic-bezier(.4,0,.2,1) forwards;
    }
    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: none;
        }
    }

    .page-header-card {
        background: linear-gradient(135deg, #03a9f4 0%, #0288d1 50%, #0277bd 100%);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(3, 169, 244, 0.4);
        position: relative;
        overflow: hidden;
    }

    .page-header-card::before {
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

    .worklog-form-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(74,144,226,0.08);
        border: 1px solid #e8edf2;
        overflow: hidden;
        margin-bottom: 2rem;
        transition: box-shadow 0.3s, transform 0.3s;
    }
    .worklog-form-card.fade-in {
        animation-delay: 0.3s;
    }
    .worklog-form-header {
        background: linear-gradient(135deg, #e0f2fe, rgba(74,144,226,0.08));
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e8edf2;
        display: flex;
        align-items: center;
        gap: 0.7rem;
        transition: background 0.3s;
    }
    .worklog-form-header.fade-in {
        animation-delay: 0.5s;
    }
    .worklog-form-header h6 {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
        color: #333A45;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .worklog-form-header i {
        color: #4A90E2;
        font-size: 1.3rem;
    }
    .worklog-form-body {
        padding: 2rem;
        transition: background 0.3s;
    }
    .form-label strong, .form-label i {
        color: #4A90E2;
    }
    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid #e8edf2;
        padding: 0.9rem 1.1rem;
        font-size: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.3s;
        background: #f8fafc;
    }
    .form-control:focus, .form-select:focus {
        border-color: #4A90E2;
        box-shadow: 0 0 0 3px rgba(74,144,226,0.12);
        background: #e0f2fe;
    }
    .form-text, .invalid-feedback { color: #3A7BC8; }
    .btn-primary, .btn-secondary {
        border-radius: 12px;
        font-weight: 600;
        padding: 0.7rem 1.5rem;
        font-size: 1rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .btn-primary { background: linear-gradient(135deg, #4A90E2, #50E3C2); color: #fff; border: none; }
    .btn-primary:hover { background: #3A7BC8; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(74,144,226,0.13); }
    .btn-secondary { background: #e0f2fe; color: #4A90E2; border: none; }
    .btn-secondary:hover { background: #4A90E2; color: #fff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(74,144,226,0.13); }
</style>
<div class="work-logs-container">
    <div>
        <div class="page-header-card">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="page-title">
                        <i class="fas fa-tasks me-2" style="color: #fff;"></i>Add Work Log
                    </h1>
                    <p class="page-subtitle">
                        Record your daily work activities
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <a href="<?php echo e(route('worklogs.index')); ?>" class="btn-clean primary" style="border-radius: 50px;">
                        <i class="fas fa-arrow-left me-1"></i>
                        Back to Work Logs
                    </a>
                </div>
            </div>
        </div>


        <div class="worklog-form-card fade-in">
            <div class="worklog-form-header fade-in">
                <h6><i class="fas fa-plus"></i> Work Log Information</h6>
            </div>
            <div class="worklog-form-body">
                <form action="<?php echo e(route('worklogs.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php if(!Auth::user()->hasRole('employee')): ?>
                    <div class="mb-3">
                        <label for="employee_id" class="form-label">
                            <strong>Employee</strong> <span class="text-danger">*</span>
                        </label>
                        <select class="form-control <?php $__errorArgs = ['employee_id'];
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
                    <?php else: ?>
                    <input type="hidden" name="employee_id" value="<?php echo e(Auth::user()->employee->id ?? ''); ?>">
                    <div class="mb-3">
                        <label class="form-label"><strong>Employee</strong></label>
                        <div class="form-control-plaintext">
                            <strong><?php echo e(Auth::user()->employee->name ?? 'N/A'); ?></strong>
                            <small class="text-muted">(<?php echo e(Auth::user()->employee->employee_code ?? 'N/A'); ?>)</small>
                        </div>
                    </div>
                    <?php endif; ?>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="work_date" class="form-label">
                                    <strong>Work Date</strong> <span class="text-danger">*</span>
                                </label>
                                <input type="date"
                                       class="form-control <?php $__errorArgs = ['work_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="work_date" name="work_date"
                                       value="<?php echo e(old('work_date', date('Y-m-d'))); ?>"
                                       max="<?php echo e(date('Y-m-d')); ?>"
                                       required>
                                <?php $__errorArgs = ['work_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">Cannot be future date</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="start_time" class="form-label">
                                    <strong>Start Time</strong> <span class="text-danger">*</span>
                                </label>
                                <input type="time"
                                       class="form-control <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="start_time" name="start_time"
                                       value="<?php echo e(old('start_time')); ?>"
                                       required>
                                <?php $__errorArgs = ['start_time'];
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
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="end_time" class="form-label">
                                    <strong>End Time</strong> <span class="text-danger">*</span>
                                </label>
                                <input type="time"
                                       class="form-control <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="end_time" name="end_time"
                                       value="<?php echo e(old('end_time')); ?>"
                                       required>
                                <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">Must be after start time</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="status" class="form-label">
                                    <strong>Status</strong> <span class="text-danger">*</span>
                                </label>
                                <select class="form-control <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        id="status" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="ongoing" <?php echo e(old('status') == 'ongoing' ? 'selected' : ''); ?>>Ongoing</option>
                                    <option value="in_progress" <?php echo e(old('status') == 'in_progress' ? 'selected' : ''); ?>>In Progress</option>
                                    <option value="done" <?php echo e(old('status') == 'done' ? 'selected' : ''); ?>>Done</option>
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
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="attachment_image" class="form-label">
                                    <strong>Attachment Image</strong>
                                </label>
                                <input type="file"
                                       class="form-control <?php $__errorArgs = ['attachment_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                       id="attachment_image" name="attachment_image"
                                       accept="image/*">
                                <?php $__errorArgs = ['attachment_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="form-text">Optional. Max 2MB (JPEG, PNG, JPG)</div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="task_summary" class="form-label">
                            <strong>Task Summary</strong> <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control <?php $__errorArgs = ['task_summary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="task_summary" name="task_summary" rows="4"
                                  placeholder="Describe the work activities performed during this time period..."
                                  required><?php echo e(old('task_summary')); ?></textarea>
                        <?php $__errorArgs = ['task_summary'];
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
                            <span id="task-char-count">0</span> / 2000 characters
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="action_details" class="form-label">
                            <strong>Action Details</strong>
                        </label>
                        <textarea class="form-control <?php $__errorArgs = ['action_details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                  id="action_details" name="action_details" rows="3"
                                  placeholder="Describe specific actions taken or next steps required..."><?php echo e(old('action_details')); ?></textarea>
                        <?php $__errorArgs = ['action_details'];
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
                            Optional. <span id="action-char-count">0</span> / 1000 characters
                        </div>
                    </div>

                    <!-- Duration Display -->
                    <div class="mb-3">
                        <label class="form-label"><strong>Duration</strong></label>
                        <div class="form-control-plaintext">
                            <span id="duration-display" class="badge bg-info">
                                <i class="fas fa-clock me-1"></i>
                                <span id="duration-text">Select start and end time</span>
                            </span>
                        </div>
                    </div>

                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Status Guide:</strong>
                        <ul class="mb-0 mt-2">
                            <li><strong>Ongoing:</strong> Work has started but not yet in active progress</li>
                            <li><strong>In Progress:</strong> Actively working on the task</li>
                            <li><strong>Done:</strong> Task has been completed</li>
                        </ul>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <a href="<?php echo e(route('worklogs.index')); ?>" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times me-1"></i> Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Save Work Log
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
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const durationText = document.getElementById('duration-text');
    const taskSummaryTextarea = document.getElementById('task_summary');
    const actionDetailsTextarea = document.getElementById('action_details');
    const taskCharCount = document.getElementById('task-char-count');
    const actionCharCount = document.getElementById('action-char-count');

    // Calculate and display duration
    function calculateDuration() {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;

        if (startTime && endTime) {
            const start = new Date(`2000-01-01 ${startTime}`);
            const end = new Date(`2000-01-01 ${endTime}`);

            if (end > start) {
                const diffMs = end - start;
                const diffHours = Math.floor(diffMs / (1000 * 60 * 60));
                const diffMinutes = Math.floor((diffMs % (1000 * 60 * 60)) / (1000 * 60));

                durationText.textContent = `${diffHours}h ${diffMinutes}m`;
            } else {
                durationText.textContent = 'Invalid time range';
            }
        } else {
            durationText.textContent = 'Select start and end time';
        }
    }

    // Update character count
    function updateTaskCharCount() {
        const length = taskSummaryTextarea.value.length;
        taskCharCount.textContent = length;

        if (length > 1800) {
            taskCharCount.parentElement.className = 'form-text text-warning';
        } else if (length > 2000) {
            taskCharCount.parentElement.className = 'form-text text-danger';
        } else {
            taskCharCount.parentElement.className = 'form-text';
        }
    }

    function updateActionCharCount() {
        const length = actionDetailsTextarea.value.length;
        actionCharCount.textContent = length;

        if (length > 800) {
            actionCharCount.parentElement.className = 'form-text text-warning';
        } else if (length > 1000) {
            actionCharCount.parentElement.className = 'form-text text-danger';
        } else {
            actionCharCount.parentElement.className = 'form-text';
        }
    }

    // Validate end time is after start time
    function validateTimeRange() {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;

        if (startTime && endTime && endTime <= startTime) {
            alert('End time must be after start time');
            endTimeInput.value = '';
            calculateDuration();
        }
    }

    // Event listeners
    startTimeInput.addEventListener('change', calculateDuration);
    endTimeInput.addEventListener('change', function() {
        validateTimeRange();
        calculateDuration();
    });

    taskSummaryTextarea.addEventListener('input', updateTaskCharCount);
    actionDetailsTextarea.addEventListener('input', updateActionCharCount);

    // Initialize
    calculateDuration();
    updateTaskCharCount();
    updateActionCharCount();

    // Auto-fill current time for start time
    if (!startTimeInput.value) {
        const now = new Date();
        const timeString = now.toTimeString().slice(0, 5);
        startTimeInput.value = timeString;
        calculateDuration();
    }
});
</script>

<?php if(session('success')): ?>
    <script>
        window.addEventListener('load', function () {
            setTimeout(function() {
                if (typeof window.showAlert === 'function') {
                    window.showAlert('Berhasil', <?php echo json_encode(session('success'), 15, 512) ?>, 'success');
                } else {
                    alert(<?php echo json_encode(session('success'), 15, 512) ?>);
                }
            }, 100);
        });
    </script>
<?php endif; ?>

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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Integrasi KP\backoffice-fasya\resources\views/worklogs/create.blade.php ENDPATH**/ ?>