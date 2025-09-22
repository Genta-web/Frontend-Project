@extends('layouts.admin')

@section('title', 'Create Job')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-4 pb-3 mb-4 border-bottom">
        <div>
            <h1 class="h3">Create New Job</h1>
            <p class="text-muted">Create a new job assignment</p>
        </div>
        <div class="btn-toolbar">
            <div class="btn-group">
                <a href="{{ route('employee-jobs.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Jobs
                </a>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-plus me-2"></i>Job Information
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('employee-jobs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('hr'))
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">
                                <strong>Assign to Employee</strong> <span class="text-danger">*</span>
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
                        @else
                        <input type="hidden" name="employee_id" value="{{ Auth::user()->employee->id ?? '' }}">
                        <div class="mb-3">
                            <label class="form-label"><strong>Employee</strong></label>
                            <div class="form-control-plaintext">
                                <strong>{{ Auth::user()->employee->name ?? 'N/A' }}</strong>
                                <small class="text-muted">({{ Auth::user()->employee->employee_code ?? 'N/A' }})</small>
                            </div>
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="title" class="form-label">
                                <strong>Job Title</strong> <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" 
                                   value="{{ old('title') }}" 
                                   placeholder="Enter job title..."
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">
                                <strong>Description</strong> <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4" 
                                      placeholder="Describe the job requirements and objectives..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">
                                        <strong>Priority</strong> <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-control @error('priority') is-invalid @enderror" 
                                            id="priority" name="priority" required>
                                        <option value="">Select Priority</option>
                                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="attachment" class="form-label">
                                        <strong>Attachment</strong>
                                    </label>
                                    <input type="file" 
                                           class="form-control @error('attachment') is-invalid @enderror" 
                                           id="attachment" name="attachment" 
                                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    @error('attachment')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Optional. Max 5MB (PDF, DOC, DOCX, JPG, PNG)</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">
                                        <strong>Start Date</strong> <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('start_date') is-invalid @enderror" 
                                           id="start_date" name="start_date" 
                                           value="{{ old('start_date', date('Y-m-d')) }}" 
                                           min="{{ date('Y-m-d') }}"
                                           required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">
                                        <strong>Due Date</strong> <span class="text-danger">*</span>
                                    </label>
                                    <input type="date" 
                                           class="form-control @error('due_date') is-invalid @enderror" 
                                           id="due_date" name="due_date" 
                                           value="{{ old('due_date') }}"
                                           required>
                                    @error('due_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">Must be after start date</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">
                                <strong>Additional Notes</strong>
                            </label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                      id="notes" name="notes" rows="3" 
                                      placeholder="Any additional notes or instructions...">{{ old('notes') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>Priority Guide:</strong>
                            <ul class="mb-0 mt-2">
                                <li><strong>Urgent:</strong> Requires immediate attention</li>
                                <li><strong>High:</strong> Important task with tight deadline</li>
                                <li><strong>Medium:</strong> Standard priority task</li>
                                <li><strong>Low:</strong> Can be completed when time permits</li>
                            </ul>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('employee-jobs.index') }}" class="btn btn-secondary me-md-2">
                                <i class="fas fa-times me-1"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Create Job
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
    const startDateInput = document.getElementById('start_date');
    const dueDateInput = document.getElementById('due_date');
    
    // Validate due date is after start date
    function validateDates() {
        const startDate = startDateInput.value;
        const dueDate = dueDateInput.value;
        
        if (startDate && dueDate && dueDate <= startDate) {
            alert('Due date must be after start date');
            dueDateInput.value = '';
        }
    }
    
    startDateInput.addEventListener('change', function() {
        // Update minimum due date
        dueDateInput.min = this.value;
        validateDates();
    });
    
    dueDateInput.addEventListener('change', validateDates);
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
