@extends('layouts.admin')

@section('content')
<style>
    :root {
        --primary-blue: #0ea5e9;
        --light-blue: #e0f2fe;
        --dark-blue: #0284c7;
        --sky-blue: #38bdf8;
        --white: #ffffff;
        --light-gray: #f8fafc;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --border-light: #e2e8f0;
    }

    body {
        background-color: var(--light-gray);
    }

    .employee-header {
        background: linear-gradient(135deg, #03a9f4 0%, #0288d1 50%, #0277bd 100%);
        color: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(3, 169, 244, 0.4);
        position: relative;
        overflow: hidden;
    }

    .employee-header::before {
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

    .profile-section {
        display: flex;
        align-items: center;
        gap: 2rem;
        position: relative;
        z-index: 2;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        object-fit: cover;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }

    .profile-avatar:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
    }

    .profile-info h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .profile-info .position {
        font-size: 1.25rem;
        opacity: 0.9;
        margin-bottom: 0.5rem;
    }

    .profile-info .department {
        font-size: 1rem;
        opacity: 0.8;
    }

    .status-badges {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .status-badge {
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.3s ease;
    }

    .status-badge:hover {
        background: rgba(255, 255, 255, 0.3);
        transform: translateY(-2px);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
    }
    @media (min-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }
    }
    @media (min-width: 768px) and (max-width: 991px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    .stat-card {
        background: var(--white);
        border-radius: 16px;
        padding: 2rem 1.5rem;
        text-align: center;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        border: 1px solid var(--border-light);
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        min-height: 170px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        box-sizing: border-box;
        max-width: 100%;
        word-break: break-word;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary-blue), var(--sky-blue));
    }

    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(14, 165, 233, 0.15);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--primary-blue), var(--sky-blue));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        color: white;
        font-size: 1.5rem;
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin-bottom: 0.5rem;
        word-break: break-word;
        max-width: 100%;
        overflow-wrap: break-word;
    }

    .stat-label {
        color: var(--text-muted);
        font-size: 0.875rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .main-content {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .content-row {
        display: flex;
        gap: 2.5rem;
        align-items: stretch;
        width: 100%;
        min-width: 0;
    }
    .content-row > .info-card:first-child {
        flex: 2.2 1 0%;
        min-width: 0;
        max-width: 68%;
    }
    .content-row > .info-card:last-child {
        flex: 1 1 0%;
        min-width: 0;
        max-width: 32%;
    }
    .info-card {
        display: flex;
        flex-direction: column;
        height: 100%;
        box-shadow: 0 4px 24px rgba(14,165,233,0.10);
        border-radius: 18px;
        border: 1px solid var(--border-light);
        background: var(--white);
    }
    .card-header {
        background: linear-gradient(135deg, var(--light-blue), rgba(14, 165, 233, 0.08));
        padding: 1.5rem 2rem;
        border-bottom: 1px solid var(--border-light);
        border-radius: 18px 18px 0 0;
        box-shadow: 0 2px 8px rgba(14,165,233,0.04);
    }
    .card-body {
        padding: 2rem 2rem 2.5rem 2rem;
        flex: 1 1 auto;
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
    }

    .info-card {
        background: var(--white);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        border: 1px solid var(--border-light);
        overflow: hidden;
        min-width: 0;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .card-header {
        background: linear-gradient(135deg, var(--light-blue), rgba(14, 165, 233, 0.1));
        padding: 1.5rem;
        border-bottom: 1px solid var(--border-light);
    }

    .card-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .card-title i {
        color: var(--primary-blue);
    }

    .card-body {
        padding: 2rem;
    }

    .info-section {
        margin-bottom: 2rem;
    }

    .info-section:last-child {
        margin-bottom: 0;
    }

    .section-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 2px solid var(--light-blue);
    }

    .section-header i {
        color: var(--primary-blue);
        font-size: 1.125rem;
    }

    .section-header h3 {
        color: var(--text-dark);
        font-size: 1.125rem;
        font-weight: 600;
        margin: 0;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 2.5rem 2rem;
    }

    .info-item {
        background: var(--light-gray);
        padding: 1.5rem 2rem;
        border-radius: 14px;
        border-left: 5px solid var(--primary-blue);
        transition: all 0.3s ease;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: center;
        box-sizing: border-box;
    }

    .info-item:hover {
        background: var(--light-blue);
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(14, 165, 233, 0.15);
    }

    .info-label {
        font-size: 1rem;
        font-weight: 600;
        color: var(--text-muted);
        margin-bottom: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-label i {
        color: var(--primary-blue);
        width: 16px;
    }

    .info-value {
        font-size: 1.25rem;
        color: var(--text-dark);
        font-weight: 500;
        line-height: 1.5;
        word-break: break-word;
    }

    .quick-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .action-btn {
        background: var(--white);
        border: 2px solid var(--border-light);
        border-radius: 12px;
        padding: 1.25rem;
        text-decoration: none;
        color: var(--text-dark);
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .action-btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(14, 165, 233, 0.1), transparent);
        transition: left 0.5s;
    }

    .action-btn:hover::before {
        left: 100%;
    }

    .action-btn:hover {
        border-color: var(--primary-blue);
        background: var(--light-blue);
        color: var(--dark-blue);
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(14, 165, 233, 0.2);
    }

    .action-btn i {
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: var(--primary-blue);
        color: white;
        border-radius: 6px;
        font-size: 0.875rem;
    }

    .sidebar-section {
        margin-bottom: 2rem;
    }

    .sidebar-section:last-child {
        margin-bottom: 0;
    }

    .sidebar-header {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid var(--border-light);
    }

    .sidebar-header i {
        color: var(--primary-blue);
    }

    .sidebar-header h3 {
        color: var(--text-dark);
        font-size: 1rem;
        font-weight: 600;
        margin: 0;
    }

    .activity-section {
        background: var(--white);
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.08);
        border: 1px solid var(--border-light);
        overflow: hidden;
    }

    .activity-tabs {
        display: flex;
        background: var(--light-blue);
        border-bottom: 1px solid var(--border-light);
    }

    .activity-tab {
        flex: 1;
        padding: 1rem;
        text-align: center;
        background: none;
        border: none;
        font-weight: 600;
        color: var(--text-muted);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .activity-tab.active {
        background: var(--white);
        color: var(--primary-blue);
        border-bottom: 3px solid var(--primary-blue);
    }

    .activity-content {
        padding: 1.5rem;
        min-height: 300px;
    }

    .activity-item {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem;
        border-radius: 12px;
        margin-bottom: 1rem;
        background: var(--light-gray);
        transition: all 0.3s ease;
    }

    .activity-item:hover {
        background: var(--light-blue);
        transform: translateX(5px);
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--primary-blue), var(--sky-blue));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.875rem;
    }

    .activity-details h6 {
        margin: 0 0 0.25rem 0;
        font-weight: 600;
        color: var(--text-dark);
    }

    .activity-details p {
        margin: 0;
        font-size: 0.875rem;
        color: var(--text-muted);
    }

    .activity-status {
        margin-left: auto;
        padding: 0.25rem 0.75rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .status-success { background: #dcfce7; color: #166534; }
    .status-warning { background: #fef3c7; color: #92400e; }
    .status-info { background: #dbeafe; color: #1e40af; }
    .status-danger { background: #fee2e2; color: #991b1b; }

    .btn-primary-custom {
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
        text-decoration: none;
    }

    .btn-primary-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(3, 169, 244, 0.5);
        background: linear-gradient(135deg, #0288d1 0%, #03a9f4 50%, #29b6f6 100%);
        color: white;
    }

    .btn-outline-custom {
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
        text-decoration: none;
    }

    .btn-outline-custom:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(3, 169, 244, 0.5);
        background: linear-gradient(135deg, #0288d1 0%, #03a9f4 50%, #29b6f6 100%);
        color: white;
    }

    @media (max-width: 1200px) {
        .content-row {
            flex-direction: column;
            gap: 1.5rem;
        }
        .content-row > .info-card {
            max-width: 100%;
        }
    }
    @media (max-width: 1024px) {
        .content-row {
            flex-direction: column;
            gap: 1.5rem;
        }
        .content-row > .info-card {
            max-width: 100%;
        }
        .info-grid {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
        .info-item {
            padding: 1.25rem 1rem;
        }
    }

    @media (max-width: 768px) {
        .profile-section {
            flex-direction: column;
            text-align: center;
            gap: 1rem;
        }

        .profile-info h1 {
            font-size: 2rem;
        }

        .main-content {
            gap: 1.5rem;
        }

        .content-row {
            flex-direction: column;
            gap: 1.5rem;
        }
        .content-row > .info-card {
            max-width: 100%;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .stat-card {
            padding: 1.5rem;
        }

        .stat-number {
            font-size: 2rem;
        }

        .info-grid {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .info-item {
            padding: 1rem;
        }

        .card-body {
            padding: 1.5rem;
        }

        .activity-tabs {
            flex-direction: column;
        }

        .status-badges {
            justify-content: center;
            flex-wrap: wrap;
        }

        .action-btn {
            padding: 1rem;
        }
    }

    @media (max-width: 480px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .employee-header {
            padding: 1.5rem;
        }

        .profile-avatar {
            width: 80px;
            height: 80px;
        }

        .profile-info h1 {
            font-size: 1.75rem;
        }

        .card-body {
            padding: 1rem;
        }

        .info-item {
            padding: 0.75rem;
        }
    }
</style>

<div class="container-fluid py-4" style="max-width: 1400px; margin: 0 auto;">
    <div class="row" style="justify-content: center;">
        <!-- Main content -->
        <main class="col-12 px-0" style="padding:0;">
            <!-- Navigation -->

            <!-- Employee Header -->
            <div class="employee-header d-flex justify-content-between align-items-start" style="margin-bottom:2.5rem;">

                <div class="profile-section" style="gap:2.5rem;">
                    @if($employee->user)
                        <img src="{{ route('profile.photo', $employee->user->id) }}"
                            alt="{{ $employee->name }}"
                            class="profile-avatar"
                            data-user-id="{{ $employee->user->id }}">
                    @else
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($employee->name ?? 'Employee') }}&color=FFFFFF&background=0ea5e9&size=200"
                            alt="{{ $employee->name }}"
                            class="profile-avatar">
                    @endif

                    <div class="profile-info">
                        <h1>{{ $employee->name ?? 'N/A' }}</h1>
                        <div class="position">{{ $employee->position ?? 'N/A' }}</div>
                        <div class="department">
                            <i class="fas fa-building me-2"></i>{{ $employee->department ?? 'N/A' }}
                        </div>
                        <div class="department">
                            <i class="fas fa-id-badge me-2"></i>{{ $employee->employee_code ?? 'N/A' }}
                        </div>

                        <div class="status-badges">
                            <div class="status-badge">
                                <i class="fas {{ $employee->status === 'active' ? 'fa-check-circle' : 'fa-ban' }}"></i>
                                {{ ucfirst($employee->status ?? 'N/A') }}
                            </div>
                            @if($employee->user)
                                <div class="status-badge">
                                    <i class="fas fa-user-shield"></i>
                                    {{ ucfirst($employee->user->role) }}
                                </div>
                            @endif
                        </div>

                        <div>
                            @can('update', $employee)
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn-primary-custom" style="font-size:1rem; padding:0.75rem 2rem;">
                                <i class="fas fa-edit"></i> Edit Employee
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <a href="{{ route('employees.index') }}" class="btn-outline-custom" style="font-size:1rem; padding:0.75rem 2rem; flex-shrink: 0;">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>

            <!-- Statistics -->
            <div class="stats-grid d-flex justify-content-center" style="margin-bottom:2.5rem;">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-number">{{ $employee->attendance->count() }}</div>
                    <div class="stat-label">Total Attendance</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="stat-number">{{ $employee->workLogs->count() }}</div>
                    <div class="stat-label">Work Logs</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    <div class="stat-number">{{ $employee->leaves->count() }}</div>
                    <div class="stat-label">Leave Requests</div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="main-content" style="gap:2.5rem;">
                <div class="content-row" style="gap:2.5rem;  align-items:stretch;">
                    <!-- Employee Details -->
                    <div class="info-card" style="min-height: 100%;  box-shadow: 0 4px 24px rgba(14,165,233,0.08);">
                        <div class="card-header">
                            <h2 class="card-title">
                                <i class="fas fa-info-circle"></i>
                                Employee Information
                            </h2>
                        </div>
                        <div class="card-body">
                            <!-- Basic Information Section -->
                            <div class="info-section">
                                <div class="section-header">
                                    <i class="fas fa-user"></i>
                                    <h3>Basic Information</h3>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-id-card"></i>
                                            Employee Code
                                        </div>
                                        <div class="info-value">{{ $employee->employee_code ?? 'N/A' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-user"></i>
                                            Full Name
                                        </div>
                                        <div class="info-value">{{ $employee->name ?? 'N/A' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-building"></i>
                                            Department
                                        </div>
                                        <div class="info-value">{{ $employee->department ?? 'N/A' }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-briefcase"></i>
                                            Position
                                        </div>
                                        <div class="info-value">{{ $employee->position ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <div class="info-section">
                                <div class="section-header">
                                    <i class="fas fa-address-book"></i>
                                    <h3>Contact Information</h3>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-envelope"></i>
                                            Email Address
                                        </div>
                                        <div class="info-value">
                                            @if($employee->email)
                                                <a href="mailto:{{ $employee->email }}" style="color: var(--primary-blue); text-decoration: none;">
                                                    {{ $employee->email }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-phone"></i>
                                            Phone Number
                                        </div>
                                        <div class="info-value">
                                            @if($employee->phone)
                                                <a href="tel:{{ $employee->phone }}" style="color: var(--primary-blue); text-decoration: none;">
                                                    {{ $employee->phone }}
                                                </a>
                                            @else
                                                N/A
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Details Section -->
                            <div class="info-section">
                                <div class="section-header">
                                    <i class="fas fa-briefcase"></i>
                                    <h3>Employment Details</h3>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-calendar-plus"></i>
                                            Hire Date
                                        </div>
                                        <div class="info-value">
                                            {{ $employee->hire_date ? $employee->hire_date->format('d M Y') : 'N/A' }}
                                            @if($employee->hire_date)
                                                <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">
                                                    {{ $employee->hire_date->diffForHumans() }}
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-toggle-on"></i>
                                            Employment Status
                                        </div>
                                        <div class="info-value">
                                            <span class="status-{{ $employee->status === 'active' ? 'success' : 'warning' }}">
                                                {{ ucfirst($employee->status ?? 'N/A') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if($employee->user)
                            <!-- Account Information Section -->
                            <div class="info-section">
                                <div class="section-header">
                                    <i class="fas fa-user-cog"></i>
                                    <h3>Account Information</h3>
                                </div>
                                <div class="info-grid">
                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-user-circle"></i>
                                            Username
                                        </div>
                                        <div class="info-value">{{ $employee->user->username }}</div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-user-shield"></i>
                                            System Role
                                        </div>
                                        <div class="info-value">
                                            <span class="status-info">{{ ucfirst($employee->user->role) }}</span>
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-clock"></i>
                                            Last Login
                                        </div>
                                        <div class="info-value">
                                            @if($employee->user->last_login)
                                                {{ $employee->user->last_login->format('d M Y, H:i') }}
                                                <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">
                                                    {{ $employee->user->last_login->diffForHumans() }}
                                                </small>
                                            @else
                                                <span style="color: var(--text-muted);">Never logged in</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="info-item">
                                        <div class="info-label">
                                            <i class="fas fa-power-off"></i>
                                            Account Status
                                        </div>
                                        <div class="info-value">
                                            <span class="status-{{ $employee->user->is_active ? 'success' : 'danger' }}">
                                                {{ $employee->user->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                    </div>
                </div>

                <!-- Quick Actions Sidebar -->
                <div class="info-card" style="min-height: 100%; box-shadow: 0 4px 24px rgba(14,165,233,0.08);">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-bolt"></i>
                            Quick Actions
                        </h2>
                    </div>
                    <div class="card-body">
                        <!-- Navigation Actions -->
                        <div class="sidebar-section">
                            <div class="sidebar-header">
                                <i class="fas fa-bolt"></i>
                                <h3>Navigation</h3>
                            </div>
                            <div class="quick-actions">
                                @if($employee->user)
                                    <a href="{{ route('attendance.index', ['employee_id' => $employee->id]) }}" class="action-btn">
                                        <i class="fas fa-clock"></i>
                                        View Attendance Records
                                    </a>
                                    <a href="{{ route('leave.index', ['employee_id' => $employee->id]) }}" class="action-btn">
                                        <i class="fas fa-calendar-alt"></i>
                                        View Leave History
                                    </a>
                                    <a href="{{ route('worklogs.index', ['employee_id' => $employee->id]) }}" class="action-btn">
                                        <i class="fas fa-tasks"></i>
                                        View Work Logs
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Management Actions -->
                        @can('update', $employee)
                        <div class="sidebar-section">
                            <div class="sidebar-header">
                                <i class="fas fa-cog"></i>
                                <h3>Management</h3>
                            </div>
                            <div class="quick-actions">
                                <a href="{{ route('employees.edit', $employee->id) }}" class="action-btn">
                                    <i class="fas fa-edit"></i>
                                    Edit Employee Profile
                                </a>
                            </div>
                        </div>
                        @endcan

                        <!-- Quick Contact -->
                        @if($employee->email || $employee->phone)
                        <div class="sidebar-section">
                            <div class="sidebar-header">
                                <i class="fas fa-address-card"></i>
                                <h3>Quick Contact</h3>
                            </div>
                            <div class="quick-actions">
                                @if($employee->email)
                                    <a href="mailto:{{ $employee->email }}" class="action-btn">
                                        <i class="fas fa-envelope"></i>
                                        Send Email
                                    </a>
                                @endif
                                @if($employee->phone)
                                    <a href="tel:{{ $employee->phone }}" class="action-btn">
                                        <i class="fas fa-phone"></i>
                                        Call Phone
                                    </a>
                                @endif
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>


            <!-- Activity Section -->
            @if($employee->attendance->count() > 0 || $employee->workLogs->count() > 0 || $employee->leaves->count() > 0)
            <div class="activity-section">
                <div class="activity-tabs">
                    <button class="activity-tab active" onclick="showTab('attendance')">
                        <i class="fas fa-clock me-2"></i>Attendance
                    </button>
                    <button class="activity-tab" onclick="showTab('worklogs')">
                        <i class="fas fa-tasks me-2"></i>Work Logs
                    </button>
                    <button class="activity-tab" onclick="showTab('leaves')">
                        <i class="fas fa-calendar-alt me-2"></i>Leaves
                    </button>
                </div>

                <!-- Attendance Tab -->
                <div id="attendance-tab" class="activity-content">
                    @if($employee->attendance->count() > 0)
                        @foreach($employee->attendance->take(8) as $attendance)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div class="activity-details">
                                <h6>{{ $attendance->date ? $attendance->date->format('d M Y') : 'N/A' }}</h6>
                                <p>
                                    In: {{ $attendance->check_in ? \Carbon\Carbon::parse($attendance->check_in)->format('H:i') : '-' }} |
                                    Out: {{ $attendance->check_out ? \Carbon\Carbon::parse($attendance->check_out)->format('H:i') : '-' }}
                                </p>
                            </div>
                            <div class="activity-status status-{{ $attendance->status === 'present' ? 'success' : 'warning' }}">
                                {{ ucfirst($attendance->status) }}
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            <i class="fas fa-clock fa-3x mb-3"></i>
                            <p>No attendance records found</p>
                        </div>
                    @endif
                </div>

                <!-- Work Logs Tab -->
                <div id="worklogs-tab" class="activity-content" style="display: none;">
                    @if($employee->workLogs->count() > 0)
                        @foreach($employee->workLogs->take(8) as $workLog)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-tasks"></i>
                            </div>
                            <div class="activity-details">
                                <h6>{{ $workLog->work_date ? $workLog->work_date->format('d M Y') : 'N/A' }}</h6>
                                <p>{{ Str::limit($workLog->task_summary ?? 'No description', 60) }}</p>
                            </div>
                            <div class="activity-status status-info">
                                {{ $workLog->duration ?? 0 }}h
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            <i class="fas fa-tasks fa-3x mb-3"></i>
                            <p>No work logs found</p>
                        </div>
                    @endif
                </div>


                <!-- Leaves Tab -->
                <div id="leaves-tab" class="activity-content" style="display: none;">
                    @if($employee->leaves->count() > 0)
                        @foreach($employee->leaves->take(8) as $leave)
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <div class="activity-details">
                                <h6>{{ ucfirst($leave->leave_type) }} Leave</h6>
                                <p>
                                    {{ $leave->start_date ? $leave->start_date->format('d M') : 'N/A' }} -
                                    {{ $leave->end_date ? $leave->end_date->format('d M Y') : 'N/A' }}
                                    ({{ $leave->total_days ?? 0 }} days)
                                </p>
                            </div>
                            <div class="activity-status status-{{
                                $leave->status === 'approved' ? 'success' :
                                ($leave->status === 'rejected' ? 'danger' : 'warning')
                            }}">
                                {{ ucfirst($leave->status) }}
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                            <i class="fas fa-calendar-alt fa-3x mb-3"></i>
                            <p>No leave requests found</p>
                        </div>
                    @endif
                </div>
            </div>
            @else
            <div class="activity-section">
                <div class="activity-content" style="text-align: center; padding: 4rem;">
                    <i class="fas fa-chart-line fa-4x mb-3" style="color: var(--text-muted);"></i>
                    <h3 style="color: var(--text-muted); margin-bottom: 1rem;">No Activity Data Available</h3>
                    <p style="color: var(--text-muted);">This employee hasn't recorded any attendance, work logs, or leave requests yet.</p>
                </div>
            </div>
            @endif
        </main>
    </div>
</div>

<script>
    // Tab functionality
    function showTab(tabName) {
        // Hide all tab contents
        document.querySelectorAll('.activity-content').forEach(content => {
            content.style.display = 'none';
        });

        // Remove active class from all tabs
        document.querySelectorAll('.activity-tab').forEach(tab => {
            tab.classList.remove('active');
        });

        // Show selected tab content
        document.getElementById(tabName + '-tab').style.display = 'block';

        // Add active class to clicked tab
        event.target.classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Add loading states to action buttons
        document.querySelectorAll('.action-btn').forEach(button => {
            button.addEventListener('click', function() {
                if (this.href && !this.href.includes('mailto:') && !this.href.includes('tel:')) {
                    const originalContent = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>Loading...';
                    this.style.pointerEvents = 'none';

                    // Re-enable after a short delay (in case of back navigation)
                    setTimeout(() => {
                        this.innerHTML = originalContent;
                        this.style.pointerEvents = 'auto';
                    }, 3000);
                }
            });
        });

        // Animate stats cards on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        // Observe stat cards for animation
        document.querySelectorAll('.stat-card').forEach(card => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(card);
        });

        // Add stagger animation to stat cards
        document.querySelectorAll('.stat-card').forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>

@endsection
