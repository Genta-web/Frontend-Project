<?php $__env->startSection('title', Auth::user()->isEmployee() ? 'My Leave Requests' : 'Leave Management'); ?>

<?php $__env->startPush('head'); ?>
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
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

<?php $__env->startPush('styles'); ?>
<style>
    /* CLEAN & PROFESSIONAL LEAVE MANAGEMENT */

    .leave-container {
        padding: 1.5rem;
        background-color: #f8f9fa;
        min-height: calc(100vh - 120px);
    }

    /* Enhanced Page Header */
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

    .status-summary {
        margin-top: 1rem;
        padding-top: 1rem;
    }

    .btn-group .btn {
    border: none !important; /* Hapus border default bootstrap */
    border-radius: 0px !important;
    color: white !important;
    font-weight: 500;
    font-size: 0.85rem;
    padding: 0.4rem 1rem;
    margin: 0 !important;
    transition: all 0.3s ease;
    text-transform: none; /* Agar tidak uppercase semua */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

/* 2. Aturan untuk Tombol PERTAMA (paling kiri) */
.btn-group .btn:first-child {
    border-top-left-radius: 15px !important;
    border-bottom-left-radius: 15px !important;
}

/* 3. Aturan untuk Tombol TERAKHIR (paling kanan) */
.btn-group .btn:last-child {
    border-top-right-radius: 15px !important;
    border-bottom-right-radius: 15px !important;
}


/* 2. Efek Hover Umum untuk SEMUA tombol filter */
.btn-group .btn:hover {
    transform: translateY(-2px);
    color: white !important;
}

/* 3. Aturan Warna Spesifik untuk SETIAP Tombol */

/* Tombol All (Abu-abu/Netral) & Tombol Aktif */
    .btn-group .btn.btn-outline-secondary,
    .btn-group .btn.active {
    background: linear-gradient(135deg, #90a4ae, #607d8b) !important;
    box-shadow: 0 4px 15px rgba(96, 125, 139, 0.3);
}

.btn-group .btn.btn-outline-secondary:hover,
.btn-group .btn.active:hover {
    box-shadow: 0 6px 20px rgba(96, 125, 139, 0.4);
}

/* Tombol Waiting (Kuning/Oranye) */
.btn-group .btn.btn-outline-warning {
    background: linear-gradient(135deg, #ffb74d, #f57c00) !important;
    box-shadow: 0 4px 15px rgba(245, 124, 0, 0.3);
}
.btn-group .btn.btn-outline-warning:hover {
    box-shadow: 0 6px 20px rgba(245, 124, 0, 0.4);
}

/* Tombol Pending (Biru Muda/Info) */
.btn-group .btn.btn-outline-info {
    background: linear-gradient(135deg, #4fc3f7, #039be5) !important;
    box-shadow: 0 4px 15px rgba(3, 155, 229, 0.3);
}

.btn-group .btn.btn-outline-info:hover {
    box-shadow: 0 6px 20px rgba(3, 155, 229, 0.4);
}

/* Tombol Approved (Hijau) */
.btn-group .btn.btn-outline-success {
    background: linear-gradient(135deg, #81c784, #388e3c) !important;
    box-shadow: 0 4px 15px rgba(56, 142, 60, 0.3);
}
.btn-group .btn.btn-outline-success:hover {
    box-shadow: 0 6px 20px rgba(56, 142, 60, 0.4);
}

/* Tombol Rejected (Merah) */
.btn-group .btn.btn-outline-danger {
    background: linear-gradient(135deg, #e57373, #d32f2f) !important;
    box-shadow: 0 4px 15px rgba(211, 47, 47, 0.3);
}
.btn-group .btn.btn-outline-danger:hover {
    box-shadow: 0 6px 20px rgba(211, 47, 47, 0.4);
}

    /* Professional Card Design */
    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .card-header {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-bottom: 2px solid #e9ecef;
        padding: 1.5rem;
    }

    .card-title {
        font-weight: 700;
        color: #2c3e50;
        display: flex;
        align-items: center;
    }

    /* Filter Buttons */
    .btn-group .btn {
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
        padding: 0.4rem 0.8rem;
        margin: 0 2px;
        transition: all 0.3s ease;
    }

    .btn-group .btn.active {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
        box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
    }

/* CSS untuk Kartu Statistik Cuti */
.stats-card {
    background-color: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border-left: 5px solid;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
}

.stats-info h3 {
    font-size: 2.25rem; /* Ukuran angka lebih besar */
    font-weight: 700;
    margin: 0 0 0.25rem 0;
}

.stats-info p {
    font-size: 1rem;
    color: #6c757d;
    margin: 0;
}

/* Variasi Warna Kartu */
.stats-card.approved { border-color: #28a745; }
.stats-card.approved .stats-icon { background-color: #28a745; }
.stats-card.approved .stats-info h3 { color: #28a745; }

.stats-card.rejected { border-color: #dc3545; }
.stats-card.rejected .stats-icon { background-color: #dc3545; }
.stats-card.rejected .stats-info h3 { color: #dc3545; }

.stats-card.pending { border-color: #ffc107; }
.stats-card.pending .stats-icon { background-color: #ffc107; }
.stats-card.pending .stats-info h3 { color: #ffc107; }

    /* Enhanced Table */
    .table {
        margin-bottom: 0;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
        color: #495057;
        font-size: 0.9rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 1rem 0.75rem;
    }

    .table tbody tr {
        transition: all 0.3s ease;
        border-bottom: 1px solid #f1f3f4;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-top: none;
    }

    /* Row Number Styling */
    .row-number {
        background: linear-gradient(135deg, #007bff, #0056b3);
        color: white;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        font-size: 0.85rem;
        margin: 0 auto;
    }

    /* Employee Avatar */
    .avatar-circle {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 1.1rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .employee-details h6 {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 0.25rem;
    }

    .employee-details small {
        font-size: 0.8rem;
        line-height: 1.3;
    }

    /* Leave Type Badge */
    .leave-type-container .badge {
        font-size: 0.85rem;
        padding: 0.5rem 0.8rem;
        border-radius: 20px;
        font-weight: 500;
    }

    /* Date Range Styling */
    .date-range-container {
        font-size: 0.9rem;
    }

    .date-range-container .text-dark {
        font-weight: 600;
    }

    /* Days Badge */
    .days-container .badge {
        font-size: 0.9rem;
        padding: 0.6rem 1rem;
        border-radius: 25px;
        font-weight: 600;
    }

    /* Status Badges */
    .status-container .badge {
        font-size: 0.85rem;
        padding: 0.6rem 1rem;
        border-radius: 25px;
        font-weight: 600;
        min-width: 80px;
    }

    /* Action Buttons */
    .action-buttons .btn {
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
        padding: 0.4rem 0.8rem;
        transition: all 0.3s ease;
    }

    .action-buttons .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }

    .urgent-actions {
        text-align: center;
    }

    .urgent-actions .badge {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    /* Empty State */
    .empty-state {
        padding: 3rem 2rem;
    }

    .empty-icon {
        opacity: 0.6;
    }

    /* Status Row Colors */
    .table-info {
        background-color: rgba(13, 202, 240, 0.05);
        border-left: 4px solid #0dcaf0;
    }

    .table-warning {
        background-color: rgba(255, 193, 7, 0.05);
        border-left: 4px solid #ffc107;
    }

    .table-success {
        background-color: rgba(25, 135, 84, 0.05);
        border-left: 4px solid #198754;
    }

    .table-danger {
        background-color: rgba(220, 53, 69, 0.05);
        border-left: 4px solid #dc3545;
    }

    /* Bulk Actions Styling */
    .dropdown-menu {
        border-radius: 10px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        border: none;
        padding: 0.5rem 0;
    }

    .dropdown-item {
        padding: 0.75rem 1.25rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
    }

    .dropdown-item.text-danger:hover {
        background-color: #fff5f5;
        color: #dc3545 !important;
    }

    /* Checkbox Styling */
    .form-check-input {
        border-radius: 4px;
        border: 2px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .form-check-input:checked {
        background-color: #007bff;
        border-color: #007bff;
        box-shadow: 0 2px 4px rgba(0, 123, 255, 0.3);
    }

    .form-check-input:indeterminate {
        background-color: #6c757d;
        border-color: #6c757d;
    }

    /* Enhanced Pagination Styling */
    .pagination-info {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 0.75rem 1rem;
        border-radius: 8px;
        border: 1px solid #dee2e6;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Bulk Delete Modal Enhancements */
    .modal-content {
        border-radius: 15px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
    }

    .modal-header.bg-danger {
        border-radius: 15px 15px 0 0;
    }

    .modal-footer {
        border-radius: 0 0 15px 15px;
        border-top: 2px solid #f8f9fa;
    }

    /* Loading States */
    .btn:disabled {
        opacity: 0.7;
        cursor: not-allowed;
    }

    .btn .fa-spinner {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .page-header {
            padding: 1.5rem;
        }

        .page-title {
            font-size: 1.5rem;
        }

        .btn-group {
            flex-wrap: wrap;
        }

        .btn-group .btn {
            margin-bottom: 0.5rem;
        }

        .action-buttons .btn {
            margin-bottom: 0.25rem;
        }

        .pagination-info {
            text-align: center;
            margin-bottom: 1rem;
        }

        .dropdown {
            width: 100%;
        }

        .dropdown .btn {
            width: 100%;
        }
    }

    .table-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
    }

    .table thead th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        color: #495057;
        padding: 1rem 0.75rem;
        border-bottom: 2px solid #dee2e6;
    }

    .table tbody td {
        padding: 1rem 0.75rem;
        vertical-align: middle;
        border-bottom: 1px solid #f1f3f4;
    }

    .table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Status Styling */
    .status-pending {
        background-color: #fff3cd !important;
        border-left: 3px solid #ffc107;
    }

    .status-waiting {
        background-color: #ffe6e6 !important;
        border-left: 3px solid #dc3545;
        animation: pulse-waiting 2s infinite;
    }

    .status-approved {
        background-color: #d4edda !important;
        border-left: 3px solid #28a745;
    }

    .status-rejected {
        background-color: #f8d7da !important;
        border-left: 3px solid #dc3545;
    }

    @keyframes pulse-waiting {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }

    /* Status Badges */
    .status-badge {
        padding: 0.4rem 0.8rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 0.3rem;
    }

    .status-badge.pending {
        background-color: #ffc107;
        color: #212529;
    }

    .status-badge.waiting {
        background-color: #dc3545;
        color: white;
        animation: blink 1.5s infinite;
    }

    .status-badge.approved {
        background-color: #28a745;
        color: white;
    }

    .status-badge.rejected {
        background-color: #dc3545;
        color: white;
    }

    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0.7; }
    }

    /* Action Buttons */
    .action-container {
        min-width: 150px;
    }

    .btn-action {
        padding: 0.4rem 0.8rem;
        font-size: 0.8rem;
        border-radius: 5px;
        font-weight: 500;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-bottom: 0.3rem;
        width: 100%;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-action:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
        text-decoration: none;
    }

    .btn-action.view {
        background-color: #17a2b8;
        color: white;
    }

    .btn-action.approve {
        background-color: #28a745;
        color: white;
    }

    .btn-action.reject {
        background-color: #dc3545;
        color: white;
    }

    .btn-action.edit {
        background-color: #ffc107;
        color: #212529;
    }

    .btn-action.delete {
        background-color: #6c757d;
        color: white;
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

    /* Waiting Actions Special */
    .waiting-actions {
        background-color: #ffe6e6;
        border: 2px solid #dc3545;
        border-radius: 8px;
        padding: 0.8rem;
        margin: 0.3rem 0;
    }

    .waiting-label {
        background-color: #dc3545;
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 10px;
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 0.5rem;
        display: inline-block;
    }

    /* Employee Info */
    .employee-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .employee-avatar {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        background-color: #007bff;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .employee-details h6 {
        margin-bottom: 0.2rem;
        font-weight: 600;
        color: #2c3e50;
        font-size: 0.9rem;
    }

    .employee-details small {
        color: #6c757d;
        font-size: 0.75rem;
    }

    /* Leave Type Badge */
    .leave-type-badge {
        background-color: #e3f2fd;
        color: #1565c0;
        padding: 0.3rem 0.6rem;
        border-radius: 15px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    /* Date Range */
    .date-range {
        background-color: #f3e5f5;
        color: #7b1fa2;
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        font-weight: 500;
        font-size: 0.85rem;
    }

    /* Enhanced Modal Styles */
    .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        border-radius: 15px 15px 0 0;
        border-bottom: none;
        padding: 1.5rem;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
        border-radius: 0 0 15px 15px;
        padding: 1rem 1.5rem;
    }

    .modal .badge {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }

    .modal .form-control {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .modal .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .modal .btn {
        border-radius: 8px;
        font-weight: 600;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .modal .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }

    /* Quick reason buttons */
    .btn-outline-secondary.btn-sm {
        border-radius: 20px;
        font-size: 0.75rem;
        padding: 0.25rem 0.75rem;
        transition: all 0.2s ease;
    }

    .btn-outline-secondary.btn-sm:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        transform: scale(1.05);
    }

    /* Loading state for buttons */
    .btn-loading {
        position: relative;
        pointer-events: none;
    }

    .btn-loading .fas {
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Enhanced notifications */
    .alert {
        border: none;
        border-radius: 10px;
        font-weight: 500;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda, #c3e6cb);
        color: #155724;
        border-left: 4px solid #28a745;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da, #f5c6cb);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .leave-container {
            padding: 1rem;
        }

        .page-header {
            padding: 1.5rem;
        }

        .action-container {
            min-width: 120px;
        }

        .btn-action {
            font-size: 0.75rem;
            padding: 0.3rem 0.6rem;
        }

        .modal-dialog {
            margin: 1rem;
        }

        .modal-body {
            padding: 1rem;
        }

        .modal-header {
            padding: 1rem;
        }

        .modal-footer {
            padding: 1rem;
        }
    }

    /* Delete Confirmation Modal Styling */
    #deleteConfirmModal .modal-content {
        border: none;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    }

    #deleteConfirmModal .modal-header {
        border-radius: 15px 15px 0 0;
        border-bottom: 2px solid #dc3545;
    }

    #deleteConfirmModal .fa-trash-alt {
        color: #dc3545;
        opacity: 0.8;
    }

    #deleteConfirmModal .card {
        border: 1px solid #dee2e6;
        border-radius: 10px;
        background-color: #f8f9fa;
    }

    #deleteConfirmModal .card-title {
        font-size: 1rem;
        margin-bottom: 1rem;
    }

    #deleteConfirmModal .row {
        margin-bottom: 0.5rem;
    }

    #deleteConfirmModal .alert-warning {
        border-radius: 10px;
        border-left: 4px solid #ffc107;
    }

    #deleteConfirmModal .btn {
        border-radius: 25px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    #deleteConfirmModal .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="leave-container">
    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?php echo e(session('error')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Page Header -->
    <div class="dashboard-header d-flex flex-column flex-md-row justify-content-between align-items-md-center">

    <div>
        <h1 class="dashboard-title" style="color: #fff;">
            <i class="fas fa-calendar-alt me-2" style="color: #fff;"></i>
            <?php if(Auth::user()->isEmployee()): ?>
                My Leave Requests
            <?php else: ?>
                Leave Management
            <?php endif; ?>
        </h1>
        <p class="dashboard-subtitle mb-3 mb-md-0" style="color: #fff;">
            <?php if(Auth::user()->isEmployee()): ?>
                View and manage your leave requests
            <?php else: ?>
                Manage employee leave requests and approvals
            <?php endif; ?>
        </p>
    </div>

    <div>
        <a href="<?php echo e(route('leave.create')); ?>" class="btn comprehensive-btn">
            <i class="fas fa-plus me-2"></i> New Leave Request
        </a>
    </div>

    
    <?php if(!Auth::user()->isEmployee()): ?>
        <?php
            $pendingCount = $leaves->where('status', 'pending')->count();
            $waitingCount = $leaves->where('status', 'waiting')->count();
            $approvedCount = $leaves->where('status', 'approved')->count();
            $rejectedCount = $leaves->where('status', 'rejected')->count();
        ?>
    <?php endif; ?>

</div>

<?php if(!Auth::user()->isEmployee()): ?>
<div class="row mb-4">
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="stats-card approved">
            <div class="stats-icon">
                <i class="fas fa-check"></i>
            </div>
            <div class="stats-info">
                <h3><?php echo e($approvedCount ?? 0); ?></h3>
                <p>Approved Leaves</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <div class="stats-card rejected">
            <div class="stats-icon">
                <i class="fas fa-times"></i>
            </div>
            <div class="stats-info">
                <h3><?php echo e($rejectedCount ?? 0); ?></h3>
                <p>Rejected Leaves</p>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <div class="stats-card pending">
            <div class="stats-icon">
                <i class="fas fa-hourglass-half"></i>
            </div>
            <div class="stats-info">
                <h3><?php echo e($pendingCount ?? 0); ?></h3>
                <p>Pending Leaves</p>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

    <!-- Table Container -->
    <div class="card shadow-sm">
        <div class="card-header bg-white border-bottom">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-list-alt me-2 text-primary"></i>
                        <?php if(Auth::user()->isEmployee()): ?>
                            My Leave Requests
                        <?php else: ?>
                            All Leave Requests
                        <?php endif; ?>
                        <span class="badge bg-light text-dark ms-2"><?php echo e($leaves->total()); ?></span>
                    </h5>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-md-end justify-content-start mt-2 mt-md-0 gap-2">
                        <!-- Filter buttons -->
                        <div class="btn-group btn-group-sm" role="group">
                            <button type="button" class="btn btn-outline-secondary active" data-filter="all">
                                <i class="fas fa-list me-1"></i>All
                            </button>
                            <button type="button" class="btn btn-outline-warning" data-filter="waiting">
                                <i class="fas fa-clock me-1"></i>Waiting
                            </button>
                            <button type="button" class="btn btn-outline-info" data-filter="pending">
                                <i class="fas fa-hourglass-half me-1"></i>Pending
                            </button>
                            <button type="button" class="btn btn-outline-success" data-filter="approved">
                                <i class="fas fa-check me-1"></i>Approved
                            </button>
                            <button type="button" class="btn btn-outline-danger" data-filter="rejected">
                                <i class="fas fa-times me-1"></i>Rejected
                            </button>
                        </div>

                        <?php if(Auth::user()->hasRole(['admin', 'hr'])): ?>
                            <!-- Bulk Actions -->
                            <div class="dropdown">
                                <button class="btn btn-outline-danger btn-sm dropdown-toggle" type="button" id="bulkActionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-trash me-1"></i>
                                    Bulk Actions
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="bulkActionsDropdown">
                                    <li>
                                        <button class="dropdown-item" type="button" onclick="showBulkDeleteModal('selected')">
                                            <i class="fas fa-trash-alt me-2 text-warning"></i>
                                            Delete Selected
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" type="button" onclick="showBulkDeleteModal('approved')">
                                            <i class="fas fa-check-circle me-2 text-success"></i>
                                            Delete All Approved
                                        </button>
                                    </li>
                                    <li>
                                        <button class="dropdown-item" type="button" onclick="showBulkDeleteModal('rejected')">
                                            <i class="fas fa-times-circle me-2 text-danger"></i>
                                            Delete All Rejected
                                        </button>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <button class="dropdown-item text-danger" type="button" onclick="showBulkDeleteModal('all')">
                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                            Delete All Records
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <?php if(Auth::user()->hasRole(['admin', 'hr'])): ?>
                                <th width="3%" class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="selectAll" onchange="toggleSelectAll()">
                                        <label class="form-check-label" for="selectAll"></label>
                                    </div>
                                </th>
                            <?php endif; ?>
                            <th width="5%" class="text-center">
                                <i class="fas fa-hashtag text-muted"></i>
                            </th>
                            <?php if(!Auth::user()->hasRole('employee')): ?>
                                <th width="20%">
                                    <i class="fas fa-user me-1 text-muted"></i>
                                    Employee
                                </th>
                            <?php endif; ?>
                            <th width="15%">
                                <i class="fas fa-tag me-1 text-muted"></i>
                                Leave Type
                            </th>
                            <th width="20%">
                                <i class="fas fa-calendar-range me-1 text-muted"></i>
                                Date Range
                            </th>
                            <th width="10%" class="text-center">
                                <i class="fas fa-calendar-day me-1 text-muted"></i>
                                Days
                            </th>
                            <th width="15%" class="text-center">
                                <i class="fas fa-info-circle me-1 text-muted"></i>
                                Status
                            </th>
                            <th width="15%" class="text-center">
                                <i class="fas fa-cogs me-1 text-muted"></i>
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $leaves; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $leave): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="leave-row
                                <?php if($leave->status === 'pending'): ?> table-info
                                <?php elseif($leave->status === 'waiting'): ?> table-warning
                                <?php elseif($leave->status === 'approved'): ?> table-success
                                <?php elseif($leave->status === 'rejected'): ?> table-danger
                                <?php endif; ?>
                            " data-status="<?php echo e($leave->status); ?>" data-leave-id="<?php echo e($leave->id); ?>" style="cursor: pointer;" onclick="showLeaveDetail(<?php echo e($leave->id); ?>)">
                                <?php if(Auth::user()->hasRole(['admin', 'hr'])): ?>
                                    <!-- Checkbox for bulk selection -->
                                    <td class="text-center align-middle" onclick="event.stopPropagation();">
                                        <div class="form-check">
                                            <input class="form-check-input leave-checkbox" type="checkbox" value="<?php echo e($leave->id); ?>" id="leave_<?php echo e($leave->id); ?>" onchange="updateBulkActions()">
                                            <label class="form-check-label" for="leave_<?php echo e($leave->id); ?>"></label>
                                        </div>
                                    </td>
                                <?php endif; ?>

                                <!-- Row Number -->
                                <td class="text-center align-middle">
                                    <div class="row-number">
                                        <?php echo e($leaves->firstItem() + $index); ?>

                                    </div>
                                </td>

                                <!-- Employee Info -->
                                <?php if(!Auth::user()->hasRole('employee')): ?>
                                    <td class="align-middle">
                                        <div class="d-flex align-items-center">
                                            <div class="employee-avatar me-3">
                                                <div class="avatar-circle bg-primary text-white">
                                                    <?php echo e(strtoupper(substr($leave->employee->name ?? 'U', 0, 1))); ?>

                                                </div>
                                            </div>
                                            <div class="employee-details">
                                                <h6 class="mb-1 fw-semibold"><?php echo e($leave->employee->name ?? 'Unknown'); ?></h6>
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i>
                                                    <?php echo e($leave->employee->email ?? 'No email'); ?>

                                                </small>
                                                <?php if($leave->employee && $leave->employee->department): ?>
                                                    <br>
                                                    <small class="text-muted">
                                                        <i class="fas fa-building me-1"></i>
                                                        <?php echo e($leave->employee->department); ?>

                                                    </small>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </td>
                                <?php endif; ?>

                                <!-- Leave Type -->
                                <td class="align-middle">
                                    <div class="leave-type-container">
                                        <span class="badge bg-light text-dark border">
                                            <i class="fas fa-tag me-1"></i>
                                            <?php echo e($leave->leave_type_display); ?>

                                        </span>
                                    </div>
                                </td>

                                <!-- Date Range -->
                                <td class="align-middle">
                                    <div class="date-range-container">
                                        <div class="d-flex align-items-center mb-1">
                                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                            <strong class="text-dark"><?php echo e($leave->start_date->format('d M Y')); ?></strong>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-arrow-right me-2 text-muted"></i>
                                            <span class="text-muted"><?php echo e($leave->end_date->format('d M Y')); ?></span>
                                        </div>
                                        <?php if($leave->start_date->format('Y-m-d') === $leave->end_date->format('Y-m-d')): ?>
                                            <small class="text-info">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Single Day
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Total Days -->
                                <td class="text-center align-middle">
                                    <div class="days-container">
                                        <span class="badge bg-primary fs-6 px-3 py-2">
                                            <i class="fas fa-calendar-day me-1"></i>
                                            <?php echo e($leave->total_days); ?>

                                            <?php echo e($leave->total_days == 1 ? 'Day' : 'Days'); ?>

                                        </span>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="text-center align-middle">
                                    <div class="status-container">
                                        <?php if($leave->status === 'pending'): ?>
                                            <span class="badge bg-info fs-6 px-3 py-2">
                                                <i class="fas fa-hourglass-half me-1"></i>
                                                Pending
                                            </span>
                                            <div class="mt-1">
                                                <small class="text-muted">Under Review</small>
                                            </div>
                                        <?php elseif($leave->status === 'waiting'): ?>
                                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                                <i class="fas fa-clock me-1"></i>
                                                Waiting
                                            </span>
                                            <div class="mt-1">
                                                <small class="text-warning fw-bold">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    Response Required
                                                </small>
                                            </div>
                                        <?php elseif($leave->status === 'approved'): ?>
                                            <span class="badge bg-success fs-6 px-3 py-2">
                                                <i class="fas fa-check me-1"></i>
                                                Approved
                                            </span>
                                            <div class="mt-1">
                                                <small class="text-success">
                                                    <i class="fas fa-user-check me-1"></i>
                                                    by <?php echo e($leave->approvedBy->username ?? 'Admin'); ?>

                                                </small>
                                            </div>
                                        <?php elseif($leave->status === 'rejected'): ?>
                                            <span class="badge bg-danger fs-6 px-3 py-2">
                                                <i class="fas fa-times me-1"></i>
                                                Rejected
                                            </span>
                                            <div class="mt-1">
                                                <small class="text-danger">
                                                    <i class="fas fa-user-times me-1"></i>
                                                    by <?php echo e($leave->approvedBy->username ?? 'Admin'); ?>

                                                </small>
                                            </div>
                                        <?php else: ?>
                                            <span class="badge bg-secondary fs-6 px-3 py-2">
                                                <i class="fas fa-question-circle me-1"></i>
                                                <?php echo e(ucfirst($leave->status)); ?>

                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Actions -->
                                <td class="text-center align-middle" onclick="event.stopPropagation();">
                                    <div class="action-buttons">
                                        <!-- View Detail - Always Available -->
                                        <a href="<?php echo e(route('leave.show', $leave)); ?>"
                                           class="btn btn-outline-primary btn-sm me-1 mb-1"
                                           title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <?php if(in_array($leave->status, ['pending', 'waiting']) && Auth::user()->hasRole(['admin', 'hr', 'manager'])): ?>
                                            <?php if($leave->status === 'waiting'): ?>
                                                <!-- Urgent Waiting Actions -->
                                                <div class="urgent-actions">
                                                    <div class="mb-1">
                                                        <small class="badge bg-warning text-dark">
                                                            <i class="fas fa-exclamation-triangle me-1"></i>
                                                            URGENT
                                                        </small>
                                                    </div>

                                                    <button type="button"
                                                            class="btn btn-success btn-sm me-1 mb-1"
                                                            onclick="approveLeaveRequest(<?php echo e($leave->id); ?>, '<?php echo e($leave->employee->name ?? 'Employee'); ?>', '<?php echo e($leave->leave_type_display); ?>', '<?php echo e($leave->start_date->format('d M Y')); ?>', '<?php echo e($leave->end_date->format('d M Y')); ?>', <?php echo e($leave->total_days); ?>)"
                                                            title="Approve Request">
                                                        <i class="fas fa-check me-1"></i>
                                                        Approve
                                                    </button>

                                                    <button type="button"
                                                            class="btn btn-danger btn-sm mb-1"
                                                            onclick="rejectLeaveRequest(<?php echo e($leave->id); ?>, '<?php echo e($leave->employee->name ?? 'Employee'); ?>', '<?php echo e($leave->leave_type_display); ?>', '<?php echo e($leave->start_date->format('d M Y')); ?>', '<?php echo e($leave->end_date->format('d M Y')); ?>', <?php echo e($leave->total_days); ?>)"
                                                            title="Reject Request">
                                                        <i class="fas fa-times me-1"></i>
                                                        Reject
                                                    </button>
                                                </div>
                                            <?php else: ?>
                                                <!-- Standard Admin Actions -->
                                                <button type="button"
                                                        class="btn btn-success btn-sm me-1 mb-1"
                                                        onclick="approveLeaveRequest(<?php echo e($leave->id); ?>, '<?php echo e($leave->employee->name ?? 'Employee'); ?>', '<?php echo e($leave->leave_type_display); ?>', '<?php echo e($leave->start_date->format('d M Y')); ?>', '<?php echo e($leave->end_date->format('d M Y')); ?>', <?php echo e($leave->total_days); ?>)"
                                                        title="Approve Request">
                                                    <i class="fas fa-check"></i>
                                                </button>

                                                <button type="button"
                                                        class="btn btn-danger btn-sm mb-1"
                                                        onclick="rejectLeaveRequest(<?php echo e($leave->id); ?>, '<?php echo e($leave->employee->name ?? 'Employee'); ?>', '<?php echo e($leave->leave_type_display); ?>', '<?php echo e($leave->start_date->format('d M Y')); ?>', '<?php echo e($leave->end_date->format('d M Y')); ?>', <?php echo e($leave->total_days); ?>)"
                                                        title="Reject Request">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            <?php endif; ?>

                                        <?php elseif($leave->status === 'pending' && $leave->employee_id == Auth::user()->employee?->id): ?>
                                            <!-- Employee Actions for Own Requests -->
                                            <a href="<?php echo e(route('leave.edit', $leave)); ?>"
                                               class="btn btn-warning btn-sm me-1 mb-1"
                                               title="Edit Request">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button"
                                                    class="btn btn-outline-danger btn-sm mb-1"
                                                    title="Delete Request"
                                                    onclick="showDeleteConfirmModal(<?php echo e($leave->id); ?>, '<?php echo e($leave->employee->name ?? 'Employee'); ?>', '<?php echo e($leave->leave_type); ?>', '<?php echo e($leave->start_date); ?>', '<?php echo e($leave->end_date); ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="<?php echo e(Auth::user()->hasRole('employee') ? '6' : (Auth::user()->hasRole(['admin', 'hr']) ? '8' : '7')); ?>" class="text-center py-5">
                                    <div class="empty-state">
                                        <div class="empty-icon mb-3">
                                            <i class="fas fa-calendar-times fa-4x text-muted"></i>
                                        </div>
                                        <h5 class="text-muted mb-2">No Leave Requests Found</h5>
                                        <p class="text-muted mb-3">
                                            <?php if(Auth::user()->isEmployee()): ?>
                                                You haven't submitted any leave requests yet.
                                            <?php else: ?>
                                                There are no leave requests to display.
                                            <?php endif; ?>
                                        </p>
                                        <a href="<?php echo e(route('leave.create')); ?>" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Create New Leave Request
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Enhanced Pagination -->
        <?php if($leaves->hasPages()): ?>
            <div class="card-footer bg-light border-top">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="pagination-info">
                            <span class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Showing <?php echo e($leaves->firstItem()); ?> to <?php echo e($leaves->lastItem()); ?> of <?php echo e($leaves->total()); ?> results
                            </span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-md-end justify-content-center mt-2 mt-md-0">
                            <nav aria-label="Leave requests pagination">
                                <div class="pagination-wrapper">
                                    <?php echo e($leaves->links('custom.pagination')); ?>

                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<!-- Bulk Delete Modal -->
<div class="modal fade" id="bulkDeleteModal" tabindex="-1" aria-labelledby="bulkDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="bulkDeleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Bulk Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h5 class="text-danger">Warning: This action cannot be undone!</h5>
                </div>

                <div id="bulkDeleteContent">
                    <!-- Content will be populated by JavaScript -->
                </div>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Important:</strong> Deleted leave requests cannot be recovered. Make sure you have backed up any important data before proceeding.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmBulkDelete">
                    <i class="fas fa-trash me-1"></i>Delete Records
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Individual Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteConfirmModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirm Delete
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-trash-alt fa-3x text-danger mb-3"></i>
                    <h5 class="text-danger">Are you sure you want to delete this leave request?</h5>
                </div>

                <div id="deleteLeaveInfo">
                    <!-- Leave information will be populated by JavaScript -->
                </div>

                <div class="alert alert-warning mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Warning:</strong> This action cannot be undone. The leave request will be permanently deleted from the system.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmIndividualDelete">
                    <i class="fas fa-trash me-1"></i>Delete Leave Request
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Leave Detail Modal -->
<div class="modal fade" id="leaveDetailModal" tabindex="-1" aria-labelledby="leaveDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="leaveDetailModalLabel">
                    <i class="fas fa-info-circle me-2"></i>Detail Pengajuan Cuti
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- Employee Information -->
                    <div class="col-md-6">
                        <div class="card border-0 bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-title text-primary">
                                    <i class="fas fa-user me-2"></i>Informasi Karyawan
                                </h6>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Nama:</strong></div>
                                    <div class="col-8" id="detailEmployeeName">-</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Email:</strong></div>
                                    <div class="col-8" id="detailEmployeeEmail">-</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Departemen:</strong></div>
                                    <div class="col-8" id="detailEmployeeDepartment">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-4"><strong>Posisi:</strong></div>
                                    <div class="col-8" id="detailEmployeePosition">-</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Leave Information -->
                    <div class="col-md-6">
                        <div class="card border-0 bg-light mb-3">
                            <div class="card-body">
                                <h6 class="card-title text-success">
                                    <i class="fas fa-calendar-alt me-2"></i>Informasi Cuti
                                </h6>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Jenis:</strong></div>
                                    <div class="col-8" id="detailLeaveType">-</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Tanggal:</strong></div>
                                    <div class="col-8" id="detailLeaveDuration">-</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-4"><strong>Total Hari:</strong></div>
                                    <div class="col-8" id="detailTotalDays">-</div>
                                </div>
                                <div class="row">
                                    <div class="col-4"><strong>Status:</strong></div>
                                    <div class="col-8" id="detailStatus">-</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reason -->
                <div class="card border-0 bg-light mb-3">
                    <div class="card-body">
                        <h6 class="card-title text-info">
                            <i class="fas fa-comment me-2"></i>Alasan Pengajuan
                        </h6>
                        <p class="mb-0" id="detailReason">-</p>
                    </div>
                </div>

                <!-- Approval Information -->
                <div class="card border-0 bg-light mb-3" id="approvalInfoCard" style="display: none;">
                    <div class="card-body">
                        <h6 class="card-title text-warning">
                            <i class="fas fa-user-check me-2"></i>Informasi Persetujuan
                        </h6>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Disetujui oleh:</strong></div>
                            <div class="col-8" id="detailApprovedBy">-</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-4"><strong>Tanggal Persetujuan:</strong></div>
                            <div class="col-8" id="detailApprovedAt">-</div>
                        </div>
                        <div class="row">
                            <div class="col-4"><strong>Catatan Admin:</strong></div>
                            <div class="col-8" id="detailAdminNotes">-</div>
                        </div>
                    </div>
                </div>

                <!-- Attachment -->
                <div class="card border-0 bg-light" id="attachmentCard" style="display: none;">
                    <div class="card-body">
                        <h6 class="card-title text-secondary">
                            <i class="fas fa-paperclip me-2"></i>Lampiran
                        </h6>
                        <div id="detailAttachment">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Tutup
                </button>
                <div id="detailActionButtons">
                    <!-- Action buttons will be added dynamically -->
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approve Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="approveModalLabel">
                    <i class="fas fa-check-circle me-2"></i>Approve Leave Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Employee:</strong><br>
                        <span id="approveEmployeeName" class="text-primary"></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Leave Type:</strong><br>
                        <span id="approveLeaveType" class="badge bg-info"></span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Duration:</strong><br>
                        <span id="approveDuration"></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Total Days:</strong><br>
                        <span id="approveTotalDays" class="badge bg-primary"></span>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="approveMessage" class="form-label">
                        <strong>Approval Message (Optional):</strong>
                    </label>
                    <textarea class="form-control" id="approveMessage" name="admin_message" rows="3"
                              placeholder="Add a message for the employee (optional)..."></textarea>
                </div>
                <div class="alert alert-success mt-3">
                    <i class="fas fa-info-circle me-2"></i>
                    <strong>Confirm:</strong> This will approve the leave request and notify the employee.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-success" id="confirmApproveBtn">
                    <i class="fas fa-check me-1"></i>Approve Request
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div class="modal fade" id="rejectModal" tabindex="-1" aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="rejectModalLabel">
                    <i class="fas fa-times-circle me-2"></i>Reject Leave Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <strong>Employee:</strong><br>
                        <span id="rejectEmployeeName" class="text-primary"></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Leave Type:</strong><br>
                        <span id="rejectLeaveType" class="badge bg-info"></span>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Duration:</strong><br>
                        <span id="rejectDuration"></span>
                    </div>
                    <div class="col-md-6">
                        <strong>Total Days:</strong><br>
                        <span id="rejectTotalDays" class="badge bg-primary"></span>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="rejectReason" class="form-label">
                        <strong>Rejection Reason <span class="text-danger">*</span>:</strong>
                    </label>
                    <textarea class="form-control" id="rejectReason" name="admin_notes" rows="4"
                              placeholder="Please provide a clear reason for rejection..." required></textarea>
                    <div class="form-text">This reason will be sent to the employee.</div>
                </div>
                <div class="mt-3">
                    <label class="form-label"><strong>Quick Reasons:</strong></label>
                    <div class="d-flex flex-wrap gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setQuickReason('Insufficient leave balance')">
                            Insufficient Balance
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setQuickReason('Overlapping with busy period')">
                            Busy Period
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setQuickReason('Incomplete documentation')">
                            Incomplete Docs
                        </button>
                        <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setQuickReason('Short notice period')">
                            Short Notice
                        </button>
                    </div>
                </div>
                <div class="alert alert-warning mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Warning:</strong> This will reject the leave request and notify the employee.
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancel
                </button>
                <button type="button" class="btn btn-danger" id="confirmRejectBtn">
                    <i class="fas fa-times me-1"></i>Reject Request
                </button>
            </div>
        </div>
    </div>
</div>

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


    // 🎯 ENHANCED LEAVE MANAGEMENT SYSTEM

    let currentLeaveId = null;

    // Table Filter Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Filter buttons
        const filterButtons = document.querySelectorAll('[data-filter]');
        const tableRows = document.querySelectorAll('.leave-row');

        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filter = this.getAttribute('data-filter');

                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Filter rows
                tableRows.forEach(row => {
                    const status = row.getAttribute('data-status');

                    if (filter === 'all' || status === filter) {
                        row.style.display = '';
                        // Add fade-in animation
                        row.style.opacity = '0';
                        setTimeout(() => {
                            row.style.opacity = '1';
                        }, 100);
                    } else {
                        row.style.display = 'none';
                    }
                });

                // Update count
                updateFilterCount(filter);
            });
        });

        // Update filter count
        function updateFilterCount(filter) {
            const visibleRows = Array.from(tableRows).filter(row => {
                const status = row.getAttribute('data-status');
                return filter === 'all' || status === filter;
            });

            // You can add count display here if needed
            console.log(`Showing ${visibleRows.length} requests for filter: ${filter}`);
        }

        // Add smooth transitions
        tableRows.forEach(row => {
            row.style.transition = 'all 0.3s ease';
        });
    });

    // Bulk Delete Functionality
    function toggleSelectAll() {
        const selectAllCheckbox = document.getElementById('selectAll');
        const leaveCheckboxes = document.querySelectorAll('.leave-checkbox');

        leaveCheckboxes.forEach(checkbox => {
            checkbox.checked = selectAllCheckbox.checked;
        });

        updateBulkActions();
    }

    function updateBulkActions() {
        const selectedCheckboxes = document.querySelectorAll('.leave-checkbox:checked');
        const selectAllCheckbox = document.getElementById('selectAll');
        const totalCheckboxes = document.querySelectorAll('.leave-checkbox');

        // Update select all checkbox state
        if (selectedCheckboxes.length === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (selectedCheckboxes.length === totalCheckboxes.length) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
        }
    }

    function showBulkDeleteModal(type) {
        const modal = new bootstrap.Modal(document.getElementById('bulkDeleteModal'));
        const content = document.getElementById('bulkDeleteContent');
        const confirmBtn = document.getElementById('confirmBulkDelete');
        const modalTitle = document.getElementById('bulkDeleteModalLabel');

        let title = '';
        let description = '';
        let count = 0;
        let deleteType = type;

        if (type === 'selected') {
            const selectedCheckboxes = document.querySelectorAll('.leave-checkbox:checked');
            count = selectedCheckboxes.length;

            if (count === 0) {
            // Ganti alert ke tampilan modal sederhana
            modalTitle.textContent = 'No Jobs Selected';
            content.innerHTML = `
                <div class="text-center p-3">
                    <i class="fas fa-info-circle fa-3x text-warning mb-3"></i>
                    <p class="mb-2 fs-5">Please select at least one job to delete.</p>
                </div>
            `;
            confirmBtn.style.display = 'none'; // Sembunyikan tombol "Delete"
            modal.show();
            return;
        }

            title = `Delete ${count} Selected Leave Request${count > 1 ? 's' : ''}`;
            description = `You are about to delete ${count} selected leave request${count > 1 ? 's' : ''}. This action will permanently remove ${count > 1 ? 'these records' : 'this record'} from the system.`;
        } else if (type === 'approved') {
            const approvedRows = document.querySelectorAll('[data-status="approved"]');
            count = approvedRows.length;
            title = `Delete All Approved Leave Requests`;
            description = `You are about to delete all ${count} approved leave requests. This will help clean up your database by removing processed requests.`;
        } else if (type === 'rejected') {
            const rejectedRows = document.querySelectorAll('[data-status="rejected"]');
            count = rejectedRows.length;
            title = `Delete All Rejected Leave Requests`;
            description = `You are about to delete all ${count} rejected leave requests. This will help clean up your database by removing declined requests.`;
        } else if (type === 'all') {
            const allRows = document.querySelectorAll('.leave-row');
            count = allRows.length;
            title = `Delete ALL Leave Requests`;
            description = `⚠️ DANGER: You are about to delete ALL ${count} leave requests in the system. This includes pending, approved, rejected, and waiting requests. This action will completely clear your leave management database.`;
        }

        content.innerHTML = `
            <div class="text-center mb-3">
                <h6 class="text-danger">${title}</h6>
                <p class="text-muted">${description}</p>
                <div class="badge bg-danger fs-6 px-3 py-2">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    ${count} Record${count > 1 ? 's' : ''} will be deleted
                </div>
            </div>
        `;

        // Store delete type and count for confirmation
        confirmBtn.setAttribute('data-delete-type', deleteType);
        confirmBtn.setAttribute('data-count', count);

        modal.show();
    }

    // Handle bulk delete confirmation
    document.getElementById('confirmBulkDelete').addEventListener('click', function() {
        const deleteType = this.getAttribute('data-delete-type');
        const count = this.getAttribute('data-count');

        // Show loading state
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Deleting...';
        this.disabled = true;

        // Prepare data for deletion
        let deleteData = {
            type: deleteType,
            _token: '<?php echo e(csrf_token()); ?>'
        };

        if (deleteType === 'selected') {
            const selectedIds = Array.from(document.querySelectorAll('.leave-checkbox:checked'))
                                   .map(checkbox => checkbox.value);
            deleteData.ids = selectedIds;
        }

        // Send delete request
        fetch('<?php echo e(route("leave.bulk-delete")); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify(deleteData)
        })
        .then(response => {
            console.log('Response received:', response);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Close modal
                bootstrap.Modal.getInstance(document.getElementById('bulkDeleteModal')).hide();

                // Show success message
                showNotification(`Successfully deleted ${data.deleted_count} leave request${data.deleted_count > 1 ? 's' : ''}.`, 'success');

                // Reload page after short delay
                setTimeout(() => {
                    window.location.reload();
                }, 1500);
            } else {
                throw new Error(data.message || 'Delete operation failed');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to delete leave requests. Please try again.', 'danger');

            // Reset button
            this.innerHTML = '<i class="fas fa-trash me-1"></i>Delete Records';
            this.disabled = false;
        });
    });

    // Show Leave Detail Modal
    function showLeaveDetail(leaveId) {
        // Fetch leave details via AJAX
        fetch(`/leave/${leaveId}/detail`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const leave = data.leave;

                    // Populate employee information
                    document.getElementById('detailEmployeeName').textContent = leave.employee?.name || 'Unknown';
                    document.getElementById('detailEmployeeEmail').textContent = leave.employee?.email || '-';
                    document.getElementById('detailEmployeeDepartment').textContent = leave.employee?.department || '-';
                    document.getElementById('detailEmployeePosition').textContent = leave.employee?.position || '-';

                    // Populate leave information
                    document.getElementById('detailLeaveType').textContent = leave.leave_type_display || leave.leave_type;
                    document.getElementById('detailLeaveDuration').textContent = `${leave.start_date_formatted} - ${leave.end_date_formatted}`;
                    document.getElementById('detailTotalDays').textContent = `${leave.total_days} hari`;

                    // Status with badge
                    const statusElement = document.getElementById('detailStatus');
                    let statusBadge = '';
                    switch(leave.status) {
                        case 'pending':
                            statusBadge = '<span class="badge bg-info">Menunggu</span>';
                            break;
                        case 'waiting':
                            statusBadge = '<span class="badge bg-warning">Menunggu Persetujuan</span>';
                            break;
                        case 'approved':
                            statusBadge = '<span class="badge bg-success">Disetujui</span>';
                            break;
                        case 'rejected':
                            statusBadge = '<span class="badge bg-danger">Ditolak</span>';
                            break;
                        default:
                            statusBadge = `<span class="badge bg-secondary">${leave.status}</span>`;
                    }
                    statusElement.innerHTML = statusBadge;

                    // Populate reason
                    document.getElementById('detailReason').textContent = leave.reason || '-';

                    // Show/hide approval information
                    const approvalCard = document.getElementById('approvalInfoCard');
                    if (leave.status === 'approved' || leave.status === 'rejected') {
                        document.getElementById('detailApprovedBy').textContent = leave.approved_by_name || '-';
                        document.getElementById('detailApprovedAt').textContent = leave.approved_at_formatted || '-';
                        document.getElementById('detailAdminNotes').textContent = leave.admin_notes || 'Tidak ada catatan';
                        approvalCard.style.display = 'block';
                    } else {
                        approvalCard.style.display = 'none';
                    }

                    // Show/hide attachment
                    const attachmentCard = document.getElementById('attachmentCard');
                    if (leave.attachment) {
                        const attachmentElement = document.getElementById('detailAttachment');
                        attachmentElement.innerHTML = `
                            <a href="/storage/${leave.attachment}" target="_blank" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-download me-1"></i>Download Lampiran
                            </a>
                        `;
                        attachmentCard.style.display = 'block';
                    } else {
                        attachmentCard.style.display = 'none';
                    }

                    // Add action buttons based on status and permissions
                    const actionButtonsContainer = document.getElementById('detailActionButtons');
                    let actionButtons = '';

                    if ((leave.status === 'pending' || leave.status === 'waiting') && data.can_approve) {
                        actionButtons += `
                            <button type="button" class="btn btn-success me-2" onclick="approveLeaveRequest(${leave.id}, '${leave.employee?.name || 'Employee'}', '${leave.leave_type_display}', '${leave.start_date_formatted}', '${leave.end_date_formatted}', ${leave.total_days})">
                                <i class="fas fa-check me-1"></i>Setujui
                            </button>
                            <button type="button" class="btn btn-danger me-2" onclick="rejectLeaveRequest(${leave.id}, '${leave.employee?.name || 'Employee'}', '${leave.leave_type_display}', '${leave.start_date_formatted}', '${leave.end_date_formatted}', ${leave.total_days})">
                                <i class="fas fa-times me-1"></i>Tolak
                            </button>
                        `;
                    }

                    if (leave.status === 'pending' && data.can_edit) {
                        actionButtons += `
                            <a href="/leave/${leave.id}/edit" class="btn btn-warning me-2">
                                <i class="fas fa-edit me-1"></i>Edit
                            </a>
                        `;
                    }

                    actionButtonsContainer.innerHTML = actionButtons;

                    // Show the modal
                    const modal = new bootstrap.Modal(document.getElementById('leaveDetailModal'));
                    modal.show();
                } else {
                    alert('Error loading leave details: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error loading leave details');
            });
    }

    // Individual Delete Confirmation Functions
    let currentDeleteLeaveId = null;

    function showDeleteConfirmModal(leaveId, employeeName, leaveType, startDate, endDate) {
        currentDeleteLeaveId = leaveId;

        // Populate modal with leave information
        const deleteLeaveInfo = document.getElementById('deleteLeaveInfo');
        deleteLeaveInfo.innerHTML = `
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title text-danger">Leave Request Details:</h6>
                    <div class="row">
                        <div class="col-sm-4"><strong>Employee:</strong></div>
                        <div class="col-sm-8">${employeeName}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Leave Type:</strong></div>
                        <div class="col-sm-8">${leaveType}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4"><strong>Duration:</strong></div>
                        <div class="col-sm-8">${startDate} to ${endDate}</div>
                    </div>
                </div>
            </div>
        `;

        // Show the modal
        const modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        modal.show();
    }

    // Handle individual delete confirmation
    document.getElementById('confirmIndividualDelete').addEventListener('click', function() {
        if (!currentDeleteLeaveId) {
            showNotification('Error: No leave request selected for deletion.', 'danger');
            return;
        }

        // Show loading state
        this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Deleting...';
        this.disabled = true;

        // Create a form and submit it
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/leave/${currentDeleteLeaveId}`;
        form.style.display = 'none';

        // Add CSRF token
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '<?php echo e(csrf_token()); ?>';
        form.appendChild(csrfToken);

        // Add DELETE method
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);

        // Add form to body and submit
        document.body.appendChild(form);
        form.submit();
    });

    // Enhanced Approve Function
    function approveLeaveRequest(leaveId, employeeName, leaveType, startDate, endDate, totalDays) {
        currentLeaveId = leaveId;

        // Populate modal data
        document.getElementById('approveEmployeeName').textContent = employeeName;
        document.getElementById('approveLeaveType').textContent = leaveType;
        document.getElementById('approveDuration').textContent = `${startDate} to ${endDate}`;
        document.getElementById('approveTotalDays').textContent = `${totalDays} day(s)`;

        // Clear previous message
        document.getElementById('approveMessage').value = '';

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('approveModal'));
        modal.show();
    }

    // Enhanced Reject Function
    function rejectLeaveRequest(leaveId, employeeName, leaveType, startDate, endDate, totalDays) {
        currentLeaveId = leaveId;

        // Populate modal data
        document.getElementById('rejectEmployeeName').textContent = employeeName;
        document.getElementById('rejectLeaveType').textContent = leaveType;
        document.getElementById('rejectDuration').textContent = `${startDate} to ${endDate}`;
        document.getElementById('rejectTotalDays').textContent = `${totalDays} day(s)`;

        // Clear previous reason
        document.getElementById('rejectReason').value = '';

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
        modal.show();
    }

    // Set quick rejection reason
    function setQuickReason(reason) {
        const textarea = document.getElementById('rejectReason');
        if (textarea.value.trim() === '') {
            textarea.value = reason;
        } else {
            textarea.value += '. ' + reason;
        }
        textarea.focus();
    }

    // Show loading state
    function showLoadingState(button, message = 'Processing...') {
        const originalContent = button.innerHTML;
        button.innerHTML = `<i class="fas fa-spinner fa-spin me-1"></i>${message}`;
        button.disabled = true;
        return originalContent;
    }

    // Show notification
    function showNotification(message, type = 'success') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
        alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border-radius: 8px;';

        const iconMap = {
            success: 'check-circle',
            danger: 'exclamation-circle',
            warning: 'exclamation-triangle',
            info: 'info-circle'
        };

        alertDiv.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-${iconMap[type]} me-2"></i>
                <div>${message}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;

        document.body.appendChild(alertDiv);

        // Auto remove after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }

    // Submit approval
    function submitApproval() {
        const button = document.getElementById('confirmApproveBtn');
        const originalContent = showLoadingState(button, 'Approving...');

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/leave/${currentLeaveId}/approve`;
        form.style.display = 'none';

        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        // Add admin message if provided
        const message = document.getElementById('approveMessage').value.trim();
        if (message) {
            const messageInput = document.createElement('input');
            messageInput.type = 'hidden';
            messageInput.name = 'admin_message';
            messageInput.value = message;
            form.appendChild(messageInput);
        }

        document.body.appendChild(form);
        form.submit();
    }

    // Submit rejection
    function submitRejection() {
        const reason = document.getElementById('rejectReason').value.trim();

        if (!reason) {
            showNotification('Please provide a rejection reason.', 'danger');
            document.getElementById('rejectReason').focus();
            return;
        }

        const button = document.getElementById('confirmRejectBtn');
        const originalContent = showLoadingState(button, 'Rejecting...');

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/leave/${currentLeaveId}/reject`;
        form.style.display = 'none';

        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        form.appendChild(csrfInput);

        // Add admin notes
        const notesInput = document.createElement('input');
        notesInput.type = 'hidden';
        notesInput.name = 'admin_notes';
        notesInput.value = reason;
        form.appendChild(notesInput);

        document.body.appendChild(form);
        form.submit();
    }

    // Initialize when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Bind approve button
        document.getElementById('confirmApproveBtn').addEventListener('click', submitApproval);

        // Bind reject button
        document.getElementById('confirmRejectBtn').addEventListener('click', submitRejection);

        // Auto-hide alerts after 5 seconds
        const alerts = document.querySelectorAll('.alert:not(.modal .alert)');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                if (alert.parentNode) {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }
            }, 5000);
        });

        console.log('✅ Enhanced Leave Management System initialized');
    });
</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Dimas\Desktop\Gitlab\backoffice-fasya\resources\views/leave/index.blade.php ENDPATH**/ ?>