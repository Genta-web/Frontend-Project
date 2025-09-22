@extends('layouts.admin')

@section('title', 'Leave Request Details')

@if (session('success'))
<div class="popup-overlay" id="successPopup">
    <div class="popup-card">
        <div class="popup-icon">
            {{-- Ikon centang (check) --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
            </svg>
        </div>
        <h2 class="popup-title">Success!</h2>
        <p class="popup-message">{{ session('success') }}</p>
        <button class="popup-button" id="closePopup">OK</button>
    </div>
</div>
@endif

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

@push('styles')
<style>

    .leave-detail-page {
        background: #f8fafc !important; /* Warna abu-abu muda, !important untuk memaksa */
        padding: 2rem !important;      /* Memastikan padding tetap ada */
        margin: 1rem !important;        /* Memastikan margin tetap ada */
        border-radius: 15px !important; /* Memastikan sudut tetap ada */
    }

    /* 🎯 Enhanced Action Buttons */
    .action-btn-approve, .action-btn-reject {
        transition: all 0.3s ease;
        font-weight: 600;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .action-btn-approve:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.3) !important;
    }

    .action-btn-reject:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.3) !important;
    }

    /* 🚀 Floating Action Buttons */
    .floating-actions {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 1000;
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .floating-btn {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        color: white;
        font-size: 1.5rem;
    }

    .floating-btn-approve {
        background: linear-gradient(45deg, #28a745, #20c997);
    }

    .floating-btn-reject {
        background: linear-gradient(45deg, #dc3545, #e74c3c);
    }

    .floating-btn:hover {
        transform: scale(1.1) translateY(-2px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
    }

    .floating-btn-approve:hover {
        box-shadow: 0 8px 30px rgba(40, 167, 69, 0.5);
    }

    .floating-btn-reject:hover {
        box-shadow: 0 8px 30px rgba(220, 53, 69, 0.5);
    }

    /* Enhanced Attachment Styling */
    .attachment-container {
        border: 2px solid #e9ecef !important;
        transition: all 0.3s ease;
    }

    .attachment-container:hover {
        border-color: #007bff !important;
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.1);
    }

    .attachment-preview {
        transition: all 0.3s ease;
        border: 3px solid #fff;
    }

    .attachment-preview:hover {
        transform: scale(1.02);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2) !important;
    }

    .file-info {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border: 1px solid #e9ecef;
    }

    .file-details .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.6rem;
    }

    .btn-group .btn {
        border-radius: 6px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn-group .btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    /* Image Modal Enhancements */
    .modal-xl {
        max-width: 90vw;
    }

    #modalImage {
        border-radius: 8px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .modal-content {
        border-radius: 15px;
        overflow: hidden;
    }

    .modal-header.bg-dark {
        border-bottom: none;
    }

    .modal-footer.bg-light {
        border-top: 1px solid #dee2e6;
    }

    /* Image Cards Styling */
    .image-card {
        position: relative;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .image-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(109, 178, 252, 0.15);
        border-color: #007bff;
    }

    .card .card-header {
    background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%);
    color: white;
    }

    .primary-badge {
        position: absolute;
        top: 8px;
        right: 8px;
        background: linear-gradient(45deg, #ffc107, #ffb300);
        color: white;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: bold;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }

    .image-container {
        position: relative;
        overflow: hidden;
    }

    .image-thumbnail {
        transition: all 0.3s ease;
    }

    .image-thumbnail:hover {
        transform: scale(1.05);
    }

    .image-error {
        display: none !important;
    }

    .image-error.show {
        display: flex !important;
    }

    /* Responsive Design for Attachments */
    @media (max-width: 768px) {
        .attachment-preview {
            max-height: 250px !important;
        }

        .btn-group {
            flex-direction: column;
            width: 100%;
        }

        .btn-group .btn {
            margin-bottom: 0.5rem;
            border-radius: 6px !important;
        }

        .modal-xl {
            max-width: 95vw;
        }

        #modalImage {
            max-height: 60vh !important;
        }

        .file-info .row {
            text-align: center;
        }

        .file-details {
            margin-top: 1rem;
        }

        .file-details .badge {
            display: block;
            margin: 0.25rem 0;
            width: 100%;
        }
    }

    /* Enhanced Admin Action Panel */
    .card.border-warning {
        border-width: 2px !important;
        animation: pulse-border 2s infinite;
    }

    @keyframes pulse-border {
        0% { border-color: #ffc107; }
        50% { border-color: #ffca2c; }
        100% { border-color: #ffc107; }
    }

    .card-header.bg-warning {
        background: linear-gradient(45deg, #ffc107, #ffca2c) !important;
        animation: pulse-bg 1s infinite;
    }

    @keyframes pulse-bg {
        0% { background: linear-gradient(45deg, #ffc107, #ffca2c) !important; }
        50% { background: linear-gradient(45deg, #ffca2c, #ffd43b) !important; }
        100% { background: linear-gradient(45deg, #ffc107, #ffca2c) !important; }
    }

    @media (max-width: 768px) {
        .leave-detail-page {
            margin: 0.5rem;
            padding: 1rem;
            border-radius: 10px;
        }

        .floating-actions {
            bottom: 20px;
            right: 20px;
        }

        .floating-btn {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }

        .action-btn-approve, .action-btn-reject {
            font-size: 0.9rem;
            padding: 0.75rem 1rem;
        }
    }

        /* CSS UNTUK HEADER BARU */
    .dashboard-header {
        background: linear-gradient(135deg, #03a9f4 0%, #0288d1 100%);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(3, 169, 244, 0.4);
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
        margin: 0;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    .dashboard-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-top: 0.5rem;
    }
    .header-action-btn {
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
    .header-action-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(3, 169, 244, 0.5);
        background: linear-gradient(135deg, #0288d1 0%, #03a9f4 50%, #29b6f6 100%);
        color: white;
    }

    .dashboard-header .row {
        position: relative;
        z-index: 2;
    }
</style>
@endpush

@section('content')
<div class="leave-detail-page py-4">
    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-lg mb-4" role="alert" style="background: rgba(40, 167, 69, 0.1); border: 2px solid #28a745; backdrop-filter: blur(10px);">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle text-success me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <h6 class="alert-heading mb-1 text-success">✅ Success!</h6>
                    <p class="mb-0 text-dark">{{ session('success') }}</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-lg mb-4" role="alert" style="background: rgba(220, 53, 69, 0.1); border: 2px solid #dc3545; backdrop-filter: blur(10px);">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle text-danger me-3" style="font-size: 1.5rem;"></i>
                <div>
                    <h6 class="alert-heading mb-1 text-danger">❌ Error!</h6>
                    <p class="mb-0 text-dark">{{ session('error') }}</p>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif



    <!-- Admin Action Panel (if admin and pending) -->
    @if($leave->isPending() && Auth::user()->hasRole(['admin', 'hr', 'manager']))
    <div class="alert alert-warning border-0 shadow-lg mb-4" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle text-warning me-3" style="font-size: 1.8rem;"></i>
                <div>
                    <h5 class="alert-heading mb-1 text-dark">⚡ Admin Action Required</h5>
                    <p class="mb-0 text-muted">This leave request from <strong>{{ $leave->employee->name ?? 'Employee' }}</strong> is pending your review and decision.</p>
                </div>
            </div>
            <div class="d-flex gap-2 flex-wrap">
                <!-- APPROVE BUTTON -->
                <button type="button" class="btn btn-success btn-lg shadow-lg action-btn-approve" onclick="showApprovalModal()"
                        style="background: linear-gradient(45deg, #28a745, #20c997); border: none; min-width: 160px;">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>✅ APPROVE</strong>
                </button>

                <!-- REJECT BUTTON -->
                <button type="button" class="btn btn-danger btn-lg shadow-lg action-btn-reject" onclick="showRejectionModal()"
                        style="background: linear-gradient(45deg, #dc3545, #e74c3c); border: none; min-width: 160px;">
                    <i class="fas fa-times-circle me-2"></i>
                    <strong>❌ REJECT</strong>
                </button>

                <!-- QUICK APPROVE BUTTON -->
                <form action="{{ route('leave.approve', $leave) }}" method="POST" style="display: inline;">
                    @csrf
                    <input type="hidden" name="admin_message" value="Your leave request has been approved.">
                    <button type="submit" class="btn btn-outline-success btn-lg"
                            onclick="return confirm('Quick Approve?\n\nEmployee: {{ $leave->employee->name ?? 'N/A' }}\nType: {{ $leave->leave_type_display }}\nDuration: {{ $leave->start_date->format('d M Y') }} - {{ $leave->end_date->format('d M Y') }}\n\nApprove without additional message?')"
                            title="Quick approve without message">
                        <i class="fas fa-bolt me-1"></i>Quick Approve
                    </button>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Page Header -->
    <div class="dashboard-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="dashboard-title">
                    <i class="fas fa-calendar-check me-3"></i>Leave Request Details
                </h1>
                <p class="dashboard-subtitle">
                    Review and manage employee leave request
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <a href="{{ route('leave.index') }}" class="header-action-btn">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <!-- Status Alert -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2" style="font-size: 1.25rem;"></i>
                <div>{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2" style="font-size: 1.25rem;"></i>
                <div>{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Main Leave Details -->
        <div class="col-lg-8 mb-4">
            <!-- Employee Information Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-white">
                        <i class="fas fa-user me-2"></i>Employee Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column flex-sm-row align-items-center align-items-sm-start text-center text-sm-start mb-3">
                        @if($leave->employee && $leave->employee->user && $leave->employee->user->profile_photo)
                            <img src="{{ asset('storage/' . $leave->employee->user->profile_photo) }}"
                                 class="rounded-circle mb-3 mb-sm-0 me-sm-3 shadow" width="64" height="64" alt="Profile">
                        @else
                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center mb-3 mb-sm-0 me-sm-3"
                                 style="width: 64px; height: 64px;">
                                <i class="fas fa-user text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        @endif
                        <div>
                            <h4 class="mb-1 text-gray-800">{{ $leave->employee->name ?? 'N/A' }}</h4>
                            <p class="text-muted mb-1">{{ $leave->employee->employee_code ?? 'N/A' }}</p>
                            <p class="text-muted mb-0">{{ $leave->employee->department ?? 'N/A' }} - {{ $leave->employee->position ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Leave Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-white">
                        <i class="fas fa-calendar-alt me-2"></i>Leave Request Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="form-label text-muted fw-bold">Leave Type</label>
                                <div class="mt-1">
                                    <span class="badge bg-info fs-6 px-3 py-2">
                                        <i class="fas fa-tag me-1"></i>{{ $leave->leave_type_display }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="form-label text-muted fw-bold">Duration</label>
                                <div class="mt-1">
                                    <span class="badge bg-secondary fs-6 px-3 py-2">
                                        <i class="fas fa-clock me-1"></i>{{ $leave->total_days }} day(s)
                                    </span>
                                    @if($leave->start_date <= now()->addDays(3) && $leave->status === 'pending')
                                        <span class="badge bg-warning ms-2">
                                            <i class="fas fa-exclamation-triangle me-1"></i>Urgent
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="form-label text-muted fw-bold">Start Date</label>
                                <div class="mt-1">
                                    <div class="fw-bold text-gray-800">{{ $leave->start_date->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $leave->start_date->format('l') }}</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="form-label text-muted fw-bold">End Date</label>
                                <div class="mt-1">
                                    <div class="fw-bold text-gray-800">{{ $leave->end_date->format('d M Y') }}</div>
                                    <small class="text-muted">{{ $leave->end_date->format('l') }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="info-item">
                        <label class="form-label text-muted fw-bold">Reason</label>
                        <div class="mt-2 p-3 bg-light rounded border-start border-primary border-4">
                            <p class="mb-0 text-gray-800">{{ $leave->reason }}</p>
                        </div>
                    </div>

                    @if($leave->attachment || $leave->hasImages())
                        <div class="info-item">
                            <label class="form-label text-muted fw-bold">
                                <i class="fas fa-paperclip me-2 text-primary"></i>
                                Attachments & Images
                            </label>
                            <div class="mt-3">
                                @php
                                    $attachmentPath = $leave->attachment;
                                    $extension = pathinfo($attachmentPath, PATHINFO_EXTENSION);
                                    $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp']);
                                    $fileName = basename($attachmentPath);
                                    $attachmentUrl = $leave->attachment_url;
                                    $fileExists = $leave->attachmentExists();
                                    $fileSize = '';

                                    // Get file size using the model method
                                    $fileSizeBytes = $leave->getAttachmentSize();
                                    if ($fileSizeBytes > 0) {
                                        if ($fileSizeBytes > 1024 * 1024) {
                                            $fileSize = number_format($fileSizeBytes / (1024 * 1024), 1) . ' MB';
                                        } else {
                                            $fileSize = number_format($fileSizeBytes / 1024, 1) . ' KB';
                                        }
                                    } else {
                                        $fileSize = 'Unknown size';
                                    }
                                @endphp

                                @if($leave->attachment && !$fileExists)
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>File Not Found:</strong> The attachment file could not be located.
                                        <br><small>Path: {{ $attachmentPath }}</small>
                                        <br><small>URL: {{ $attachmentUrl }}</small>
                                        <br><small class="text-muted">Please check if the storage link is working: <code>php artisan storage:link</code></small>
                                    </div>
                                @endif

                                <div class="attachment-container p-3 bg-light rounded border">
                                    @if($isImage && $fileExists)
                                        <!-- Image Preview -->
                                        <div class="image-preview-container mb-3">
                                            <div class="text-center">
                                                <img src="{{ $attachmentUrl }}"
                                                     alt="Leave attachment"
                                                     class="img-fluid attachment-preview"
                                                     style="max-width: 100%; max-height: 400px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); cursor: pointer;"
                                                     onclick="openImageModal('{{ $attachmentUrl }}', '{{ $fileName }}')"
                                                     onerror="this.style.display='none'; this.nextElementSibling.classList.add('show');">
                                                <div class="image-error text-center p-4" style="height: 300px; align-items: center; justify-content: center; flex-direction: column; background-color: #f8f9fa;">
                                                    <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                    <br>
                                                    <small class="text-muted">Image could not be loaded</small>
                                                    <br>
                                                    <small class="text-muted">{{ $fileName }}</small>
                                                </div>
                                                <div class="mt-2">
                                                    <small class="text-muted">
                                                        <i class="fas fa-info-circle me-1"></i>
                                                        Click image to view full size
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <!-- File Icon for Non-Images -->
                                        <div class="text-center mb-3">
                                            @php
                                                $iconClass = 'fa-file';
                                                $iconColor = 'text-secondary';

                                                switch(strtolower($extension)) {
                                                    case 'pdf':
                                                        $iconClass = 'fa-file-pdf';
                                                        $iconColor = 'text-danger';
                                                        break;
                                                    case 'doc':
                                                    case 'docx':
                                                        $iconClass = 'fa-file-word';
                                                        $iconColor = 'text-primary';
                                                        break;
                                                    case 'xls':
                                                    case 'xlsx':
                                                        $iconClass = 'fa-file-excel';
                                                        $iconColor = 'text-success';
                                                        break;
                                                    case 'txt':
                                                        $iconClass = 'fa-file-alt';
                                                        $iconColor = 'text-info';
                                                        break;
                                                }
                                            @endphp
                                            <i class="fas {{ $iconClass }} fa-4x {{ $iconColor }} mb-2"></i>
                                        </div>
                                    @endif

                                    <!-- File Information -->
                                    <div class="file-info bg-white p-3 rounded border">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h6 class="mb-1 text-dark">
                                                    <i class="fas fa-file me-2"></i>
                                                    {{ $fileName }}
                                                </h6>
                                                <div class="file-details">
                                                    <span class="badge bg-light text-dark me-2">
                                                        <i class="fas fa-tag me-1"></i>
                                                        {{ strtoupper($extension) }}
                                                    </span>
                                                    @if($fileSize)
                                                        <span class="badge bg-light text-dark me-2">
                                                            <i class="fas fa-weight me-1"></i>
                                                            {{ $fileSize }}
                                                        </span>
                                                    @endif
                                                    <span class="badge bg-light text-dark">
                                                        <i class="fas fa-clock me-1"></i>
                                                        Uploaded {{ $leave->created_at->diffForHumans() }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-md-5 pe-5 pt-2 text-md-end mt-2 mt-md-0" >
                                                <div class="btn-group" role="group">
                                                    <a href="{{ $attachmentUrl }}"
                                                       target="_blank"
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-eye me-1"></i>
                                                        View
                                                    </a>
                                                    <a href="{{ $attachmentUrl }}"
                                                       download="{{ $fileName }}"
                                                       class="btn btn-outline-primary btn-sm">
                                                        <i class="fas fa-download me-1"></i>
                                                        Download
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- New Images Section -->
                        @if($leave->hasImages())
                            <div class="mt-4">
                                <h6 class="text-muted fw-bold mb-3">
                                    <i class="fas fa-images me-2 text-primary"></i>
                                    Images ({{ count($leave->images) }})
                                </h6>

                                <div class="row">
                                    @foreach($leave->getImagesWithUrls() as $index => $image)
                                        @if(isset($image['url']) && isset($image['original_name']))
                                            <div class="col-md-4 col-sm-6 mb-3">
                                                <div class="card image-card">
                                                    @if($index === 0)
                                                        <div class="primary-badge">
                                                            <i class="fas fa-star"></i> Primary
                                                        </div>
                                                    @endif

                                                    <div class="image-container">
                                                        <img src="{{ $image['url'] }}"
                                                             alt="{{ $image['original_name'] ?? 'Image' }}"
                                                             class="card-img-top image-thumbnail"
                                                             style="height: 200px; object-fit: cover; cursor: pointer;"
                                                             onclick="openImageModal('{{ $image['url'] }}', '{{ $image['original_name'] ?? 'Image' }}')"
                                                             onerror="this.style.display='none'; this.nextElementSibling.classList.add('show');">
                                                        <div class="image-error text-center p-4" style="display: none; height: 200px; align-items: center; justify-content: center; flex-direction: column; background-color: #f8f9fa;">
                                                            <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                                            <small class="text-muted">Image could not be loaded</small>
                                                            <small class="text-muted mt-1">{{ $image['original_name'] ?? 'Unknown file' }}</small>
                                                        </div>
                                                    </div>

                                                    <div class="card-body p-2">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <div class="flex-grow-1">
                                                                <small class="text-muted d-block" title="{{ $image['original_name'] ?? 'Image' }}">
                                                                    {{ Str::limit($image['original_name'] ?? 'Image', 20) }}
                                                                </small>
                                                                <small class="text-muted">
                                                                    {{ $image['formatted_size'] ?? '0 KB' }}
                                                                    @if(isset($image['width']) && isset($image['height']) && $image['width'] && $image['height'])
                                                                        • {{ $image['width'] }}×{{ $image['height'] }}
                                                                    @endif
                                                                </small>
                                                            </div>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                                        type="button" data-bs-toggle="dropdown">
                                                                    <i class="fas fa-ellipsis-v"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ $image['url'] }}" target="_blank">
                                                                            <i class="fas fa-eye me-2"></i>View Full Size
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ $image['url'] }}" download="{{ $image['original_name'] ?? 'image' }}">
                                                                            <i class="fas fa-download me-2"></i>Download
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    @else
                        <div class="info-item">
                            <label class="form-label text-muted fw-bold">
                                <i class="fas fa-paperclip me-2 text-primary"></i>
                                Attachments & Images
                            </label>
                            <div class="mt-3">
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No attachments or images were uploaded with this leave request.
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Status and Actions Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-white">
                        <i class="fas fa-flag me-2"></i>Status Information
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-4">
                        @if($leave->status === 'pending')
                            <span class="status-badge bg-warning text-dark">
                                <i class="fas fa-clock me-2"></i>Pending Review
                            </span>
                        @elseif($leave->status === 'approved')
                            <span class="status-badge bg-success text-white">
                                <i class="fas fa-check me-2"></i>Approved
                            </span>
                        @elseif($leave->status === 'rejected')
                            <span class="status-badge bg-danger text-white">
                                <i class="fas fa-times me-2"></i>Rejected
                            </span>
                        @endif
                    </div>

                    <div class="mb-4">
                        <div class="text-muted mb-1">Applied on</div>
                        <div class="fw-bold text-gray-800">{{ $leave->created_at->format('d M Y') }}</div>
                        <div class="text-muted small">{{ $leave->created_at->format('H:i') }} - {{ $leave->created_at->diffForHumans() }}</div>
                    </div>

                    @if($leave->status === 'approved' || $leave->status === 'rejected')
                        <div class="mb-4">
                            <div class="text-muted mb-1">{{ ucfirst($leave->status) }} by</div>
                            <div class="fw-bold text-gray-800">{{ $leave->approvedBy->username ?? 'Admin' }}</div>
                            <div class="text-muted small">{{ $leave->approved_at ? $leave->approved_at->format('d M Y H:i') : '' }}</div>
                            <div class="text-muted small">{{ $leave->approved_at ? $leave->approved_at->diffForHumans() : '' }}</div>
                        </div>
                    @endif

                    @if($leave->status === 'rejected' && $leave->admin_notes)
                        <div class="alert alert-danger border-0 shadow-sm">
                            <div class="fw-bold mb-2">
                                <i class="fas fa-exclamation-triangle me-2"></i>Rejection Reason:
                            </div>
                            <p class="mb-0">{{ $leave->admin_notes }}</p>
                        </div>
                    @endif

                    @if($leave->isPending() && Auth::user()->hasRole(['admin', 'hr', 'manager']))
                        <!-- 🎯 ENHANCED ADMIN ACTION PANEL -->
                        <div class="card border-warning shadow-lg mb-3">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0 fw-bold">
                                    <i class="fas fa-exclamation-triangle me-2"></i>⚡ ADMIN ACTION REQUIRED
                                </h6>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    This leave request requires your immediate attention and decision.
                                </p>
                                <div class="d-grid gap-2">
                                    <!-- APPROVE BUTTON -->
                                    <button type="button" class="btn btn-success btn-lg shadow action-btn-approve" onclick="showApprovalModal()">
                                        <i class="fas fa-check-circle me-2"></i>
                                        <strong>✅ APPROVE REQUEST</strong>
                                    </button>

                                    <!-- REJECT BUTTON -->
                                    <button type="button" class="btn btn-danger btn-lg shadow action-btn-reject" onclick="showRejectionModal()">
                                        <i class="fas fa-times-circle me-2"></i>
                                        <strong>❌ REJECT REQUEST</strong>
                                    </button>

                                    <!-- QUICK INFO -->
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Submitted {{ $leave->created_at->diffForHumans() }} •
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $leave->total_days }} day(s) requested
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-white">
                        <i class="fas fa-history me-2"></i>Request Timeline
                    </h6>
                </div>
                <div class="card-body">
                    <div class="timeline-item active">
                        <div class="fw-bold text-gray-800">Request Submitted</div>
                        <div class="text-muted small">{{ $leave->created_at->format('d M Y H:i') }}</div>
                        <div class="text-muted small">{{ $leave->created_at->diffForHumans() }}</div>
                    </div>

                    @if($leave->status === 'approved')
                        <div class="timeline-item active">
                            <div class="fw-bold text-success">Request Approved</div>
                            <div class="text-muted small">by {{ $leave->approvedBy->username ?? 'Admin' }}</div>
                            <div class="text-muted small">{{ $leave->approved_at ? $leave->approved_at->format('d M Y H:i') : '' }}</div>
                        </div>
                    @elseif($leave->status === 'rejected')
                        <div class="timeline-item rejected">
                            <div class="fw-bold text-danger">Request Rejected</div>
                            <div class="text-muted small">by {{ $leave->approvedBy->username ?? 'Admin' }}</div>
                            <div class="text-muted small">{{ $leave->approved_at ? $leave->approved_at->format('d M Y H:i') : '' }}</div>
                        </div>
                    @else
                        <div class="timeline-item">
                            <div class="fw-bold text-muted">Pending Review</div>
                            <div class="text-muted small">Waiting for approval</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            @if(!Auth::user()->isEmployee())
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 fw-bold text-white">
                        <i class="fas fa-tools me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('leave.index', ['employee_id' => $leave->employee_id]) }}"
                           class="btn btn-outline-info btn-sm">
                            <i class="fas fa-user me-2"></i>View Employee's Leaves
                        </a>
                        <a href="{{ route('leave.index', ['status' => 'pending']) }}"
                           class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-clock me-2"></i>View All Pending
                        </a>
                        @if($leave->isPending() && Auth::user()->hasRole(['admin', 'hr', 'manager']))
                            <a href="{{ route('leave.edit', $leave) }}"
                               class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-edit me-2"></i>Edit Request
                            </a>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Simple Approval Modal -->
<div class="modal fade" id="approvalModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="fas fa-check-circle me-2"></i>Approve Leave Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('leave.approve', $leave) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-success border-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle text-success me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <strong>Approve Leave Request</strong><br>
                                <span class="text-muted">Employee: {{ $leave->employee->name ?? 'N/A' }}</span><br>
                                <span class="text-muted">Leave Type: {{ $leave->leave_type_display }}</span><br>
                                <span class="text-muted">Duration: {{ $leave->start_date->format('d M Y') }} - {{ $leave->end_date->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="admin_message" class="form-label">
                            <strong>Message to Employee (Optional)</strong>
                        </label>
                        <textarea class="form-control" id="admin_message" name="admin_message" rows="3"
                                  placeholder="Add a personal message for the employee..."></textarea>
                        <div class="form-text">
                            This message will be included in the approval notification.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Quick Messages:</strong></label>
                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setApprovalMessage('Your leave request has been approved. Please ensure proper handover of responsibilities.')">
                                Standard Message
                            </button>
                            <button type="button" class="btn btn-outline-secondary btn-sm" onclick="setApprovalMessage('Approved with advance notice. Thank you for planning ahead.')">
                                Appreciation
                            </button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>Approve Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Simple Rejection Modal -->
<div class="modal fade" id="rejectionModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-times-circle me-2"></i>Reject Leave Request
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('leave.reject', $leave) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="alert alert-warning border-0">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-triangle text-warning me-3" style="font-size: 1.5rem;"></i>
                            <div>
                                <strong>Reject Leave Request</strong><br>
                                <span class="text-muted">Employee: {{ $leave->employee->name ?? 'N/A' }}</span><br>
                                <span class="text-muted">Leave Type: {{ $leave->leave_type_display }}</span><br>
                                <span class="text-muted">Duration: {{ $leave->start_date->format('d M Y') }} - {{ $leave->end_date->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Quick Rejection Reasons:</strong></label>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="setRejectionReason('Insufficient notice period - please submit requests at least 14 days in advance.')">
                                    Insufficient Notice
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="setRejectionReason('Peak business period - unable to approve leave during this time.')">
                                    Peak Period
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="setRejectionReason('Staffing shortage in your department - please coordinate with team.')">
                                    Staffing Shortage
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-danger w-100 btn-sm" onclick="setRejectionReason('Conflicting leave requests from team members.')">
                                    Conflicting Requests
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="admin_notes" class="form-label">
                            <strong>Reason for Rejection *</strong>
                        </label>
                        <textarea class="form-control" id="admin_notes" name="admin_notes" rows="4"
                                  placeholder="Please provide a clear reason for rejecting this leave request..." required></textarea>
                        <div class="form-text">
                            This reason will be sent to the employee via email notification.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alternative_suggestions" class="form-label">
                            <strong>Alternative Suggestions (Optional)</strong>
                        </label>
                        <textarea class="form-control" id="alternative_suggestions" name="alternative_suggestions" rows="3"
                                  placeholder="Suggest alternative dates or solutions..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-ban me-2"></i>Reject Request
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

<!-- Image Modal for Full Size View -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title" id="imageModalLabel">
                    <i class="fas fa-image me-2"></i>
                    Attachment Preview
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="modalImage" src="" alt="Full size attachment" class="img-fluid" style="max-height: 80vh;">
            </div>
            <div class="modal-footer bg-light">
                <div class="d-flex justify-content-between align-items-center w-100">
                    <span id="modalImageName" class="text-muted"></span>
                    <div>
                        <a id="modalDownloadBtn" href="" download="" class="btn btn-primary">
                            <i class="fas fa-download me-1"></i>
                            Download
                        </a>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/leave-actions.js') }}"></script>
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


// Image Modal Function
function openImageModal(imageSrc, fileName) {
    const modal = new bootstrap.Modal(document.getElementById('imageModal'));
    const modalImage = document.getElementById('modalImage');
    const modalImageName = document.getElementById('modalImageName');
    const modalDownloadBtn = document.getElementById('modalDownloadBtn');

    modalImage.src = imageSrc;
    modalImageName.textContent = fileName;
    modalDownloadBtn.href = imageSrc;
    modalDownloadBtn.download = fileName;

    modal.show();
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize Leave Actions Service
    window.leaveActions = new LeaveActionsService({
        routes: {
            approve: '{{ route("leave.approve", ":id") }}',
            reject: '{{ route("leave.reject", ":id") }}',
            destroy: '{{ route("leave.destroy", ":id") }}',
            bulkApprove: '{{ route("leave.bulk-approve") }}',
            bulkReject: '{{ route("leave.bulk-reject") }}'
        },
        csrfToken: '{{ csrf_token() }}',
        user: {
            isEmployee: {{ Auth::user()->isEmployee() ? 'true' : 'false' }},
            hasManagePermission: {{ Auth::user()->hasRole(['admin', 'hr', 'manager']) ? 'true' : 'false' }}
        }
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 2000);
    });

    // Debug: Check if service is initialized
    console.log('LeaveActionsService initialized:', !!window.leaveActions);
    console.log('User context:', window.leaveActions?.user);
    console.log('Current leave ID:', '{{ $leave->id }}');
    console.log('Leave status:', '{{ $leave->status }}');
    console.log('User role check:', {{ Auth::user()->hasRole(['admin', 'hr', 'manager']) ? 'true' : 'false' }});
});

// Simple modal functions
function showApprovalModal() {
    const modal = new bootstrap.Modal(document.getElementById('approvalModal'));
    modal.show();
}

function showRejectionModal() {
    const modal = new bootstrap.Modal(document.getElementById('rejectionModal'));
    modal.show();
}

function setApprovalMessage(message) {
    document.getElementById('admin_message').value = message;
}

function setRejectionReason(reason) {
    document.getElementById('admin_notes').value = reason;
}

// Legacy functions for backward compatibility
function approveLeave() {
    showApprovalModal();
}

function showRejectModal() {
    showRejectionModal();
}

function confirmDelete() {
    const leaveData = {
        leaveType: '{{ $leave->leave_type_display }}'
    };

    if (window.leaveActions) {
        window.leaveActions.confirmDelete('{{ $leave->id }}', leaveData);
    }
}
</script>
@endpush
