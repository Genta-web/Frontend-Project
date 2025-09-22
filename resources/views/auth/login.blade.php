@extends('layouts.app')

@section('title', 'Login')

@push('styles')
<style>
    /* Success Popup Styles */
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(14, 165, 233, 0.1);
        backdrop-filter: blur(5px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
        padding: 20px;
        box-sizing: border-box;
    }

    .popup-card {
        background: white;
        padding: 2.5rem;
        border-radius: 20px;
        box-shadow: 0 25px 50px rgba(14, 165, 233, 0.15);
        text-align: center;
        max-width: 400px;
        width: 100%;
        border: 1px solid var(--sky-blue-200);
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
        background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
    }

    .popup-icon svg {
        width: 40px;
        height: 40px;
        color: white;
    }

    .popup-title {
        font-size: 1.75rem;
        font-weight: 700;
        color: var(--sky-blue-800);
        margin: 0 0 0.5rem 0;
    }

    .popup-message {
        font-size: 1rem;
        color: var(--sky-blue-600);
        margin: 0 0 2rem 0;
        line-height: 1.6;
    }

    .popup-button {
        width: 100%;
        padding: 0.875rem 1rem;
        background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
        color: white;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .popup-button:hover {
        background: linear-gradient(135deg, var(--sky-blue-600) 0%, var(--sky-blue-700) 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
    }
</style>
@endpush

@section('content')

@if (session('success'))
<div class="popup-overlay" id="successPopup">
    <div class="popup-card">
        <div class="popup-icon">
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



<div class="login-card">
    <!-- Login Header -->
    <div class="login-header">
        <div class="login-title">
            <div class="login-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            Welcome Back
        </div>
        <p class="login-subtitle">Sign in to your account to continue</p>
    </div>

    <!-- Error Alert -->
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    <strong>Login Failed!</strong><br>
                    @foreach($errors->all() as $error)
                        {{ $error }}
                    @endforeach
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Login Form -->
    <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf

        <div class="mb-4">
            <label for="username" class="form-label">
                <i class="fas fa-user"></i>
                {{ __('Username') }}
            </label>
            <input id="username" type="text"
                   class="form-control @error('username') is-invalid @enderror"
                   name="username" value="{{ old('username') }}"
                   placeholder="Enter your username"
                   required autofocus>

            @error('username')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="password" class="form-label">
                <i class="fas fa-lock"></i>
                {{ __('Password') }}
            </label>
            <div class="input-group">
                <input id="password" type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       placeholder="Enter your password"
                       required>
                <button class="btn btn-outline-secondary" type="button" id="togglePassword" onclick="togglePasswordVisibility('password', 'togglePassword')">
                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                </button>
            </div>

            @error('password')
                <div class="text-danger small mt-1">
                    <i class="fas fa-exclamation-circle me-1"></i>
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-check mb-4">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                   {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
                <i class="fas fa-remember me-1"></i>
                {{ __('Remember Me') }}
            </label>
        </div>

        <div class="d-grid gap-2 mb-4">
            <button type="submit" class="btn btn-primary" id="loginBtn">
                <i class="fas fa-sign-in-alt me-2"></i>
                {{ __('Sign In') }}
            </button>
        </div>

    </form>

    <!-- Divider -->
    <div class="divider">
        <span>or</span>
    </div>

    <!-- Footer Links -->
    <div class="text-center">
        @if (Route::has('password.request'))
            <div class="mb-3">
                <a class="forgot-password-link" href="{{ route('password.request') }}">
                    <i class="fas fa-key"></i>
                    {{ __('Forgot Your Password?') }}
                </a>
            </div>
        @endif

        <p class="text-muted mb-0">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="register-link">{{ __('Register here') }}</a>
        </p>
    </div>
</div>
@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const popup = document.getElementById('successPopup');
    const closeButton = document.getElementById('closePopup');
    const loginForm = document.getElementById('loginForm');
    const loginBtn = document.getElementById('loginBtn');

    // Success popup handling
    if (popup) {
        const closePopup = () => {
            popup.style.display = 'none';
        };

        if (closeButton) {
            closeButton.addEventListener('click', closePopup);
        }

        popup.addEventListener('click', function(event) {
            if (event.target === this) {
                closePopup();
            }
        });
    }

    // Form submission with loading animation
    if (loginForm && loginBtn) {
        loginForm.addEventListener('submit', function(e) {
            // Add loading state
            loginBtn.classList.add('btn-loading');
            loginBtn.disabled = true;

            // Store original text
            const originalText = loginBtn.innerHTML;

            // Reset if form validation fails
            setTimeout(() => {
                if (loginBtn.classList.contains('btn-loading')) {
                    loginBtn.classList.remove('btn-loading');
                    loginBtn.disabled = false;
                    loginBtn.innerHTML = originalText;
                }
            }, 5000);
        });
    }

    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Auto-focus on username field
    const usernameField = document.getElementById('username');
    if (usernameField) {
        usernameField.focus();
    }
});


// Enhanced password visibility toggle function
function togglePasswordVisibility(passwordFieldId, toggleButtonId) {
    const passwordField = document.getElementById(passwordFieldId);
    const toggleButton = document.getElementById(toggleButtonId);
    const toggleIcon = toggleButton.querySelector('i');

    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.classList.remove('fa-eye');
        toggleIcon.classList.add('fa-eye-slash');
        toggleButton.setAttribute('title', 'Hide password');
        toggleButton.setAttribute('aria-label', 'Hide password');
    } else {
        passwordField.type = 'password';
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
        toggleButton.setAttribute('title', 'Show password');
        toggleButton.setAttribute('aria-label', 'Show password');
    }
}

// Initialize password toggle
document.addEventListener('DOMContentLoaded', function() {
    const toggleButton = document.getElementById('togglePassword');
    if (toggleButton) {
        toggleButton.setAttribute('title', 'Show password');
        toggleButton.setAttribute('aria-label', 'Show password');
    }
});
</script>

@if(session('login_success'))
    <script>
        // Tunggu sampai semua script ter-load
        window.addEventListener('load', function () {
            // Delay sedikit untuk memastikan SweetAlert2 sudah siap
            setTimeout(function() {
                const userName = @json(session('user_name'));
                const redirectUrl = @json(session('redirect_url'));

                if (typeof window.triggerLoginSuccess === 'function') {
                    // Tampilkan popup login success
                    window.triggerLoginSuccess('Selamat datang, ' + userName + '!');

                    // Redirect setelah popup selesai (2 detik)
                    setTimeout(function() {
                        window.location.href = redirectUrl;
                    }, 2100); // Sedikit lebih lama dari timer popup (2000ms)

                } else if (typeof window.showAlert === 'function') {
                    // Fallback ke showAlert
                    window.showAlert('Login Berhasil', 'Selamat datang, ' + userName + '!', 'success');

                    setTimeout(function() {
                        window.location.href = redirectUrl;
                    }, 2100);

                } else {
                    // Fallback ke alert biasa
                    alert('Selamat datang, ' + userName + '!');
                    window.location.href = redirectUrl;
                }
            }, 100);
        });
    </script>
@endif
@endpush
