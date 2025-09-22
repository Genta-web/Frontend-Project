@extends('layouts.admin')

@section('title', 'Attendance Details')

@push('styles')
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
        background: linear-gradient(135deg, var(--sky-blue-50) 0%, #ffffff 100%);
        font-family: 'Inter', sans-serif;
    }

    .attendance-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .page-header {
        background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
        color: white;
        padding: 2rem;
        border-radius: 20px 20px 0 0;
        margin-bottom: 0;
        box-shadow: 0 4px 20px rgba(14, 165, 233, 0.15);
        position: relative;
        z-index: 2;
    }

    .main-content {
        background: white;
        border-radius: 0 0 20px 20px;
        padding: 2.5rem;
        box-shadow: 0 10px 40px rgba(14, 165, 233, 0.1);
        border: 1px solid var(--sky-blue-100);
        border-top: none;
    }

    .info-card {
        background: linear-gradient(135deg, var(--sky-blue-50) 0%, #ffffff 100%);
        border: 2px solid var(--sky-blue-100);
        border-radius: 16px;
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        transition: all 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(14, 165, 233, 0.15);
        border-color: var(--sky-blue-300);
    }

    .info-header {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: var(--sky-blue-700);
        font-weight: 700;
        font-size: 1.1rem;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, var(--sky-blue-500) 0%, var(--sky-blue-600) 100%);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 1.1rem;
    }

    .btn-sky {
        background: rgba(255, 255, 255, 0.2);
        color: white;
        border: 2px solid rgba(255, 255, 255, 0.3);
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        margin-right: 1rem;
    }

    .btn-sky:hover {
        background: rgba(255, 255, 255, 0.3);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(255, 255, 255, 0.2);
    }

    .page-header::before {
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

    .page-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    .page-subtitle {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 0;
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
</style>
@endpush

@section('content')
<div class="attendance-container">
    <!-- Page Header -->
    <div class="page-header">
        <h1 class="page-title" style="color: #fff;">
            <i class="fas fa-user-clock"></i>
            Attendance Details
        </h1>
        <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
            <a href="{{ route('attendance.edit', $attendance) }}" class="btn comprehensive-btn">
                <i class="fas fa-edit me-1"></i>
                Edit Record
            </a>
            <a href="{{ route('attendance.index') }}" class="btn comprehensive-btn">
                <i class="fas fa-arrow-left me-1"></i>
                Back to List
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Employee Information -->
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-user"></i>
                </div>
                <span>Employee Information</span>
            </div>
            <div>
                <h3 style="color: var(--sky-blue-800); margin-bottom: 0.5rem;">
                    {{ $attendance->employee->name ?? 'N/A' }}
                </h3>
                <p style="color: var(--sky-blue-600); margin: 0;">
                    Employee Code: {{ $attendance->employee->employee_code ?? 'N/A' }}
                </p>
            </div>
        </div>

        <!-- Date and Status -->
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-calendar-alt"></i>
                </div>
                <span>Date & Status</span>
            </div>
            <div>
                <p style="font-size: 1.25rem; font-weight: 600; color: var(--sky-blue-700); margin-bottom: 0.5rem;">
                    {{ \Carbon\Carbon::parse($attendance->date)->format('l, d F Y') }}
                </p>
                <span style="padding: 0.5rem 1rem; border-radius: 25px; font-weight: 600;
                    background: {{ $attendance->status === 'present' ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)' }};
                    color: white;">
                    <i class="fas fa-{{ $attendance->status === 'present' ? 'check-circle' : 'times-circle' }}"></i>
                    {{ ucfirst($attendance->status) }}
                </span>
            </div>
        </div>

        <!-- Check In Details -->
        @if($attendance->check_in)
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-sign-in-alt"></i>
                </div>
                <span>Check In Details</span>
            </div>
            <div>
                <p style="font-size: 1.5rem; font-weight: 700; color: var(--sky-blue-700); margin-bottom: 0.5rem;">
                    {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i:s') }}
                </p>
                @if($attendance->check_in_location)
                    <p style="margin-bottom: 0.5rem;">
                        <i class="fas fa-map-marker-alt text-success me-2"></i>
                        {{ $attendance->check_in_location }}
                    </p>
                @endif
                @if($attendance->check_in_latitude && $attendance->check_in_longitude)
                    <p style="margin-bottom: 0.5rem;">
                        <i class="fas fa-crosshairs me-2"></i>
                        {{ number_format($attendance->check_in_latitude, 6) }}, {{ number_format($attendance->check_in_longitude, 6) }}
                    </p>
                    <a href="https://maps.google.com/?q={{ $attendance->check_in_latitude }},{{ $attendance->check_in_longitude }}"
                       target="_blank" style="color: var(--sky-blue-600); text-decoration: none;">
                        <i class="fas fa-external-link-alt me-2"></i>
                        View on Google Maps
                    </a>
                @endif
            </div>
        </div>
        @endif

        <!-- Check Out Details -->
        @if($attendance->check_out)
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-sign-out-alt"></i>
                </div>
                <span>Check Out Details</span>
            </div>
            <div>
                <p style="font-size: 1.5rem; font-weight: 700; color: var(--sky-blue-700); margin-bottom: 0.5rem;">
                    {{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i:s') }}
                </p>
                @if($attendance->check_out_location)
                    <p style="margin-bottom: 0.5rem;">
                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                        {{ $attendance->check_out_location }}
                    </p>
                @endif
                @if($attendance->check_out_latitude && $attendance->check_out_longitude)
                    <p style="margin-bottom: 0.5rem;">
                        <i class="fas fa-crosshairs me-2"></i>
                        {{ number_format($attendance->check_out_latitude, 6) }}, {{ number_format($attendance->check_out_longitude, 6) }}
                    </p>
                    <a href="https://maps.google.com/?q={{ $attendance->check_out_latitude }},{{ $attendance->check_out_longitude }}"
                       target="_blank" style="color: var(--sky-blue-600); text-decoration: none;">
                        <i class="fas fa-external-link-alt me-2"></i>
                        View on Google Maps
                    </a>
                @endif
            </div>
        </div>
        @endif

        <!-- Notes -->
        @if($attendance->notes)
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-sticky-note"></i>
                </div>
                <span>Notes</span>
            </div>
            <div style="background: var(--sky-blue-50); padding: 1rem; border-radius: 8px; border-left: 4px solid var(--sky-blue-400);">
                {{ $attendance->notes }}
            </div>
        </div>
        @endif

        <!-- Attachment -->
        @if($attendance->attachment_image)
        <div class="info-card">
            <div class="info-header">
                <div class="info-icon">
                    <i class="fas fa-paperclip"></i>
                </div>
                <span>Attachment</span>
            </div>
            <div style="text-align: center;">
                <img src="{{ asset('uploads/attendance/' . $attendance->attachment_image) }}"
                     alt="Attendance Image"
                     style="max-width: 100%; height: auto; border-radius: 12px; box-shadow: 0 4px 15px rgba(14, 165, 233, 0.15);">
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
