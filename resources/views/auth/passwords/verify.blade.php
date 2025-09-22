@extends('layouts.app')

@section('title', 'Verify Account')

<style>
    body {
        background: linear-gradient(135deg, #87CEEB 0%, #E0F6FF 50%, #FFFFFF 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .verify-account-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .verify-account-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 3rem;
        width: 100%;
        max-width: 500px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .verify-account-title {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
        font-weight: 600;
        font-size: 1.8rem;
    }

    .account-info-card {
        background: linear-gradient(135deg, #E3F2FD 0%, #FFFFFF 100%);
        border: 2px solid #87CEEB;
        border-radius: 15px;
        padding: 1.5rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .account-info-title {
        color: #2E86AB;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 1rem;
    }

    .account-detail {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.8rem;
        padding: 0.5rem 0;
        border-bottom: 1px solid rgba(135, 206, 235, 0.3);
    }

    .account-detail:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .account-label {
        font-weight: 500;
        color: #555;
    }

    .account-value {
        font-weight: 600;
        color: #2E86AB;
    }

    .form-control {
        border-radius: 10px;
        border: 2px solid #e1e5e9;
        padding: 12px 15px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #87CEEB;
        box-shadow: 0 0 0 0.2rem rgba(135, 206, 235, 0.25);
    }

    .btn-sky {
        background: linear-gradient(135deg, #87CEEB 0%, #5DADE2 100%);
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 16px;
    }

    .btn-sky:hover {
        background: linear-gradient(135deg, #5DADE2 0%, #3498DB 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(135, 206, 235, 0.4);
        color: white;
    }

    .btn-sky:focus {
        box-shadow: 0 0 0 0.2rem rgba(135, 206, 235, 0.5);
        color: white;
    }

    .btn-secondary {
        background: #6c757d;
        border: none;
        border-radius: 10px;
        padding: 12px 30px;
        font-weight: 600;
        color: white;
        transition: all 0.3s ease;
        width: 100%;
        font-size: 16px;
        margin-top: 10px;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-1px);
        color: white;
    }

    /* Password Toggle Button Styling */
    .btn-outline-secondary {
        border-left: none !important;
        background-color: #f8f9fa;
        border-color: #ced4da;
        color: #6c757d;
        transition: all 0.3s ease;
        border-radius: 0 10px 10px 0;
    }

    .btn-outline-secondary:hover {
        background-color: #e9ecef;
        color: #495057;
        border-color: #adb5bd;
    }

    .btn-outline-secondary:focus {
        box-shadow: 0 0 0 0.2rem rgba(108, 117, 125, 0.25);
        border-color: #87CEEB;
        background-color: #e7f3ff;
    }

    .input-group .form-control:focus + .btn-outline-secondary {
        border-color: #87CEEB;
    }

    .input-group .form-control {
        border-right: none;
        border-radius: 10px 0 0 10px;
    }

    .input-group .form-control:focus {
        border-right: none;
        box-shadow: none;
    }

    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 1.5rem;
    }

    .alert-danger {
        background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);
        color: #721c24;
        border-left: 4px solid #dc3545;
    }

    .back-to-login {
        text-align: center;
        margin-top: 1.5rem;
    }

    .back-to-login a {
        color: #87CEEB;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .back-to-login a:hover {
        color: #5DADE2;
        text-decoration: underline;
    }

    .icon-container {
        text-align: center;
        margin-bottom: 1.5rem;
    }

    .icon-container i {
        font-size: 3rem;
        color: #87CEEB;
        opacity: 0.8;
    }

    @media (max-width: 576px) {
        .verify-account-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }
        
        .verify-account-title {
            font-size: 1.5rem;
        }
    }
</style>

@section('content')
<div class="verify-account-container">
    <div class="verify-account-card">
        <div class="icon-container">
            <i class="fas fa-user-check"></i>
        </div>
        
        <h3 class="verify-account-title">{{ __('Account Verification') }}</h3>

        <div class="account-info-card">
            <div class="account-info-title">
                <i class="fas fa-info-circle me-2"></i>
                {{ __('Account Information') }}
            </div>
            
            <div class="account-detail">
                <span class="account-label">{{ __('Username:') }}</span>
                <span class="account-value">{{ $user->username }}</span>
            </div>
            
            <div class="account-detail">
                <span class="account-label">{{ __('Full Name:') }}</span>
                <span class="account-value">{{ $user->employee->name ?? 'N/A' }}</span>
            </div>
            
            <div class="account-detail">
                <span class="account-label">{{ __('Email:') }}</span>
                <span class="account-value">{{ $user->employee->email ?? 'N/A' }}</span>
            </div>
            
            <div class="account-detail">
                <span class="account-label">{{ __('Department:') }}</span>
                <span class="account-value">{{ $user->employee->department ?? 'N/A' }}</span>
            </div>
        </div>

        <p class="text-center mb-3" style="color: #666;">
            {{ __('Is this your account? If yes, you can proceed to reset your password.') }}
        </p>

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <strong>{{ __('Error!') }}</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.reset-direct') }}" id="resetPasswordForm">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="form-group mb-3">
                <label for="password" class="form-label">{{ __('New Password') }}</label>
                <div class="input-group">
                    <input id="password" type="password" 
                           class="form-control @error('password') is-invalid @enderror" 
                           name="password" 
                           required 
                           autocomplete="new-password"
                           placeholder="Enter your new password">
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')">
                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                    </button>
                </div>

                @error('password')
                    <span class="text-danger small mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation" class="form-label">{{ __('Confirm New Password') }}</label>
                <div class="input-group">
                    <input id="password_confirmation" type="password" 
                           class="form-control" 
                           name="password_confirmation" 
                           required 
                           autocomplete="new-password"
                           placeholder="Confirm your new password">
                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm" onclick="togglePasswordVisibility('password_confirmation', 'togglePasswordConfirm')">
                        <i class="fas fa-eye" id="togglePasswordConfirmIcon"></i>
                    </button>
                </div>
            </div>

            <div class="form-group mb-3">
                <button type="submit" class="btn btn-sky" id="submitBtn">
                    <i class="fas fa-key me-2"></i>
                    {{ __('Reset Password') }}
                </button>
            </div>

            <div class="form-group">
                <a href="{{ route('password.request') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>
                    {{ __('Try Different Username') }}
                </a>
            </div>
        </form>

        <div class="back-to-login">
            <a href="{{ route('login') }}">
                <i class="fas fa-arrow-left me-1"></i>
                {{ __('Back to Login') }}
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Password visibility toggle function
function togglePasswordVisibility(passwordFieldId, toggleButtonId) {
    const passwordField = document.getElementById(passwordFieldId);
    const toggleButton = document.getElementById(toggleButtonId);
    const toggleIcon = toggleButton.querySelector('i');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
        toggleButton.setAttribute('title', 'Hide password');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
        toggleButton.setAttribute('title', 'Show password');
    }
}

document.addEventListener('DOMContentLoaded', function() {
    // Initialize password toggle buttons
    const toggleButtons = ['togglePassword', 'togglePasswordConfirm'];
    toggleButtons.forEach(function(buttonId) {
        const button = document.getElementById(buttonId);
        if (button) {
            button.setAttribute('title', 'Show password');
        }
    });

    // Form validation and submission
    const form = document.getElementById('resetPasswordForm');
    const submitBtn = document.getElementById('submitBtn');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            
            // Validate password match
            if (password !== confirmPassword) {
                e.preventDefault();
                alert('Password and confirmation password do not match.');
                return false;
            }
            
            // Validate password strength
            if (password.length < 8) {
                e.preventDefault();
                alert('Password must be at least 8 characters long.');
                return false;
            }
            
            // Show loading state
            if (submitBtn) {
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Resetting Password...';
                submitBtn.disabled = true;
            }
        });
    }
    
    // Real-time password matching validation
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');
    
    function validatePasswordMatch() {
        if (confirmPasswordField.value && passwordField.value !== confirmPasswordField.value) {
            confirmPasswordField.setCustomValidity('Passwords do not match');
            confirmPasswordField.classList.add('is-invalid');
        } else {
            confirmPasswordField.setCustomValidity('');
            confirmPasswordField.classList.remove('is-invalid');
        }
    }
    
    if (passwordField && confirmPasswordField) {
        passwordField.addEventListener('input', validatePasswordMatch);
        confirmPasswordField.addEventListener('input', validatePasswordMatch);
    }
});
</script>
@endpush
