<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Employee Management') }} - @yield('title', 'Login')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Custom Styles -->
    <style>
        :root {
            --sky-blue-50: #f0f9ff;
            --sky-blue-100: #e0f2fe;
            --sky-blue-200: #bae6fd;
            --sky-blue-300: #7dd3fc;
            --sky-blue-400: #38bdf8;
            --sky-blue-500: #0ea5e9;
            --sky-blue-600: #0284c7;
            --sky-blue-700: #0369a1;
            --sky-blue-800: #075985;
            --sky-blue-900: #0c4a6e;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
            min-height: 100vh;
            margin: 0;
            padding: 0;
            position: relative;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background:
                radial-gradient(circle at 20% 80%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(255, 255, 255, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.05) 0%, transparent 50%);
            pointer-events: none;
        }

        .app-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            z-index: 1;
        }

        .login-wrapper {
            width: 100%;
            max-width: 480px;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 3rem;
            box-shadow:
                0 25px 50px rgba(14, 165, 233, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--sky-blue-400) 0%, var(--sky-blue-600) 100%);
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-title {
            font-size: 2.25rem;
            font-weight: 800;
            background: linear-gradient(135deg, var(--sky-blue-600) 0%, var(--sky-blue-800) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .login-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
        }

        .login-subtitle {
            color: var(--sky-blue-700);
            font-size: 1.1rem;
            font-weight: 500;
        }

        .form-label {
            font-weight: 600;
            color: var(--sky-blue-800);
            margin-bottom: 0.75rem;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            border-radius: 14px;
            border: 2px solid var(--sky-blue-200);
            padding: 1rem 1.25rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(240, 249, 255, 0.5);
        }

        .form-control:focus {
            border-color: var(--sky-blue-500);
            box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.15);
            background: white;
        }

        .form-control::placeholder {
            color: var(--sky-blue-400);
            opacity: 0.8;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
            border: none;
            border-radius: 14px;
            padding: 1rem 1.5rem;
            font-weight: 700;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(14, 165, 233, 0.4);
            background: linear-gradient(135deg, var(--sky-blue-600) 0%, var(--sky-blue-700) 100%);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 14px;
            border: none;
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2 0%, #fee2e2 100%);
            color: #dc2626;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            color: #16a34a;
            border: 1px solid #bbf7d0;
        }

        .input-group .btn {
            border-radius: 0 14px 14px 0;
            border: 2px solid var(--sky-blue-200);
            border-left: none;
            background: var(--sky-blue-50);
            color: var(--sky-blue-600);
            transition: all 0.3s ease;
        }

        .input-group .btn:hover {
            background: var(--sky-blue-100);
            color: var(--sky-blue-700);
        }

        .input-group .form-control {
            border-radius: 14px 0 0 14px;
            border-right: none;
        }

        .input-group .form-control:focus + .btn {
            border-color: var(--sky-blue-500);
        }

        .form-check-input:checked {
            background-color: var(--sky-blue-500);
            border-color: var(--sky-blue-500);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.25rem rgba(14, 165, 233, 0.15);
        }

        .form-check-label {
            color: var(--sky-blue-700);
            font-weight: 500;
        }

        .forgot-password-link {
            color: var(--sky-blue-600);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .forgot-password-link:hover {
            color: var(--sky-blue-700);
            background: var(--sky-blue-50);
            transform: translateY(-1px);
        }

        .register-link {
            color: var(--sky-blue-600);
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .register-link:hover {
            color: var(--sky-blue-700);
            text-decoration: underline;
        }

        .divider {
            text-align: center;
            margin: 1.5rem 0;
            position: relative;
        }

        .divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: var(--sky-blue-200);
        }

        .divider span {
            background: white;
            padding: 0 1rem;
            color: var(--sky-blue-500);
            font-weight: 500;
        }

        /* Loading Animation */
        .btn-loading {
            position: relative;
            color: transparent !important;
        }

        .btn-loading::after {
            content: '';
            position: absolute;
            width: 20px;
            height: 20px;
            top: 50%;
            left: 50%;
            margin-left: -10px;
            margin-top: -10px;
            border: 2px solid transparent;
            border-top-color: white;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .login-icon {
            animation: float 3s ease-in-out infinite;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .login-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
                border-radius: 20px;
            }

            .login-title {
                font-size: 1.75rem;
                flex-direction: column;
                gap: 0.75rem;
            }

            .login-icon {
                width: 50px;
                height: 50px;
                font-size: 1.25rem;
            }

            .form-control {
                padding: 0.875rem 1rem;
            }

            .btn-primary {
                padding: 0.875rem 1.25rem;
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .app-container {
                padding: 10px;
            }

            .login-card {
                padding: 1.5rem 1rem;
            }

            .login-title {
                font-size: 1.5rem;
            }
        }
    </style>

    @stack('styles')
</head>

<body>
    <div class="app-container">
        <div class="login-wrapper">
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @stack('scripts')
</body>
</html>
