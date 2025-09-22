@extends('layouts.admin')

@section('title', 'Edit Attendance')

@push('styles')
<style>
    .edit-attendance-page {
        background: linear-gradient(135deg, #e0eafc 0%, #56ccf2 100%);
        min-height: calc(100vh - 120px);
        border-radius: 18px;
        margin: 1rem;
        padding: 2rem;
        box-shadow: 0 8px 32px rgba(44, 62, 80, 0.10);
    }

    .form-card {
        background: #fff;
        border-radius: 18px;
        border: 2px solid #56ccf2;
        box-shadow: 0 8px 32px rgba(44, 62, 80, 0.10);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #56ccf2 0%, #2f80ed 100%);
        color: #fff;
        padding: 2rem;
        text-align: center;
        border-bottom: 2px solid #e0eafc;
    }

    .form-header h2 {
        font-weight: 700;
        letter-spacing: 1px;
    }

    .form-body {
        padding: 2rem;
        background: #fafdff;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        font-weight: 600;
        color: #2f80ed;
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e0eafc;
        padding: 0.75rem 1rem;
        transition: all 0.3s;
        background: #fff;
        color: #2d3436;
    }

    .form-control:focus {
        border-color: #56ccf2;
        box-shadow: 0 0 0 0.15rem rgba(86,204,242,0.15);
    }

    .btn-modern {
        border-radius: 25px;
        padding: 0.75rem 2rem;
        font-weight: 600;
        transition: all 0.3s;
        border: none;
        font-size: 1rem;
    }

    .btn-primary.btn-modern {
        background: linear-gradient(135deg, #56ccf2 0%, #2f80ed 100%);
        color: #fff;
        border: none;
    }

    .btn-primary.btn-modern:hover {
        background: #2f80ed;
        color: #fff;
        box-shadow: 0 5px 15px rgba(44, 62, 80, 0.15);
    }

    .btn-secondary.btn-modern {
        background: #fff;
        color: #2f80ed;
        border: 2px solid #56ccf2;
    }

    .btn-secondary.btn-modern:hover {
        background: #e0eafc;
        color: #2f80ed;
    }

    .current-image, #image-preview {
        max-width: 200px;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(86,204,242,0.15);
        border: 2px solid #e0eafc;
    }

    .time-input-group {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .breadcrumb-modern {
        background: transparent;
        padding: 0;
        margin-bottom: 1.5rem;
    }

    .breadcrumb-modern .breadcrumb-item a {
        color: #2f80ed;
        text-decoration: none;
        font-weight: 500;
    }

    .breadcrumb-modern .breadcrumb-item.active {
        color: #56ccf2;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .edit-attendance-page {
            margin: 0;
            padding: 1rem;
            border-radius: 10px;
        }
        .form-card {
            border-radius: 10px;
        }
        .form-header {
            padding: 1.2rem;
            border-radius: 10px 10px 0 0;
        }
        .form-body {
            padding: 1rem;
        }
        .time-input-group {
            flex-direction: column;
            gap: 0.5rem;
        }
    }
</style>
@endpush

@section('content')
<div class="edit-attendance-page">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb breadcrumb-modern">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Attendance</a></li>
            <li class="breadcrumb-item"><a href="{{ route('attendance.show', $attendance) }}">Details</a></li>
            <li class="breadcrumb-item active">Edit</li>
        </ol>
    </nav>

    <!-- Form Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="form-card">
                <div class="form-header">
                    <div class="mb-3">
                        <i class="fas fa-edit fa-3x mb-3"></i>
                    </div>
                    <h2 class="mb-2">Edit Attendance Record</h2>
                    <p class="mb-0 opacity-75">Update attendance information for {{ $attendance->employee->name }}</p>
                </div>

                <div class="form-body">
                    <form action="{{ route('attendance.update', $attendance) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Employee Selection -->
                        <div class="form-group">
                            <label for="employee_id" class="form-label">
                                <i class="fas fa-user me-2 text-primary"></i>
                                Employee <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="employee_name" name="employee_name" value="{{ $attendance->employee->name }} ({{ $attendance->employee->employee_code }})" readonly>
                            <input type="hidden" name="employee_id" value="{{ $attendance->employee_id }}">
                            @error('employee_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Date -->
                        <div class="form-group">
                            <label for="date" class="form-label">
                                <i class="fas fa-calendar me-2 text-primary"></i>
                                Date <span class="text-danger">*</span>
                            </label>
                            <input type="date" class="form-control @error('date') is-invalid @enderror"
                                   id="date" name="date" value="{{ old('date', $attendance->date) }}" required>
                            @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Check In/Out Times -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check_in" class="form-label">
                                        <i class="fas fa-sign-in-alt me-2 text-success"></i>
                                        Check In Time
                                    </label>
                                    <input type="time" class="form-control @error('check_in') is-invalid @enderror"
                                           id="check_in" name="check_in"
                                           value="{{ old('check_in', $attendance->check_in_time ? \Carbon\Carbon::parse($attendance->check_in_time)->format('H:i') : '') }}">
                                    @error('check_in')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check_out" class="form-label">
                                        <i class="fas fa-sign-out-alt me-2 text-danger"></i>
                                        Check Out Time
                                    </label>
                                    <input type="time" class="form-control @error('check_out') is-invalid @enderror"
                                           id="check_out" name="check_out"
                                           value="{{ old('check_out', $attendance->check_out_time ? \Carbon\Carbon::parse($attendance->check_out_time)->format('H:i') : '') }}">
                                    @error('check_out')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Status -->
                        <div class="form-group">
                            <label for="status" class="form-label">
                                <i class="fas fa-info-circle me-2 text-warning"></i>
                                Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="present" {{ old('status', $attendance->status) == 'present' ? 'selected' : '' }}>Present</option>
                                <option value="sick" {{ old('status', $attendance->status) == 'sick' ? 'selected' : '' }}>Sick</option>
                                <option value="leave" {{ old('status', $attendance->status) == 'leave' ? 'selected' : '' }}>Leave</option>
                                <option value="absent" {{ old('status', $attendance->status) == 'absent' ? 'selected' : '' }}>Absent</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Notes -->
                        <div class="form-group">
                            <label for="notes" class="form-label">
                                <i class="fas fa-sticky-note me-2 text-secondary"></i>
                                Notes
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes" name="notes" rows="3"
                                      placeholder="Add any additional notes...">{{ old('notes', $attendance->notes) }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Current Image -->
                        @if($attendance->attachment_image)
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-image me-2 text-info"></i>
                                    Current Attachment
                                </label>
                                <div class="mb-3">
                                    <img src="{{ asset('uploads/attendance/' . $attendance->attachment_image) }}"
                                         alt="Current attachment" class="current-image">
                                </div>
                            </div>
                        @endif

                        <!-- New Image Upload -->
                        <div class="form-group">
                            <label for="attachment_image" class="form-label">
                                <i class="fas fa-camera me-2 text-info"></i>
                                {{ $attendance->attachment_image ? 'Replace' : 'Upload' }} Attachment Image
                            </label>
                            <input type="file" class="form-control @error('attachment_image') is-invalid @enderror"
                                   id="attachment_image" name="attachment_image" accept="image/*">
                            <small class="form-text text-muted">
                                Supported formats: JPEG, PNG, JPG. Max size: 2MB
                            </small>
                            @error('attachment_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ route('attendance.show', $attendance) }}" class="btn btn-secondary btn-modern">
                                <i class="fas fa-arrow-left me-2"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary btn-modern">
                                <i class="fas fa-save me-2"></i>Update Attendance
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });

    // Image preview
    const imageInput = document.getElementById('attachment_image');
    if (imageInput) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Create preview if doesn't exist
                    let preview = document.getElementById('image-preview');
                    if (!preview) {
                        preview = document.createElement('img');
                        preview.id = 'image-preview';
                        preview.className = 'current-image mt-2';
                        preview.style.display = 'block';
                        imageInput.parentNode.appendChild(preview);
                    }
                    preview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush
