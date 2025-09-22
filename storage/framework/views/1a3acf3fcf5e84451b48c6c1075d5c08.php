<?php $__env->startSection('content'); ?>


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
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
    padding: 20px;
    box-sizing: border-box;
}

.popup-card {
    background: white;
    padding: 2.5rem;
    border-radius: 1.5rem; /* Sudut lebih bulat */
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    text-align: center;
    max-width: 400px;
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

/* Employee section styles */
.employee-section {
    margin-top: 2rem;
}

.employee-card {
    background: #fff;
    border-radius: 1rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    padding: 1.2rem 1rem;
    margin-bottom: 1rem;
    min-height: 260px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.swiper {
    padding-bottom: 0.5rem; /* Nilai diubah untuk mengurangi jarak ke bawah */
}

/* HEADER */

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


.comprehensive-btn {
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

.comprehensive-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(3, 169, 244, 0.5);
    background: linear-gradient(135deg, #0288d1 0%, #03a9f4 50%, #29b6f6 100%);
    color: white;
}

    .btn-clean {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 10px 20px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease-in-out;
    }

    .btn-clean.primary {
        background-color: var(--bs-primary);
        color: #fff;
    }

    .btn-clean.primary:hover {
        background-color: #0b5ed7; /* Warna hover yang sedikit lebih gelap */
        color: #fff;
    }

    .btn-clean i {
        margin-right: 8px;
    }

    .breadcrumb {
        margin-bottom: 1rem;
        font-size: 0.9rem;
    }

    .breadcrumb .active {
        color: #333;
        font-weight: 500;
    }

    .pagination-info {
    font-size: 0.875rem;
    color: #6c757d;
}

.pagination .page-link {
    color: #495057;
    background-color: #fff;
    border: 1px solid #dee2e6;
    padding: 0.5rem 0.75rem;
    margin: 0 2px;
    border-radius: 0.375rem;
    transition: all 0.15s ease-in-out;
}

.pagination .page-link:hover {
    color: #0056b3;
    background-color: #e9ecef;
    border-color: #adb5bd;
    text-decoration: none;
}

.pagination .page-item.active .page-link {
    color: #fff;
    background-color: #007bff;
    border-color: #007bff;
}

.pagination .page-item.disabled .page-link {
    color: #6c757d;
    background-color: #fff;
    border-color: #dee2e6;
    cursor: not-allowed;
}

.pagination .page-link:focus {
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    outline: 0;
}

/* Quick jump input */
#pageJump {
    text-align: center;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
}

#pageJump:focus {
    border-color: #007bff;
    box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    outline: 0;
}

/* ==== CSS Untuk Kartu Filter ==== */
.filter-card {
    background-color: #ffffff;
    padding: 1.5rem 2rem;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
    margin-bottom: 2rem;
}

.filter-card form {
    display: flex;
    align-items: flex-end; /* Membuat input dan tombol sejajar di bagian bawah */
    gap: 1rem; /* Jarak antar elemen filter */
    flex-wrap: wrap;
}

.filter-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.filter-group label {
    font-weight: 600;
    font-size: 0.9rem;
    color: #495057;
}

.filter-group .form-control,
.filter-group .form-select {
    border-radius: 8px;
    padding: 0.6rem 1rem;
    border: 1px solid #dee2e6;
}

.filter-actions {
    display: flex;
    align-items: flex-end;
    gap: 1.5rem; /* Jarak antara tombol Filter dan Reset */
    padding-bottom: 0; /* Menyesuaikan posisi dengan input */
}

.btn-filter {
    background: linear-gradient(135deg, #29b6f6 0%, #03a9f4 100%);
    color: white;
    border: none;
    border-radius: 10px;
    padding: 0.6rem 1.5rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(3, 169, 244, 0.3);
}

.btn-filter:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(3, 169, 244, 0.4);
    color: white;
}

.vertical-separator{
    height: 30px;
    width: 1px;
    background-color: #dee2e6;
    margin: 0 -5px;
}

/* Responsive pagination */
@media (max-width: 768px) {
    .pagination-info {
        font-size: 0.75rem;
        margin-bottom: 0.5rem;
        flex-direction: column;
        align-items: flex-start !important;
        gap: 0.5rem !important;
    }

    .row.align-items-center {
        flex-direction: column;
        align-items: flex-start !important;
    }

    .col-md-6:last-child {
        margin-top: 1rem;
        align-self: stretch;
    }

    .pagination {
        justify-content: center !important;
    }

    .pagination .page-link {
        padding: 0.375rem 0.5rem;
        font-size: 0.875rem;
    }

    #pageJump {
        width: 50px !important;
    }
}
</style>

<div class="container-fluid py-4">
    <nav class="breadcrumb"></nav>
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="dashboard-title">
                    <i class="fas fa-users me-3"></i>Employee Management
                </h1>
                <p class="dashboard-subtitle">
                    All the employees of the company are listed here
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="<?php echo e(route('employees.create')); ?>" class="btn comprehensive-btn">
                    <i class="fas fa-plus me-2"></i>Add Employee
                </a>
            </div>
        </div>
</div>



<div class="filter-card">
    <form method="GET" action="<?php echo e(route('employees.index')); ?>">
        <div class="filter-group" style="flex-grow: 1.5; min-width: 200px; max-width: 300px;">
            <label for="filter_search">Search</label>
            <input type="text" id="filter_search" name="search" class="form-control" placeholder="Search by name, position..." value="<?php echo e(request('search')); ?>">
        </div>

        <div class="filter-group" style="flex-grow: 1; min-width: 180px;">
            <label for="filter_department">Department</label>
            <select id="filter_department" name="department" class="form-select">
                <option value="">All Departments</option>
                <?php $__currentLoopData = $departments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dept): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($dept); ?>" <?php echo e(request('department') === $dept ? 'selected' : ''); ?>>
                        <?php echo e($dept); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="filter-group" style="flex-grow: 1; min-width: 150px;">
            <label for="filter_status">Status</label>
            <select id="filter_status" name="status" class="form-select">
                <option value="">All Status</option>
                <option value="active" <?php echo e(request('status') === 'active' ? 'selected' : ''); ?>>Active</option>
                <option value="inactive" <?php echo e(request('status') === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
            </select>
        </div>

        <div class="filter-actions">
        <div class="filter-group">
            <label for="perPage">Show</label>
            <select id="perPage" name="per_page" class="form-select" onchange="changePerPage(this.value)">
                <option value="10" <?php echo e(request('per_page', 10) == 10 ? 'selected' : ''); ?>>10</option>
                <option value="25" <?php echo e(request('per_page') == 25 ? 'selected' : ''); ?>>25</option>
                <option value="50" <?php echo e(request('per_page') == 50 ? 'selected' : ''); ?>>50</option>
                <option value="100" <?php echo e(request('per_page') == 100 ? 'selected' : ''); ?>>100</option>
            </select>
        </div>

    <button type="submit" class="btn btn-filter">
        <i class="fas fa-filter"></i> FILTER
    </button>
</div>

</div>
    <div class="employee-section">
        <div class="swiper employee-swiper">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $employees->chunk(15); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="swiper-slide">
                        <div class="row row-cols-1 row-cols-md-3 g-4">
                            <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col">
                                <div class="employee-card h-100">
                                    <div class="card-main-info">
                                        <div class="avatar" style="width:60px; height:60px;">
                                            <?php if($employee->user): ?>
                                                <img src="<?php echo e(route('profile.photo', $employee->user->id)); ?>"
                                                    alt="<?php echo e($employee->name); ?>"
                                                    class="rounded-circle img-fluid"
                                                    style="width: 60px; height: 60px; object-fit: cover;"
                                                    data-user-id="<?php echo e($employee->user->id); ?>">
                                            <?php else: ?>
                                                <img src="https://ui-avatars.com/api/?name=<?php echo e(urlencode($employee->name ?? 'Employee')); ?>&color=7F9CF5&background=EBF4FF"
                                                    alt="<?php echo e($employee->name); ?>"
                                                    class="rounded-circle img-fluid"
                                                    style="width: 60px; height: 60px; object-fit: cover;">
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <h3 class="employee-name"><?php echo e($employee->name); ?></h3>
                                            <p class="employee-position"><?php echo e($employee->position); ?></p>
                                        </div>
                                    </div>
                                    <div class="card-tags">
                                        <?php
                                            $deptColors = [
                                                'Designer' => 'background-color: #e0e7ff; color: #4f46e5;',
                                                'Developer' => 'background-color: #d1fae5; color: #065f46;',
                                                'Marketing' => 'background-color: rgba(108, 208, 255, 0.79); color: #072441ff;',
                                                'IT' => 'background-color: #abcf8bff; color: rgba(10, 71, 16, 1);',
                                            ];
                                            $roleColors = [
                                                'Management' => 'background-color: #fef9c3; color: #92400e;',
                                                'Non-Management' => 'background-color: #e5e7eb; color: #374151;',
                                            ];
                                        ?>
                                        <span class="tag" style="<?php echo e($deptColors[$employee->department] ?? 'background-color:#e5e5e5;'); ?>">
                                            <?php echo e($employee->department); ?>

                                        </span>
                                        <span class="tag" style="<?php echo e($roleColors[$employee->status === 'active' ? 'Management' : 'Non-Management'] ?? 'background-color:#e5e5e5;'); ?>">
                                            <?php echo e($employee->status === 'active' ? 'Management' : 'Non-Management'); ?>

                                        </span>
                                    </div>
                                    <div class="card-meta">
                                        <p>Emp Code: <?php echo e($employee->employee_code); ?></p>
                                        <p>Joining Date: <?php echo e(\Carbon\Carbon::parse($employee->hire_date)->format('d-M-Y')); ?></p>
                                        <div class="d-flex align-items-center mt-3 px-2" style="gap:0;">
                                            <div class="d-flex gap-4">
                                                <a href="<?php echo e(route('employees.show', $employee->id)); ?>" class="btn btn-sm btn-outline-info d-flex align-items-center gap-1">
                                                    <i class="fas fa-eye"></i>
                                                    <span>View</span>
                                                </a>
                                                <a href="<?php echo e(route('employees.edit', $employee->id)); ?>" class="btn btn-sm btn-outline-primary d-flex align-items-center gap-1">
                                                    <i class="fas fa-edit"></i>
                                                    <span>Edit</span>
                                                </a>
                                            </div>
                                            <div style="flex:0 0 auto; margin-left:auto;">
                                                <form action="<?php echo e(route('employees.destroy', $employee->id)); ?>" method="POST" class="delete-form" data-employee-name="<?php echo e($employee->name); ?>" style="display:inline;">
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('DELETE'); ?>
                                                    <button type="submit" class="btn btn-sm btn-outline-danger gap-1 d-flex align-items-center">
                                                        <i class="fas fa-trash-alt"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <!-- Slide navigation -->
            <div class="swiper-pagination mt-3"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </div>
    </div>

    <!-- Pagination Section -->
    <?php if($employees->hasPages()): ?>
    <div class="mt-4 pt-3 border-top">
        <div class="row align-items-center">
            <!-- Pagination Info -->
            <div class="col-md-6">
                <div class="pagination-info d-flex align-items-center gap-3">
                    <small class="text-muted">
                        Showing <?php echo e($employees->firstItem()); ?> to <?php echo e($employees->lastItem()); ?>

                        of <?php echo e($employees->total()); ?> employees
                    </small>

                    <!-- Quick Jump -->
                    <?php if($employees->lastPage() > 1): ?>
                    <div class="d-flex align-items-center gap-1">
                        <small class="text-muted">Go to:</small>
                        <input type="number"
                               id="pageJump"
                               class="form-control form-control-sm"
                               style="width: 60px;"
                               min="1"
                               max="<?php echo e($employees->lastPage()); ?>"
                               value="<?php echo e($employees->currentPage()); ?>"
                               onkeypress="if(event.key==='Enter') goToPage(this.value)">
                        <small class="text-muted">of <?php echo e($employees->lastPage()); ?></small>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Pagination Links -->
            <div class="col-md-6">
                <div class="d-flex justify-content-end align-items-center gap-2">
                    <nav aria-label="Employee pagination">
                        <?php echo e($employees->withQueryString()->links('pagination::bootstrap-4')); ?>

                    </nav>

                    <!-- Keyboard shortcuts info -->
                    <?php if($employees->lastPage() > 1): ?>
                    <small class="text-muted"
                           data-bs-toggle="tooltip"
                           data-bs-placement="top"
                           title="Keyboard shortcuts: ← → (or P/N) for prev/next, Home/End for first/last page">
                        <i class="fas fa-keyboard"></i>
                    </small>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="mt-4 pt-3 border-top">
        <small class="text-muted">
            Total: <?php echo e($employees->count()); ?> employee<?php echo e($employees->count() != 1 ? 's' : ''); ?>

        </small>
    </div>
    <?php endif; ?>

</main>
<?php $__env->stopSection(); ?>

<div class="popup-overlay" id="confirmDeletePopup" style="display: none;">
    <div class="popup-card">
        <div class="popup-icon">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>
        <h2 class="popup-title text-danger">Confirm Delete</h2>
        <p class="popup-message" id="confirmDeleteMessage">Are you sure you want to delete this employee?</p>
        <div class="d-flex gap-2">
            <button class="popup-button" id="cancelDelete">Cancel</button>
            <button class="popup-button" id="confirmDelete">Yes, Delete</button>
        </div>
    </div>
</div>


<?php $__env->startPush('scripts'); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const deleteForms = document.querySelectorAll('.delete-form');
    const confirmPopup = document.getElementById('confirmDeletePopup');
    const confirmDeleteBtn = document.getElementById('confirmDelete');
    const cancelDeleteBtn = document.getElementById('cancelDelete');
    const message = document.getElementById('confirmDeleteMessage');

    let currentForm = null;

    deleteForms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault(); // stop submit
            currentForm = form;
            const employeeName = form.dataset.employeeName || 'this employee';
            message.textContent = `Are you sure you want to delete ${employeeName}?`;
            confirmPopup.style.display = 'flex';
        });
    });

    confirmDeleteBtn.addEventListener('click', () => {
        if (currentForm) currentForm.submit();
    });

    cancelDeleteBtn.addEventListener('click', () => {
        confirmPopup.style.display = 'none';
        currentForm = null;
    });

    confirmPopup.addEventListener('click', function (e) {
        if (e.target === this) {
            confirmPopup.style.display = 'none';
            currentForm = null;
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('successPopup');
    const closeButton = document.getElementById('closePopup');

    if (popup) {
        // Fungsi untuk menutup popup
        const closePopup = () => {
            popup.style.display = 'none';
        };

        // Tutup saat tombol OK diklik
        if (closeButton) {
            closeButton.addEventListener('click', closePopup);
        }

        // Tutup saat area luar popup diklik
        popup.addEventListener('click', function(event) {
            if (event.target === this) {
                closePopup();
            }
        });
    }

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
});

// Function to change items per page
function changePerPage(perPage) {
    const url = new URL(window.location.href);
    url.searchParams.set('per_page', perPage);
    url.searchParams.delete('page'); // Reset to first page
    window.location.href = url.toString();
}

// Function to go to specific page (for custom pagination)
function goToPage(page) {
    const pageNum = parseInt(page);
    const maxPage = <?php echo e($employees->lastPage() ?? 1); ?>;

    // Validate page number
    if (isNaN(pageNum) || pageNum < 1 || pageNum > maxPage) {
        alert(`Please enter a valid page number between 1 and ${maxPage}`);
        document.getElementById('pageJump').value = <?php echo e($employees->currentPage() ?? 1); ?>;
        return;
    }

    const url = new URL(window.location.href);
    url.searchParams.set('page', pageNum);
    window.location.href = url.toString();
}

// Keyboard shortcuts for pagination
document.addEventListener('keydown', function(e) {
    // Only work if no input is focused
    if (document.activeElement.tagName === 'INPUT' || document.activeElement.tagName === 'TEXTAREA') {
        return;
    }

    const currentPage = <?php echo e($employees->currentPage() ?? 1); ?>;
    const lastPage = <?php echo e($employees->lastPage() ?? 1); ?>;

    // Left arrow or 'p' for previous page
    if ((e.key === 'ArrowLeft' || e.key === 'p') && currentPage > 1) {
        e.preventDefault();
        goToPage(currentPage - 1);
    }

    // Right arrow or 'n' for next page
    if ((e.key === 'ArrowRight' || e.key === 'n') && currentPage < lastPage) {
        e.preventDefault();
        goToPage(currentPage + 1);
    }

    // Home key for first page
    if (e.key === 'Home' && currentPage > 1) {
        e.preventDefault();
        goToPage(1);
    }

    // End key for last page
    if (e.key === 'End' && currentPage < lastPage) {
        e.preventDefault();
        goToPage(lastPage);
    }
});
</script>
<!-- SwiperJS CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<!-- SwiperJS JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Swiper('.employee-swiper', {
        slidesPerView: 1,
        spaceBetween: 30,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        loop: false,
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Integrasi KP\backoffice-fasya\resources\views/employees/index.blade.php ENDPATH**/ ?>