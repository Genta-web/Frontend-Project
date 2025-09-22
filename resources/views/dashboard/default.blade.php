@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-4 pb-3 mb-4 border-bottom">
        <h1 class="h3">Dashboard</h1>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Welcome to Employee Management System</h6>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-users fa-5x text-gray-300 mb-4"></i>
                    <h4>Welcome!</h4>
                    <p class="text-muted">
                        You have successfully logged into the Employee Management System.
                        Your role and permissions will determine what features are available to you.
                    </p>

                    <div class="mt-4">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <a href="{{ route('profile.show') }}" class="text-decoration-none">
                                    <div class="card border-left-primary h-100 hover-card">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user fa-2x text-primary mb-2"></i>
                                            <h6>Profile</h6>
                                            <p class="text-muted small">Manage your profile information</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-success">
                                    <div class="card-body text-center">
                                        <i class="fas fa-clock fa-2x text-success mb-2"></i>
                                        <h6>Attendance</h6>
                                        <p class="text-muted small">Track your attendance</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-info">
                                    <div class="card-body text-center">
                                        <i class="fas fa-cog fa-2x text-info mb-2"></i>
                                        <h6>Settings</h6>
                                        <p class="text-muted small">Configure your preferences</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <p class="text-muted">
                            <strong>Current User:</strong> {{ Auth::user()->username ?? 'Unknown' }}<br>
                            <strong>Role:</strong> {{ ucfirst(Auth::user()->role ?? 'Unknown') }}<br>
                            <strong>Login Time:</strong> {{ now()->format('d M Y, H:i:s') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
.hover-card {
    transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
}

.hover-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}
</style>

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
