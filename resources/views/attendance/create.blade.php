@extends('layouts.admin')

@section('title', 'Add Attendance Record')

@section('content')
<style>
    body { background: #f8fafc; }
    .attendance-header {
       background: linear-gradient(135deg, #87CEEB 0%, #32b8ecff 100%);
        color: #fff;
        border-radius: 18px;
        padding: 2rem 2.5rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(74,144,226,0.13);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }
    .attendance-header h1 {
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    .attendance-header p {
        font-size: 1.1rem;
        font-weight: 500;
        margin: 0.5rem 0 0 0;
        color: #e0f2fe;
    }
    .attendance-header .btn {
        border-radius: 14px;
        font-weight: 600;
        background: #fff;
        color: #4A90E2;
        box-shadow: 0 2px 8px rgba(74,144,226,0.10);
        padding: 0.7rem 1.5rem;
        font-size: 1rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .attendance-header .btn:hover {
        background: #e0f2fe;
        color: #3A7BC8;
        transform: translateY(-2px);
    }
    .attendance-form-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(74,144,226,0.08);
        border: 1px solid #e8edf2;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .attendance-form-header {
        background: linear-gradient(135deg, #e0f2fe, rgba(74,144,226,0.08));
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e8edf2;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    .attendance-form-header h6 {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
        color: #333A45;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .attendance-form-header i {
        color: #4A90E2;
        font-size: 1.3rem;
    }
    .attendance-form-body {
        padding: 2rem;
    }
    .form-label strong, .form-label i {
        color: #4A90E2;
    }
    .form-control, .form-select {
        border-radius: 12px;
        border: 2px solid #e8edf2;
        padding: 0.9rem 1.1rem;
        font-size: 1rem;
        transition: border-color 0.2s, box-shadow 0.2s;
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
<div class="attendance-header">
    <div>
        <h1><i class="fas fa-user-check"></i> Add Attendance Record</h1>
        <p>Create a new attendance record for an employee</p>
    </div>
    <a href="{{ route('attendance.index') }}" class="btn">
        <i class="fas fa-arrow-left me-1"></i> Back to Attendance
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="attendance-form-card">
            <div class="attendance-form-header">
                <h6><i class="fas fa-plus"></i> Attendance Information</h6>
            </div>
            <div class="attendance-form-body">
                    <form action="{{ route('attendance.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="employee_id" class="form-label">
                                        <strong>Employee</strong> <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control @error('employee_id') is-invalid @enderror"
                                            id="employee_id" name="employee_id" required>
                                        <option value="">Select Employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}"
                                                    {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }} ({{ $employee->employee_code }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employee_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="date" class="form-label">
                                        <strong>Date</strong> <span class="text-danger">*</span>
                                    </label>
                                    <input type="date"
                                           class="form-control @error('date') is-invalid @enderror"
                                           id="date" name="date"
                                           value="{{ old('date', date('Y-m-d')) }}"
                                           required>
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="check_in" class="form-label">
                                        <strong>Check In Time</strong>
                                    </label>
                                    <input type="time"
                                           class="form-control @error('check_in') is-invalid @enderror"
                                           id="check_in" name="check_in"
                                           value="{{ old('check_in') }}">
                                    @error('check_in')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Leave empty if not applicable</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="check_out" class="form-label">
                                        <strong>Check Out Time</strong>
                                    </label>
                                    <input type="time"
                                           class="form-control @error('check_out') is-invalid @enderror"
                                           id="check_out" name="check_out"
                                           value="{{ old('check_out') }}">
                                    @error('check_out')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Must be after check in time</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">
                                        <strong>Status</strong> <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control @error('status') is-invalid @enderror"
                                            id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="present" {{ old('status') == 'present' ? 'selected' : '' }}>Present</option>
                                        <option value="sick" {{ old('status') == 'sick' ? 'selected' : '' }}>Sick</option>
                                        <option value="leave" {{ old('status') == 'leave' ? 'selected' : '' }}>Leave</option>
                                        <option value="absent" {{ old('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="attachment_image" class="form-label">
                                        <strong>Attachment Image</strong>
                                    </label>
                                    <input type="file"
                                           class="form-control @error('attachment_image') is-invalid @enderror"
                                           id="attachment_image" name="attachment_image"
                                           accept="image/*">
                                    @error('attachment_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional. Max 2MB (JPEG, PNG, JPG)</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">
                                <strong>Notes</strong>
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror"
                                      id="notes" name="notes" rows="3"
                                      placeholder="Additional notes or comments...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('attendance.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Save Attendance
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
    // Auto-fill current time for check in when status is present
    const statusSelect = document.getElementById('status');
    const checkInInput = document.getElementById('check_in');

    statusSelect.addEventListener('change', function() {
        if (this.value === 'present' && !checkInInput.value) {
            const now = new Date();
            const timeString = now.toTimeString().slice(0, 5);
            checkInInput.value = timeString;
        }
    });

    // Validate check out time is after check in time
    const checkOutInput = document.getElementById('check_out');

    checkOutInput.addEventListener('change', function() {
        const checkInTime = checkInInput.value;
        const checkOutTime = this.value;

        if (checkInTime && checkOutTime && checkOutTime <= checkInTime) {
            alert('Check out time must be after check in time');
            this.value = '';
        }
    });
});
</script>

@if(session('success'))
    <script>
        window.addEventListener('load', function () {
            setTimeout(function() {
                if (typeof window.showAlert === 'function') {
                    window.showAlert('Berhasil', @json(session('success')), 'success');
                } else {
                    alert(@json(session('success')));
                }
            }, 100);
        });
    </script>
@endif

@if(session('error'))
    <script>
        window.addEventListener('load', function () {
            setTimeout(function() {
                if (typeof window.showAlert === 'function') {
                    window.showAlert('Error', @json(session('error')), 'error');
                } else {
                    alert(@json(session('error')));
                }
            }, 100);
        });
    </script>
@endif
@endpush
