@extends('layouts.admin')

@section('content')
<style>

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
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }

    body {
        background-color: #f0faff;
    }
    .sidebar {
        background-color: #ffffff;
        border-right: 1px solid #e0e0e0;
        min-height: 100vh;
        padding-top: 1rem;
    }
    .nav-link {
        color: #333;
        transition: all 0.2s ease;
    }
    .nav-link.active, .nav-link:hover {
        background-color: #e0f5ff;
        color: #0d6efd;
        border-radius: 0.375rem;
    }
    .card {
        border: none;
        border-radius: 1rem;
    }
    .card .card-body {
        padding: 1.5rem;
    }
    .card-header {
        background-color: #e6f4ff;
        border-bottom: 1px solid #d0ebff;
        border-radius: 1rem 1rem 0 0;
        font-weight: 600;
        color: #0d6efd;
    }
    .border-left-primary {
        border-left: 4px solid #87CEEB;
    }
    .border-left-success {
        border-left: 4px solid #1cc88a;
    }
    .border-left-info {
        border-left: 4px solid #36b9cc;
    }
    .border-left-warning {
        border-left: 4px solid #f6c23e;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <!--

        <!- Main content -->
        <main class=" ms-sm-auto px-md-4">
            <div class="dashboard-header">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <h1 class="dashboard-title">
                            Admin Dashboard
                        </h1>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow border-left-primary">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase">Total Employees</h6>
                                    <h4>{{ $stats['total_employees'] }}</h4>
                                </div>
                                <i class="fas fa-users fa-2x text-sky-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow border-left-success">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase">Active Employees</h6>
                                    <h4>{{ $stats['active_employees'] }}</h4>
                                </div>
                                <i class="fas fa-user-check fa-2x text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow border-left-info">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase">Present Today</h6>
                                    <h4>{{ $stats['present_today'] }}</h4>
                                </div>
                                <i class="fas fa-clock fa-2x text-info"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card shadow border-left-warning">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="text-muted text-uppercase">Inactive Employees</h6>
                                    <h4>{{ $stats['inactive_employees'] }}</h4>
                                </div>
                                <i class="fas fa-user-times fa-2x text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            Recent Employees
                        </div>
                        <div class="card-body">
                            @if($recent_employees->count() > 0)
                                @foreach($recent_employees as $employee)
                                    <div class="d-flex align-items-center mb-3">
                                        <i class="fas fa-user-circle fa-2x text-sky-300 me-3"></i>
                                        <div>
                                            <strong>{{ $employee->name }}</strong><br>
                                            <small class="text-muted">{{ $employee->department }} - {{ $employee->position }}</small>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">No employees found.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow mb-4">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <span>Today's Attendance</span>
                            <a href="{{ route('attendance.index') }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-list me-1"></i> View All
                            </a>
                        </div>
                        <div class="card-body">
                            @if($recent_attendance->count() > 0)
                                @foreach($recent_attendance as $attendance)
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-clock fa-lg text-primary me-3"></i>
                                            <div>
                                                <strong>{{ $attendance->employee->name }}</strong><br>
                                                <small class="text-muted">
                                                    @if($attendance->check_in && $attendance->check_out)
                                                        In: {{ $attendance->check_in }} | Out: {{ $attendance->check_out }}
                                                    @elseif($attendance->check_in)
                                                        In: {{ $attendance->check_in }} | <span class="text-warning">Still working</span>
                                                    @else
                                                        <span class="text-danger">Not checked in</span>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge bg-{{ $attendance->status === 'present' ? 'success' : ($attendance->status === 'absent' ? 'danger' : 'warning') }}">
                                                {{ ucfirst($attendance->status) }}
                                            </span>
                                            @if($attendance->check_in && $attendance->check_out)
                                                @php
                                                    $checkIn = \Carbon\Carbon::parse($attendance->check_in);
                                                    $checkOut = \Carbon\Carbon::parse($attendance->check_out);
                                                    $workHours = $checkOut->diff($checkIn)->format('%H:%I');
                                                @endphp
                                                <br><small class="text-muted">{{ $workHours }}h</small>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <p class="text-muted">No attendance records for today.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
@endsection

@push('scripts')
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
