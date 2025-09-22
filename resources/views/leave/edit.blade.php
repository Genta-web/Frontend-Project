@extends('layouts.admin')

@section('title', 'Edit Leave Request')

@push('styles')
<style>
    .edit-leave-container {
        padding: 2rem;
        background-color: #f8f9fa;
        min-height: calc(100vh - 120px);
    }

    .edit-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        border: none;
        overflow: hidden;
    }

    .edit-header {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        color: white;
        padding: 2rem;
        border-bottom: none;
    }

    .edit-title {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
    }

    .edit-subtitle {
        margin: 0.5rem 0 0 0;
        opacity: 0.9;
        font-size: 0.95rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid #e9ecef;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
        border: none;
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
    }

    .btn-secondary {
        border-radius: 8px;
        padding: 0.75rem 2rem;
        font-weight: 600;
    }

    .current-attachment {
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 8px;
        padding: 1rem;
        text-align: center;
        margin-bottom: 1rem;
    }

    .attachment-preview {
        max-width: 200px;
        max-height: 150px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .file-info {
        background: #e3f2fd;
        border: 1px solid #bbdefb;
        border-radius: 8px;
        padding: 0.75rem;
        margin-top: 0.5rem;
    }

    /* Image Cards Styling */
    .image-card {
        position: relative;
        transition: all 0.3s ease;
        border: 1px solid #e9ecef;
    }

    .image-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.15);
        border-color: #007bff;
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

    .alert {
        border-radius: 8px;
        border: none;
    }

    @media (max-width: 768px) {
        .edit-leave-container {
            padding: 1rem;
        }

        .edit-header {
            padding: 1.5rem;
        }

        .edit-title {
            font-size: 1.25rem;
        }
    }
</style>
@endpush

@section('content')
<div class="edit-leave-container">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card edit-card">
                    <div class="card-header edit-header">
                        <h1 class="edit-title">
                            <i class="fas fa-edit me-3"></i>
                            Edit Leave Request
                        </h1>
                        <p class="edit-subtitle">
                            Modify your leave request details. Only pending requests can be edited.
                        </p>
                    </div>

                    <div class="card-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('leave.update', $leave) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                @if(!Auth::user()->hasRole('employee'))
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="employee_id" class="form-label">
                                                <i class="fas fa-user me-2 text-primary"></i>
                                                Employee
                                            </label>
                                            <select name="employee_id" id="employee_id" class="form-select" required>
                                                <option value="">Select Employee</option>
                                                @foreach($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                            {{ old('employee_id', $leave->employee_id) == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }} ({{ $employee->employee_code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="employee_id" value="{{ $leave->employee_id }}">
                                @endif

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="leave_type" class="form-label">
                                            <i class="fas fa-tag me-2 text-primary"></i>
                                            Leave Type
                                        </label>
                                        <select name="leave_type" id="leave_type" class="form-select" required>
                                            <option value="">Select Leave Type</option>
                                            <option value="annual" {{ old('leave_type', $leave->leave_type) == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                                            <option value="sick" {{ old('leave_type', $leave->leave_type) == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                                            <option value="emergency" {{ old('leave_type', $leave->leave_type) == 'emergency' ? 'selected' : '' }}>Emergency Leave</option>
                                            <option value="maternity" {{ old('leave_type', $leave->leave_type) == 'maternity' ? 'selected' : '' }}>Maternity Leave</option>
                                            <option value="paternity" {{ old('leave_type', $leave->leave_type) == 'paternity' ? 'selected' : '' }}>Paternity Leave</option>
                                            <option value="personal" {{ old('leave_type', $leave->leave_type) == 'personal' ? 'selected' : '' }}>Personal Leave</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="start_date" class="form-label">
                                            <i class="fas fa-calendar-alt me-2 text-primary"></i>
                                            Start Date
                                        </label>
                                        <input type="date" name="start_date" id="start_date" class="form-control"
                                               value="{{ old('start_date', $leave->start_date->format('Y-m-d')) }}" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="end_date" class="form-label">
                                            <i class="fas fa-calendar-check me-2 text-primary"></i>
                                            End Date
                                        </label>
                                        <input type="date" name="end_date" id="end_date" class="form-control"
                                               value="{{ old('end_date', $leave->end_date->format('Y-m-d')) }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="reason" class="form-label">
                                    <i class="fas fa-comment-alt me-2 text-primary"></i>
                                    Reason for Leave
                                </label>
                                <textarea name="reason" id="reason" class="form-control" rows="4"
                                          placeholder="Please provide a detailed reason for your leave request..." required>{{ old('reason', $leave->reason) }}</textarea>
                            </div>

                            <!-- Current Attachment Display -->
                            @if($leave->attachment)
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-paperclip me-2 text-primary"></i>
                                        Current Attachment
                                    </label>
                                    <div class="current-attachment">
                                        @php
                                            $extension = pathinfo($leave->attachment, PATHINFO_EXTENSION);
                                            $isImage = in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                            $attachmentUrl = $leave->attachment_url;
                                        @endphp

                                        @if($isImage)
                                            <img src="{{ $attachmentUrl }}"
                                                 alt="Current attachment"
                                                 class="attachment-preview mb-2"
                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                            <div class="image-error" style="display: none;">
                                                <i class="fas fa-image fa-3x text-muted mb-2"></i>
                                                <br>
                                                <small class="text-muted">Image could not be loaded</small>
                                            </div>
                                        @else
                                            <i class="fas fa-file fa-3x text-muted mb-2"></i>
                                        @endif

                                        <div class="file-info">
                                            <i class="fas fa-info-circle me-1"></i>
                                            <strong>Current file:</strong> {{ basename($leave->attachment) }}
                                            <br>
                                            <a href="{{ $attachmentUrl }}" target="_blank" class="btn btn-sm btn-outline-primary mt-2">
                                                <i class="fas fa-external-link-alt me-1"></i>
                                                View Current File
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="attachment" class="form-label">
                                    <i class="fas fa-upload me-2 text-primary"></i>
                                    {{ $leave->attachment ? 'Replace Attachment (Optional)' : 'Attachment (Optional)' }}
                                </label>
                                <input type="file" name="attachment" id="attachment" class="form-control"
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.gif">
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Supported formats: PDF, DOC, DOCX, JPG, JPEG, PNG, GIF (Max: 5MB)
                                    @if($leave->attachment)
                                        <br><strong>Note:</strong> Uploading a new file will replace the current attachment.
                                    @endif
                                </small>
                            </div>

                            <!-- Current Images Display -->
                            @if($leave->hasImages())
                                <div class="form-group">
                                    <label class="form-label">
                                        <i class="fas fa-images me-2 text-primary"></i>
                                        Current Images ({{ count($leave->images) }})
                                    </label>
                                    <div class="row" id="currentImagesContainer">
                                        @foreach($leave->getImagesWithUrls() as $index => $image)
                                            @if(isset($image['url']) && isset($image['original_name']))
                                                <div class="col-md-4 col-sm-6 mb-3" data-image-index="{{ $index }}">
                                                    <div class="card image-card">
                                                        @if($index === 0)
                                                            <div class="primary-badge">
                                                                <i class="fas fa-star"></i> Primary
                                                            </div>
                                                        @endif

                                                        <div class="image-container">
                                                            <img src="{{ $image['url'] }}"
                                                                 alt="{{ $image['original_name'] ?? 'Image' }}"
                                                                 class="card-img-top"
                                                                 style="height: 150px; object-fit: cover;"
                                                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                                                            <div class="image-error text-center p-4" style="display: none;">
                                                                <i class="fas fa-image fa-2x text-muted mb-2"></i>
                                                                <br>
                                                                <small class="text-muted">Image could not be loaded</small>
                                                            </div>
                                                        </div>

                                                        <div class="card-body p-2">
                                                            <small class="text-muted d-block" title="{{ $image['original_name'] ?? 'Image' }}">
                                                                {{ Str::limit($image['original_name'] ?? 'Image', 20) }}
                                                            </small>
                                                            <small class="text-muted">{{ $image['formatted_size'] ?? '0 KB' }}</small>

                                                            <div class="mt-2">
                                                                <button type="button" class="btn btn-sm btn-danger remove-image-btn"
                                                                        data-image-index="{{ $index }}">
                                                                    <i class="fas fa-trash"></i> Remove
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <!-- Hidden inputs for images to remove -->
                                    <div id="removeImagesInputs"></div>
                                </div>
                            @endif

                            <!-- New Images Upload -->
                            <div class="form-group">
                                <label for="images" class="form-label">
                                    <i class="fas fa-images me-2 text-primary"></i>
                                    Add New Images (Optional)
                                </label>
                                <input type="file" name="images[]" id="images" class="form-control"
                                       accept=".jpg,.jpeg,.png,.gif,.webp" multiple>
                                <small class="form-text text-muted">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Upload up to 5 images (JPG, PNG, GIF, WebP - Max 5MB each)
                                </small>

                                <!-- Image preview container -->
                                <div id="imagePreviewContainer" class="mt-3" style="display: none;">
                                    <div class="row" id="imagePreviewRow"></div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between align-items-center mt-4">
                                <a href="{{ route('leave.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Back to Leave Requests
                                </a>

                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>
                                    Update Leave Request
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-calculate total days when dates change
        const startDate = document.getElementById('start_date');
        const endDate = document.getElementById('end_date');

        function updateDateValidation() {
            if (startDate.value && endDate.value) {
                const start = new Date(startDate.value);
                const end = new Date(endDate.value);

                if (end < start) {
                    endDate.setCustomValidity('End date must be after start date');
                } else {
                    endDate.setCustomValidity('');
                }
            }
        }

        startDate.addEventListener('change', updateDateValidation);
        endDate.addEventListener('change', updateDateValidation);

        // File upload preview
        const fileInput = document.getElementById('attachment');
        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    alert('File size must be less than 5MB');
                    this.value = '';
                    return;
                }

                console.log('File selected:', file.name, 'Size:', (file.size / 1024 / 1024).toFixed(2) + 'MB');
            }
        });

        // Handle image removal
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-image-btn') || e.target.closest('.remove-image-btn')) {
                const btn = e.target.classList.contains('remove-image-btn') ? e.target : e.target.closest('.remove-image-btn');
                const imageIndex = btn.getAttribute('data-image-index');
                const imageCard = btn.closest('[data-image-index]');

                if (confirm('Are you sure you want to remove this image?')) {
                    // Add hidden input for removal
                    const removeInputsContainer = document.getElementById('removeImagesInputs');
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'remove_images[]';
                    hiddenInput.value = imageIndex;
                    removeInputsContainer.appendChild(hiddenInput);

                    // Hide the image card
                    imageCard.style.display = 'none';
                }
            }
        });

        // Image preview functionality for new uploads
        const imageInput = document.getElementById('images');
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewRow = document.getElementById('imagePreviewRow');

        if (imageInput) {
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
                                <div class="card">
                                    <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                                    <div class="card-body p-2">
                                        <small class="text-muted">${file.name}</small>
                                        <br>
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
        }
    });
</script>
@endpush
