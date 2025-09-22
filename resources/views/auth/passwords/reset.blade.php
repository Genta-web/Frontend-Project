@extends('layouts.app')

@section('title', 'Reset Password')

<style>
    body {
        background: linear-gradient(135deg, #87CEEB 0%, #E0F6FF 50%, #FFFFFF 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .reset-password-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .reset-password-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 3rem;
        width: 100%;
        max-width: 500px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .reset-password-title {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #333;
        font-weight: 600;
        font-size: 1.8rem;
    }

    .reset-password-subtitle {
        text-align: center;
        margin-bottom: 2rem;
        color: #666;
        font-size: 1rem;
        line-height: 1.5;
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
        border-color: #80bdff;
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
        .reset-password-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }

        .reset-password-title {
            font-size: 1.5rem;
        }
    }
</style>

@section('content')
<div class="reset-password-container">
    <div class="reset-password-card">
        <div class="icon-container">
            <i class="fas fa-lock"></i>
        </div>

        <h3 class="reset-password-title">{{ __('Reset Password') }}</h3>

        <p class="reset-password-subtitle">
            {{ __('Enter your new password below to complete the reset process.') }}
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

        <form method="POST" action="{{ route('password.update') }}" id="resetPasswordForm">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group mb-3">
                <label for="email" class="form-label">{{ __('Email Address') }}</label>
                <input id="email" type="email"
                       class="form-control @error('email') is-invalid @enderror"
                       name="email"
                       value="{{ $email ?? old('email') }}"
                       required
                       autocomplete="email"
                       autofocus
                       readonly>

                @error('email')
                    <span class="text-danger small mt-1">{{ $message }}</span>
                @enderror
            </div>

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
                <label for="password-confirm" class="form-label">{{ __('Confirm New Password') }}</label>
                <div class="input-group">
                    <input id="password-confirm" type="password"
                           class="form-control"
                           name="password_confirmation"
                           required
                           autocomplete="new-password"
                           placeholder="Confirm your new password">
                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm" onclick="togglePasswordVisibility('password-confirm', 'togglePasswordConfirm')">
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

// Initialize tooltips and form validation
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
            const confirmPassword = document.getElementById('password-confirm').value;

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
    const confirmPasswordField = document.getElementById('password-confirm');

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
