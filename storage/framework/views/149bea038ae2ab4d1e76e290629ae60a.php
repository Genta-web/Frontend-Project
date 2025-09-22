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

    .content-container {
        width: 100%;
        margin: 0;
    }

    .content-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        border: 1px solid var(--border-light);
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .content-card-header {
        background: linear-gradient(135deg, var(--light-blue), rgba(14, 165, 233, 0.1));
        padding: 2rem;
        border-bottom: 1px solid var(--border-light);
    }

    .content-card-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .content-card-title i {
        color: var(--primary-blue);
        font-size: 1.25rem;
    }

    .content-card-body {
        padding: 2.5rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .info-label {
        font-weight: 600;
        color: var(--text-muted);
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .info-label i {
        color: var(--primary-blue);
        width: 16px;
    }

    .info-value {
        color: var(--text-dark);
        font-weight: 500;
        font-size: 1.125rem;
    }

    .file-preview {
        background: var(--light-blue);
        border: 1px solid rgba(14, 165, 233, 0.2);
        border-radius: 16px;
        padding: 2rem;
        text-align: center;
        margin: 2rem 0;
    }

    .file-icon {
        font-size: 4rem;
        color: var(--primary-blue);
        margin-bottom: 1rem;
    }

    .btn-modern {
        padding: 0.875rem 2rem;
        border-radius: 12px;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
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

    .btn-success-modern {
        background: linear-gradient(135deg, var(--success-green), #059669);
        color: white;
    }

    .btn-success-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.3);
        color: white;
    }

    .btn-warning-modern {
        background: linear-gradient(135deg, var(--warning-orange), #d97706);
        color: white;
    }

    .btn-warning-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
        color: white;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
        padding-top: 2rem;
        border-top: 1px solid var(--border-light);
    }

    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
        }

        .btn-modern {
            justify-content: center;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
    }


</style>

<div class="container-fluid">
    <div class="row">
        <main class="px-4">
            <!-- Page Header -->
            <div class="page-header d-flex justify-content-between align-items-center flex-wrap">
                <div class="pe-3">
                    <h1 class="mb-2" style="font-size: 2rem; font-weight: 700; color: #fff;">
                        <i class="fas fa-file-alt me-3"></i>
                        Document Details
                    </h1>
                    <p class="mb-0" style="opacity: 0.9; color: #fff;">View document information and download file</p>
                </div>
                    <div class="mt-3 mt-md-0">
                        <a href="<?php echo e(route('dokumen.index')); ?>" class="btn-clean primary" style="border-radius: 50px;">
                            <i class="fas fa-arrow-left me-1"></i>
                            Back to Document
                        </a>
                    </div>
            </div>

            <!-- Content Container -->
            <div class="content-container">
                <div class="content-card">
                    <div class="content-card-header">
                        <h2 class="content-card-title">
                            <i class="fas fa-info-circle"></i>
                            Document Information
                        </h2>
                    </div>
                    <div class="content-card-body">
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-heading"></i>
                                    Document Title
                                </div>
                                <div class="info-value"><?php echo e($document->title); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-calendar-plus"></i>
                                    Upload Date
                                </div>
                                <div class="info-value"><?php echo e($document->created_at->format('d M Y, H:i')); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-calendar-edit"></i>
                                    Last Updated
                                </div>
                                <div class="info-value"><?php echo e($document->updated_at->format('d M Y, H:i')); ?></div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-user-circle"></i>
                                    Uploaded By
                                </div>
                                <div class="info-value">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-user text-primary me-2"></i>
                                        <div>
                                            <div class="fw-semibold"><?php echo e($document->uploader_name); ?></div>
                                            <?php if($document->uploader): ?>
                                                <small class="text-muted"><?php echo e($document->uploader->email ?? ''); ?></small>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if($document->original_name): ?>
                            <div class="info-item">
                                <div class="info-label">
                                    <i class="fas fa-file"></i>
                                    Original File Name
                                </div>
                                <div class="info-value" style="word-wrap: break-word; word-break: break-all; white-space: normal; max-width: 100%;">
                                    <?php echo e($document->original_name); ?>

                                </div>
                            </div>
                            <?php endif; ?>


                        <?php if($document->description): ?>
                        <div class="mb-4">
                            <div class="info-label mb-2">
                                <i class="fas fa-align-left"></i>
                                Description
                            </div>
                            <div class="info-value" style="word-wrap: break-word; word-break: break-all; white-space: normal; max-width: 100%;" >
                                <?php echo e($document->description); ?>

                            </div>
                        </div>
                        <?php endif; ?>
</div>
                        <?php if($document->path): ?>
                        <div class="file-preview">
                            <div class="file-icon">
                                <?php
                                    $extension = strtolower(pathinfo($document->path, PATHINFO_EXTENSION));
                                ?>
                                <?php if(in_array($extension, ['pdf'])): ?>
                                    <i class="fas fa-file-pdf text-danger"></i>
                                <?php elseif(in_array($extension, ['doc', 'docx'])): ?>
                                    <i class="fas fa-file-word text-primary"></i>
                                <?php elseif(in_array($extension, ['xls', 'xlsx'])): ?>
                                    <i class="fas fa-file-excel text-success"></i>
                                <?php elseif(in_array($extension, ['ppt', 'pptx'])): ?>
                                    <i class="fas fa-file-powerpoint text-warning"></i>
                                <?php elseif(in_array($extension, ['txt'])): ?>
                                    <i class="fas fa-file-alt text-secondary"></i>
                                <?php else: ?>
                                    <i class="fas fa-file text-muted"></i>
                                <?php endif; ?>
                            </div>
                            <h4 class="mb-2"><?php echo e($document->original_name ?: basename($document->path)); ?></h4>
                            <p class="text-muted mb-0">Click download to view this document</p>
                        </div>
                        <?php endif; ?>

                        <div class="action-buttons">
                            <?php if($document->path): ?>
                            <a href="<?php echo e(route('dokumen.download', $document->id)); ?>"
                               class="btn-modern btn-success-modern">
                                <i class="fas fa-download"></i>
                                Download Document
                            </a>
                            <?php endif; ?>

                            <a href="<?php echo e(route('dokumen.edit', $document->id)); ?>"
                               class="btn-modern btn-warning-modern">
                                <i class="fas fa-edit"></i>
                                Edit Document
                            </a>

                            <button type="button"
                                    class="btn-modern btn-danger"
                                    onclick="confirmDelete(<?php echo e($document->id); ?>, '<?php echo e($document->title); ?>')"
                                    style="background: linear-gradient(135deg, var(--danger-red), #dc2626); color: white;">
                                <i class="fas fa-trash"></i>
                                Delete Document
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 20px; border: none;">
            <div class="modal-header" style="background: linear-gradient(135deg, var(--danger-red), #dc2626); color: white; border-radius: 20px 20px 0 0;">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <p>Are you sure you want to delete the document "<strong id="documentTitle"></strong>"?</p>
                <p class="text-muted mb-0">This action cannot be undone.</p>
            </div>
            <div class="modal-footer" style="border-top: 1px solid var(--border-light); padding: 1.5rem;">
                <button type="button" class="btn btn-secondary btn-modern" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger btn-modern">
                        <i class="fas fa-trash me-2"></i>Delete Document
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, title) {
    document.getElementById('documentTitle').textContent = title;
    document.getElementById('deleteForm').action = `/management-document/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Integrasi KP\backoffice-fasya\resources\views/manajemen-dokumen/show.blade.php ENDPATH**/ ?>