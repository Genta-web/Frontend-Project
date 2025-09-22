@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-4 pb-3 mb-4 border-bottom">
        <h1 class="h3">Manager Dashboard</h1>
        <div class="btn-toolbar">
            <div class="btn-group">
                <button type="button" class="btn btn-sm btn-outline-primary">
                    <i class="fas fa-download me-1"></i> Export
                </button>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Team Members
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['team_members'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Attendance Today
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['attendance_today'] }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Manager Tools -->
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Team Management</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary">
                            <i class="fas fa-users me-2"></i> View Team
                        </button>
                        <button class="btn btn-info">
                            <i class="fas fa-clock me-2"></i> Team Attendance
                        </button>
                        <button class="btn btn-warning">
                            <i class="fas fa-tasks me-2"></i> Assign Tasks
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Reports</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button class="btn btn-success">
                            <i class="fas fa-chart-bar me-2"></i> Performance Report
                        </button>
                        <button class="btn btn-secondary">
                            <i class="fas fa-calendar me-2"></i> Monthly Summary
                        </button>
                    </div>
                </div>
            </div>
        </div>
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
