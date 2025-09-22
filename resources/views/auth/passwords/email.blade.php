@extends('layouts.app')

@section('title', 'Forgot Password')

<style>
    body {
        background: linear-gradient(135deg, #87CEEB 0%, #E0F6FF 50%, #FFFFFF 100%);
        min-height: 100vh;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .forgot-password-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .forgot-password-card {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 3rem;
        width: 100%;
        max-width: 500px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .forgot-password-title {
        text-align: center;
        margin-bottom: 2rem;
        color: #333;
        font-weight: 600;
        font-size: 1.8rem;
    }

    .forgot-password-subtitle {
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

    .alert {
        border-radius: 10px;
        border: none;
        padding: 15px 20px;
        margin-bottom: 1.5rem;
    }

    .alert-success {
        background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
        color: #155724;
        border-left: 4px solid #28a745;
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
        .forgot-password-card {
            padding: 2rem 1.5rem;
            margin: 1rem;
        }

        .forgot-password-title {
            font-size: 1.5rem;
        }
    }
</style>

@section('content')
<div class="forgot-password-container">
    <div class="forgot-password-card">
        <div class="icon-container">
            <i class="fas fa-key"></i>
        </div>

        <h3 class="forgot-password-title">{{ __('Reset Password') }}</h3>

        <p class="forgot-password-subtitle">
            {{ __('Enter your username to verify your account and reset your password.') }}
        </p>

        @if (session('status'))
            <div class="alert alert-success" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>{{ __('Email Sent!') }}</strong> {{ session('status') }}
            </div>
        @endif

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

        <form method="POST" action="{{ route('password.verify-user') }}" id="verifyUserForm">
            @csrf

            <div class="form-group mb-3">
                <label for="username" class="form-label">{{ __('Username') }}</label>
                <input id="username" type="text"
                       class="form-control @error('username') is-invalid @enderror"
                       name="username"
                       value="{{ old('username') }}"
                       required
                       autocomplete="username"
                       autofocus
                       placeholder="Enter your username">

                @error('username')
                    <span class="text-danger small mt-1">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group mb-3">
                <button type="submit" class="btn btn-sky" id="submitBtn">
                    <i class="fas fa-search me-2"></i>
                    {{ __('Verify Account') }}
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
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forgotPasswordForm');
    const submitBtn = document.getElementById('submitBtn');

    if (form) {
        form.addEventListener('submit', function(e) {
            // Show loading state
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitBtn.disabled = true;

            // Re-enable button after 10 seconds in case of network issues
            setTimeout(function() {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane me-2"></i>Send Reset Link';
                    submitBtn.disabled = false;
                }
            }, 10000);
        });
    }

    // Auto-hide success message after 10 seconds
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(function() {
            successAlert.style.transition = 'opacity 0.5s ease';
            successAlert.style.opacity = '0';
            setTimeout(function() {
                successAlert.remove();
            }, 500);
        }, 10000);
    }
});
</script>
@endpush
