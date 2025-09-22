@extends('layouts.admin')

@section('content')
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
        background: linear-gradient(135deg, var(--primary-blue) 0%, var(--sky-blue) 100%);
        border-radius: 20px;
        color: white;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 40px rgba(14, 165, 233, 0.2);
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

    .form-container {
        width: 100%;
        margin: 0 auto;
    }

    .form-card {
        background: var(--white);
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        border: 1px solid var(--border-light);
        overflow: hidden;
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
        color: #ff8080;
        border: 2px solid #ff8080;
    }

    .btn-secondary-modern:hover {
        background: var(--light-gray);
        color: var(--text-dark);
        border-color: #f8b1b1ff;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 184, 184, 1);
    }

    .current-file-info {
        background: var(--light-blue);
        border: 1px solid rgba(14, 165, 233, 0.2);
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        padding-top: 2rem;
        border-top: 1px solid var(--border-light);
    }

    @media (max-width: 768px) {
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



            <!-- Form Container -->
            <div class="form-container">
                <div class="form-card">
                    <div class="form-card-header">
                        <h2 class="form-card-title" style="color: #08084eff;">
                            <i class="fas fa-file-alt"></i>
                            Document Information
                        </h2>
                    </div>
                    <div class="form-card-body">
                        <!-- Uploader Information -->
                        <div class="info-alert" style="margin-bottom: 2rem;">
                            <div class="info-alert-header">
                                <i class="fas fa-user-circle"></i>
                                Document Uploader
                            </div>
                            <div class="d-flex align-items-start">
                                <i class="fas fa-user text-primary me-3 fs-5 mt-1"></i>
                                <div style="word-wrap: break-word; word-break: break-word; white-space: normal; max-width: 100%;">
                                    <div class="fw-semibold" style="font-size: 1.1rem; word-wrap: break-word; word-break: break-word; white-space: normal;">
                                        {{ $document->uploader_name }}
                                    </div>
                                    @if($document->uploader)
                                        <small class="text-muted" style="word-wrap: break-word; word-break: break-all; white-space: normal; display: block; margin-top: 4px;">
                                            <i class="fas fa-envelope me-1"></i>{{ $document->uploader->email ?? '' }}
                                        </small>
                                        <small class="text-muted" style="display: block; margin-top: 2px;">
                                            <i class="fas fa-calendar me-1"></i>Uploaded on {{ $document->created_at->format('d M Y, H:i') }}
                                        </small>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <form action="{{ route('dokumen.update', $document->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="title" class="form-label">
                                    <i class="fas fa-heading"></i>
                                    Document Title
                                    <span class="required">*</span>
                                </label>
                                <input type="text"
                                       class="form-control @error('title') is-invalid @enderror"
                                       id="title"
                                       name="title"
                                       value="{{ old('title', $document->title) }}"
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="path" class="form-label">
                                    <i class="fas fa-file-upload"></i>
                                    Document File
                                </label>

                                @if($document->path)
                                    <div class="current-file-info">
                                        <div class="d-flex align-items-start justify-content-between">
                                            <div style="word-wrap: break-word; word-break: break-word; white-space: normal; max-width: 70%;">
                                                <strong>Current File:</strong>
                                                <div class="text-primary" style="word-wrap: break-word; word-break: break-all; white-space: normal; margin-top: 4px;">
                                                    {{ $document->original_name ?: basename($document->path) }}
                                                </div>
                                                @if($document->original_name && $document->file_size)
                                                    <small class="text-muted" style="word-wrap: break-word; white-space: normal; display: block; margin-top: 4px;">
                                                        <i class="fas fa-weight me-1"></i>{{ $document->formatted_file_size }}
                                                        @if($document->mime_type)
                                                            <span class="ms-2">
                                                                <i class="fas fa-info-circle me-1"></i>{{ $document->mime_type }}
                                                            </span>
                                                        @endif
                                                    </small>
                                                @endif
                                            </div>
                                            <a href="{{ route('dokumen.download', $document->id) }}"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-download me-1"></i>Download
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <input type="file"
                                       class="form-control @error('path') is-invalid @enderror"
                                       id="path"
                                       name="path"
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Leave empty if you don't want to change the file. Supported formats: PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, TXT (Max: 10MB)
                                </div>
                                @error('path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="description" class="form-label">
                                    <i class="fas fa-align-left"></i>
                                    Description
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description"
                                          name="description"
                                          rows="4"
                                          placeholder="Enter document description (optional)">{{ old('description', $document->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-actions">
                                <a href="{{ route('dokumen.index') }}" class="btn-modern btn-secondary-modern" style="color: #ff8080;">
                                    <i class="fas fa-times"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn-modern btn-primary-modern">
                                    <i class="fas fa-save"></i>
                                    Update Document
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

@endsection
