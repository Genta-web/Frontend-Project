@extends('layouts.admin')

@section('content')
<style>
    body { background: #f8fafc; }
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
    margin-bottom: 0; /* Dihapus margin-bottom karena tidak ada subtitle */
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.header-action-btn { /* Menggunakan nama kelas yang lebih generik */
    background: rgba(255, 255, 255, 0.15);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50px;
    padding: 0.75rem 2rem;
    font-weight: 600;
    transition: all 0.3s ease;
    color: white;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.header-action-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(3, 169, 244, 0.5);
    background: rgba(255, 255, 255, 0.25);
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

    .employee-form-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 20px rgba(74,144,226,0.08);
        border: 1px solid #e8edf2;
        overflow: hidden;
        margin-bottom: 2rem;
    }
    .employee-form-header {
        background: linear-gradient(135deg, #e0f2fe, rgba(74,144,226,0.08));
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e8edf2;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    .employee-form-header h5 {
        font-size: 1.2rem;
        font-weight: 700;
        margin: 0;
        color: #333A45;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .employee-form-header i {
        color: #4A90E2;
        font-size: 1.3rem;
    }
    .employee-form-body {
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



<div class="dashboard-header">
    <div class="row align-items-center w-100">
        <div class="col-md-8">
            <h1 class="dashboard-title">
                <i class="fas fa-user-plus me-3"></i>Add New Employee
            </h1>
        </div>

        <div class="col-md-4 text-md-end">
            <a href="{{ route('employees.index') }}" class="btn comprehensive-btn">
                <i class="fas fa-arrow-left me-2"></i>Back to List
            </a>
        </div>
    </div>
</div>

<div class="row justify-content-center">
    <div class="px-4">
        <div class="employee-form-card">
            <div class="employee-form-header">
                <h5><i class="fas fa-id-card"></i> Employee Information</h5>
            </div>
            <div class="employee-form-body">
                        @if(session('error'))
                        <button type="button" class="btn btn-warning" onclick="testConfirm()">
                            {{session('success')}}
                        </button>
                        @endif

                        <div class="card-body">
                            <form method="POST" action="{{ route('employees.store') }}">
                                @csrf

                                <!-- Employee Details -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="employee_code" class="form-label">Employee Code <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control @error('employee_code') is-invalid @enderror"
                                                   id="employee_code" name="employee_code" value="{{ old('employee_code') }}" required>
                                            <button type="button" class="btn btn-outline-secondary" onclick="generateEmployeeCode()">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </div>
                                        @error('employee_code')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Click the refresh button to auto-generate</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                               id="email" name="email" value="{{ old('email') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                               id="phone" name="phone" value="{{ old('phone') }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="department" class="form-label">Department <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('department') is-invalid @enderror"
                                               id="department" name="department" value="{{ old('department') }}" required>
                                        @error('department')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="position" class="form-label">Position <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('position') is-invalid @enderror"
                                               id="position" name="position" value="{{ old('position') }}" required>
                                        @error('position')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="hire_date" class="form-label">Hire Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('hire_date') is-invalid @enderror"
                                           id="hire_date" name="hire_date" value="{{ old('hire_date') }}" required>
                                    @error('hire_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- User Account Section -->
                                <hr class="my-4">
                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="create_user_account"
                                               name="create_user_account" value="1" {{ old('create_user_account') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="create_user_account">
                                            Create user account for this employee
                                        </label>
                                    </div>
                                </div>

                                <div id="user_account_fields" style="display: none;">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                                   id="username" name="username" value="{{ old('username') }}">
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6">
                                            <label for="role" class="form-label">Role <span class="text-danger">*</span></label>
                                            <select class="form-select @error('role') is-invalid @enderror" id="role" name="role">
                                                <option value="">Select Role</option>
                                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                <option value="hr" {{ old('role') == 'hr' ? 'selected' : '' }}>HR</option>
                                                <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                                                <option value="employee" {{ old('role') == 'employee' ? 'selected' : '' }}>Employee</option>
                                            </select>
                                            @error('role')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                               id="password" name="password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div class="form-text">Minimum 8 characters required.</div>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('employees.index') }}" class="btn btn-secondary me-md-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Create Employee
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const createUserCheckbox = document.getElementById('create_user_account');
    const userAccountFields = document.getElementById('user_account_fields');

    createUserCheckbox.addEventListener('change', function() {
        if (this.checked) {
            userAccountFields.style.display = 'block';
        } else {
            userAccountFields.style.display = 'none';
        }
    });

    // Show fields if checkbox was checked on page load (validation errors)
    if (createUserCheckbox.checked) {
        userAccountFields.style.display = 'block';
    }

    // Auto-generate employee code on page load
    generateEmployeeCode();
});

function generateEmployeeCode() {
    fetch('{{ route("employees.next-code") }}')
        .then(response => response.json())
        .then(data => {
            document.getElementById('employee_code').value = data.code;
        })
        .catch(error => {
            console.error('Error generating employee code:', error);
        });
}
</script>

<style>
.sidebar {
    min-height: 100vh;
}
</style>
@endsection
