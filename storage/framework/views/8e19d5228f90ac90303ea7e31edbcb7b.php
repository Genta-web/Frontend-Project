<?php $__env->startSection('content'); ?>


<?php if(session('success')): ?>
<div class="popup-overlay" id="successPopup">
    <div class="popup-card">
        <div class="popup-icon success-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>
        <h2 class="popup-title">Success!</h2>
        <p class="popup-message"><?php echo e(session('success')); ?></p>
        <button class="popup-button" id="closeSuccessPopup">OK</button>
    </div>
</div>
<?php endif; ?>

<div class="popup-overlay" id="deleteWarningPopup" style="display: none;">
    <div class="popup-card">
        <div class="popup-icon warning-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </div>
        <h2 class="popup-title">Are You Sure?</h2>
        <p class="popup-message">Do you really want to delete "<strong><span id="documentTitleWarning"></span></strong>"? <br>This action is irreversible.</p>
        <div class="popup-button-group">
            <button class="popup-button cancel" id="cancelDeleteBtn">Cancel</button>
            <button class="popup-button delete" id="confirmDeleteBtn">Yes, Delete</button>
        </div>
    </div>
</div>

<form id="deleteForm" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
    <?php echo method_field('DELETE'); ?>
</form>



<style>
/* --- Popup --- */
.popup-overlay {
    position: fixed; top: 0; left: 0; width: 100%; height: 100%;
    background: rgba(0,0,0,0.55); display: flex; justify-content: center; align-items: center;
    z-index: 2000; padding: 20px; box-sizing: border-box;
}
.popup-card {
    background: #fff; padding: 2.5rem; border-radius: 1.5rem;
    box-shadow: 0 10px 30px rgba(0,0,0,0.13); text-align: center;
    max-width: 420px; width: 100%; animation: popup-animation 0.3s cubic-bezier(.18,.89,.32,1.28) forwards;
}
@keyframes popup-animation { to { opacity: 1; transform: scale(1); } }
.popup-icon { width: 80px; height: 80px; margin: 0 auto 1.5rem auto; border-radius: 50%; display: flex; justify-content: center; align-items: center; }
.popup-icon svg { width: 40px; height: 40px; }
.success-icon { background: #D1FAE5; }
.success-icon svg { color: #065F46; }
.warning-icon { background: #FEF3C7; }
.warning-icon svg { color: #92400E; }
.popup-title { font-size: 1.5rem; font-weight: 700; color: #1F2937; margin-bottom: 0.5rem; }
.popup-message { font-size: 1rem; color: #6B7280; margin-bottom: 2rem; line-height: 1.6; }
.popup-button-group { display: flex; gap: 1rem; }
.popup-button { width: 100%; padding: 0.8rem 1rem; border: none; border-radius: 0.75rem; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.popup-button.cancel { background: #E5E7EB; color: #374151; }
.popup-button.cancel:hover { background: #D1D5DB; }
.popup-button.delete { background: #EF4444; color: #fff; }
.popup-button.delete:hover { background: #DC2626; }
#closeSuccessPopup { background: #1F2937; color: #fff; }
#closeSuccessPopup:hover { background: #374151; }

/* --- Page Header --- */
.dashboard-header {
    background: linear-gradient(135deg, #03a9f4 0%, #0288d1 50%, #0277bd 100%);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(3, 169, 244, 0.4);
    position: relative;
    overflow: hidden;
}

.dashboard-header::before {
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

.dashboard-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.dashboard-subtitle {
    font-size: 1.1rem;
    opacity: 0.9;
    margin-bottom: 0;
}

.btn-custom {
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
}

.btn-custom:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(3, 169, 244, 0.5);
    background: linear-gradient(135deg, #0288d1 0%, #03a9f4 50%, #29b6f6 100%);
    color: white;
}

/* --- Card --- */
.content-card {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 4px 12px rgba(14,165,233,0.07);
    border: 1px solid #e2e8f0;
    overflow: hidden;
    margin-bottom: 2rem;
}
.card-body {
    padding: 2rem;
}

/* --- Table --- */
.table-responsive {
    overflow-x: auto;
    background: transparent;
    border-radius: 1rem;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* IE 10+ */
}
.table-responsive::-webkit-scrollbar { display: none; }
.table-modern {
    table-layout: auto;
    width: 100%;
    min-width: 700px;
    border-collapse: separate;
    border-spacing: 0;
}
.table-modern thead th {
    background: #e0f2fe;
    color: #0369a1;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.95rem;
    letter-spacing: 0.05em;
    padding: 1rem 1.5rem;
    border: none;
    border-bottom: 2px solid #e2e8f0;
}
.table-modern tbody tr { transition: all 0.2s; }
.table-modern tbody td {
    padding: 1.1rem 1.5rem;
    border-bottom: 1px solid #e2e8f0;
    vertical-align: middle;
    color: #1e293b;
    background: #fff;
    word-break: break-word;
}
.table-modern tbody tr:last-child td { border-bottom: none; }
.table-modern tbody tr:hover {
    background: #e0f2fe;
    box-shadow: 0 6px 18px rgba(14,165,233,0.09);
    z-index: 10;
    position: relative;
    transform: scale(1.01);
}
.document-title { font-weight: 600; color: #0369a1; }

/* --- Button Group --- */
.btn-group .btn {
    border-radius: 0.5rem !important;
    font-size: 0.98rem;
    padding: 0.5rem 0.9rem;
    transition: transform 0.15s;
}
.btn-group .btn:hover {
    transform: scale(1.08);
    z-index: 2;
}

/* --- Modal --- */
.modal-content {
    border-radius: 1rem;
    box-shadow: 0 8px 32px rgba(14,165,233,0.13);
}
.modal-header {
    border-bottom: 1px solid #e2e8f0;
    background: #e0f2fe;
    border-radius: 1rem 1rem 0 0;
}
.modal-title {
    color: #0369a1;
    font-weight: 700;
}
.modal-footer {
    border-top: 1px solid #e2e8f0;
    background: #f8fafc;
    border-radius: 0 0 1rem 1rem;
}

/* --- Responsive --- */
@media (max-width: 900px) {
    .card-body { padding: 1rem; }
    .table-modern { min-width: 500px; }
}
@media (max-width: 700px) {
    .table-modern { min-width: 400px; }
    .content-card { padding: 0.5rem; }
    .modal-content { padding: 0.5rem; }
}
</style>



<div class="container-fluid py-4">
    <main class="px-4">
        
        <div class="dashboard-header">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="dashboard-title">
                        <i class="fas fa-file-archive me-3"></i>Document Management
                    </h1>
                    <p class="dashboard-subtitle">
                        company documents in one place.
                    </p>
                </div>

                <div class="col-lg-4 text-lg-end">
                    <button type="button" class="btn btn-light btn-custom" data-bs-toggle="modal" data-bs-target="#createDocumentModal">
                        <i class="fas fa-file-alt me-2"></i>Add New Document
                    </button>
                </div>
            </div>
        </div>


        <div class="content-card mb-4">
            <div class="card-body">
                <form method="GET" action="<?php echo e(route('dokumen.index')); ?>" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label for="upload_date" class="form-label fw-bold">Upload Date</label>
                        <input type="date" id="upload_date" name="upload_date" class="form-control" value="<?php echo e(request('upload_date')); ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="uploader" class="form-label fw-bold">Uploader</label>
                        <input type="text" id="uploader" name="uploader" class="form-control" placeholder="Enter uploader username" value="<?php echo e(request('uploader')); ?>">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary btn-custom me-2">
                            <i class="fas fa-search me-1"></i>Filter
                        </button>
                        <a href="<?php echo e(route('dokumen.index')); ?>" class="btn btn-outline-secondary">
                            Reset
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="content-card mt-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-modern mb-0">
                        <thead>
                            <tr>
                                <th style="width: 5%;">#</th>
                                <th style="width: 25%;">Document Information</th>
                                <th style="width: 12%;">Upload Date</th>
                                <th style="width: 15%;">Uploader</th>
                                <th style="width: 23%;">Description</th>
                                <th class="text-center" style="width: 25%;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $dokumen; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><strong><?php echo e($loop->iteration); ?></strong></td>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <?php
                                                $extension = $item->file_extension ?: strtolower(pathinfo($item->path, PATHINFO_EXTENSION));
                                            ?>
                                            <?php if(in_array($extension, ['pdf'])): ?>
                                                <i class="fas fa-file-pdf text-danger me-3 fs-5 mt-1"></i>
                                            <?php elseif(in_array($extension, ['doc', 'docx'])): ?>
                                                <i class="fas fa-file-word text-primary me-3 fs-5 mt-1"></i>
                                            <?php elseif(in_array($extension, ['xls', 'xlsx'])): ?>
                                                <i class="fas fa-file-excel text-success me-3 fs-5 mt-1"></i>
                                            <?php elseif(in_array($extension, ['ppt', 'pptx'])): ?>
                                                <i class="fas fa-file-powerpoint text-warning me-3 fs-5 mt-1"></i>
                                            <?php elseif(in_array($extension, ['txt'])): ?>
                                                <i class="fas fa-file-alt text-secondary me-3 fs-5 mt-1"></i>
                                            <?php else: ?>
                                                <i class="fas fa-file text-muted me-3 fs-5 mt-1"></i>
                                            <?php endif; ?>
                                            <div style="word-wrap: break-word; word-break: break-word; white-space: normal; max-width: 100%;">
                                                <div class="document-title" style="word-wrap: break-word; word-break: break-word; white-space: normal; font-weight: 600;">
                                                    <?php echo e($item->title); ?>

                                                </div>
                                                <?php if($item->original_name): ?>
                                                    <small class="text-muted" style="word-wrap: break-word; word-break: break-all; white-space: normal; display: block; margin-top: 4px;">
                                                        <i class="fas fa-file me-1"></i><?php echo e($item->original_name); ?>

                                                        <?php if($item->file_size): ?>
                                                            <span class="ms-2">
                                                                <i class="fas fa-weight me-1"></i><?php echo e($item->formatted_file_size); ?>

                                                            </span>
                                                        <?php endif; ?>
                                                    </small>
                                                <?php else: ?>
                                                    <small class="text-muted" style="word-wrap: break-word; word-break: break-all; white-space: normal; display: block; margin-top: 4px;">
                                                        <i class="fas fa-file me-1"></i><?php echo e(basename($item->path)); ?>

                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?php echo e($item->created_at->format('d M Y')); ?></td>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <i class="fas fa-user-circle text-primary me-2 mt-1"></i>
                                            <div style="word-wrap: break-word; word-break: break-word; white-space: normal; max-width: 100%;">
                                                <div class="fw-semibold" style="word-wrap: break-word; word-break: break-word; white-space: normal;">
                                                    <?php echo e($item->uploader ? $item->uploader->username : 'Unknown'); ?>

                                                </div>
                                                <?php if($item->uploader): ?>
                                                    <small class="text-muted" style="word-wrap: break-word; word-break: break-all; white-space: normal;">
                                                        <?php echo e($item->uploader->email ?? ''); ?>

                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-muted" style="word-wrap: break-word; white-space: normal; max-width: 200px;">
                                        <?php echo e($item->description ?? 'No description provided.'); ?>

                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Document Actions">
                                            <a href="<?php echo e(route('dokumen.show', $item->id)); ?>" class="btn btn-sm btn-outline-info" data-bs-toggle="tooltip" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('dokumen.download', $item->id)); ?>" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Download">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            <a href="<?php echo e(route('dokumen.edit', $item->id)); ?>" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="confirmDelete(<?php echo e($item->id); ?>, '<?php echo e(addslashes($item->title)); ?>')" data-bs-toggle="tooltip" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="text-muted">
                                            <i class="fas fa-folder-open fa-4x mb-3" style="color: #e0f2fe;"></i>
                                            <h5 class="fw-bold">No Documents Found</h5>
                                            <p>Start by adding your first document using the button above.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>


<div class="modal fade" id="createDocumentModal" tabindex="-1" aria-labelledby="createDocumentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form action="<?php echo e(route('dokumen.store')); ?>" method="POST" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="createDocumentModalLabel"><i class="fas fa-plus-circle me-2"></i>Add New Document</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <div class="mb-3">
                        <label for="title" class="form-label fw-bold">Document Title <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo e(old('title')); ?>" required placeholder="e.g., Q3 Financial Report">
                        <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                     <div class="mb-3">
                        <label for="path" class="form-label fw-bold">Document File <span class="text-danger">*</span></label>
                        <input type="file" class="form-control" id="path" name="path" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt" required>
                        <div class="form-text mt-2"><i class="fas fa-info-circle me-1"></i>Supported formats: PDF, DOC(X), XLS(X), PPT(X), TXT. Max size: 10MB.</div>
                        <?php $__errorArgs = ['path'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                     <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" placeholder="Enter a brief description (optional)"><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="invalid-feedback d-block"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn text-white" style="background-color: #ff3f3f;" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary btn-custom"><i class="fas fa-save me-2"></i>Save Document</button>
                </div>
            </form>
        </div>
    </div>
</div>




<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Bootstrap Tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // === Logika untuk Pop-up Sukses ===
    const successPopup = document.getElementById('successPopup');
    if (successPopup) {
        const closeSuccessBtn = document.getElementById('closeSuccessPopup');
        const closeThePopup = () => {
            successPopup.style.display = 'none';
        };
        closeSuccessBtn.addEventListener('click', closeThePopup);
        successPopup.addEventListener('click', function(event) {
            if (event.target === this) {
                closeThePopup();
            }
        });
    }

    // === Logika untuk Pop-up Peringatan Hapus ===
    const warningPopup = document.getElementById('deleteWarningPopup');
    const deleteForm = document.getElementById('deleteForm');
    const documentTitleSpan = document.getElementById('documentTitleWarning');
    const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
    const cancelDeleteBtn = document.getElementById('cancelDeleteBtn');

    window.confirmDelete = function(id, title) {
        // === PENYESUAIAN KUNCI ADA DI SINI ===
        // URL disesuaikan menjadi 'management-document' agar cocok dengan web.php
        deleteForm.action = `<?php echo e(url('management-document')); ?>/${id}`;

        documentTitleSpan.textContent = title;
        warningPopup.style.display = 'flex';
    };

    const hideWarningPopup = () => {
        warningPopup.style.display = 'none';
    };

    cancelDeleteBtn.addEventListener('click', hideWarningPopup);
    confirmDeleteBtn.addEventListener('click', () => {
        deleteForm.submit();
    });
    warningPopup.addEventListener('click', function(event) {
        if (event.target === this) {
            hideWarningPopup();
        }
    });
});
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Gitlab\backoffice-fasya\resources\views/manajemen-dokumen/index.blade.php ENDPATH**/ ?>