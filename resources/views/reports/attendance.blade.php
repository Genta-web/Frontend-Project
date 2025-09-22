@extends('layouts.admin')

@section('title', 'Attendance Report')

@push('styles')
<style>
.status-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
}
.status-present { background-color: #d4edda; color: #155724; }
.status-sick { background-color: #fff3cd; color: #856404; }
.status-leave { background-color: #cce7ff; color: #004085; }
.status-absent { background-color: #f8d7da; color: #721c24; }
.report-header {
    background: linear-gradient(135deg, #03a9f4 0%, #0288d1 50%, #0277bd 100%);
    color: white;
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(3, 169, 244, 0.4);
    position: relative;
    overflow: hidden;
}

.report-header::before {
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

.dashboard-subtitle {
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

.summary-card {
    border-radius: 0.5rem;
    border: none;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
}

/* CSS untuk Kartu Statistik */
.stats-card {
    background-color: #fff;
    border-radius: 12px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    border-left: 5px solid;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.stats-icon {
    width: 60px;
    height: 60px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: #fff;
}

.stats-info h3 {
    font-size: 2.25rem;
    font-weight: 700;
    margin: 0 0 0.25rem 0;
}

.stats-info p {
    font-size: 1rem;
    color: #6c757d;
    margin: 0;
}

/* Variasi Warna Kartu */
.stats-card.total { border-color: #0d6efd; }
.stats-card.total .stats-icon { background-color: #0d6efd; }
.stats-card.total .stats-info h3 { color: #0d6efd; }

.stats-card.approved { border-color: #198754; }
.stats-card.approved .stats-icon { background-color: #198754; }
.stats-card.approved .stats-info h3 { color: #198754; }

.stats-card.absent { border-color: #f03d3dff; }
.stats-card.absent .stats-icon { background-color: #f03d3dff; }
.stats-card.absent .stats-info h3 { color: #f03d3dff; }

.stats-card.pending { border-color: #ffc107; }
.stats-card.pending .stats-icon { background-color: #ffc107; }
.stats-card.pending .stats-info h3 { color: #ffc107; }

.stats-card.days { border-color: #fd7e14; }
.stats-card.days .stats-icon { background-color: #fd7e14; }
.stats-card.days .stats-info h3 { color: #fd7e14; }


</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Report Header -->
    <div class="report-header">
        <div class="row align-items-center">
            <div class="col">
                <h1 class="dashboard-title">
                    <i class="fas fa-calendar-check"></i> Attendance Report
                </h1>
                <p class="dashboard-subtitle">
                    Period: {{ $startDate->format('M d, Y') }} - {{ $endDate->format('M d, Y') }}
                </p>
            </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <a href="{{ route('reports.index') }}" class="btn comprehensive-btn">
                        <i class="fas fa-arrow-left me-2"></i> Back to Reports
                    </a>
                    <a href="{{ route('reports.attendance', array_merge(request()->all(), ['format' => 'pdf'])) }}"
                       class="btn comprehensive-btn">
                        <i class="fas fa-file-pdf me-2"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card total">
                    <div class="stats-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stats-info">
                        <h3>{{ $summary['total_records'] }}</h3>
                        <p>Total Today</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card approved">
                    <div class="stats-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <div class="stats-info">
                        <h3>{{ $summary['present'] }}</h3>
                        <p>Present Today</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card absent">
                    <div class="stats-icon">
                        <i class="fas fa-times"></i>
                    </div>
                    <div class="stats-info">
                        <h3>{{ $summary['absent'] }}</h3>
                        <p>Absent Today</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-3">
                <div class="stats-card pending">
                    <div class="stats-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stats-info">
                        <h3>{{ $summary['late'] ?? 0 }}</h3>
                        <p>Late Today</p>
                    </div>
                </div>
            </div>
        </div>

    <!-- Attendance Data Table -->
    <div class="card">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Attendance Records</h6>
        </div>
        <div class="card-body">
            @if($attendances->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Employee</th>
                                <th>Check In</th>
                                <th>Check Out</th>
                                <th>Status</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $attendance)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($attendance->date)->format('M d, Y') }}</td>
                                <td>
                                    <div class="fw-bold">{{ $attendance->employee->name }}</div>
                                    <small class="text-muted">{{ $attendance->employee->employee_code }}</small>
                                </td>
                                <td>
                                    @if($attendance->check_in)
                                        <span class="badge bg-success">
                                            {{ \Carbon\Carbon::parse($attendance->check_in)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($attendance->check_out)
                                        <span class="badge bg-info">
                                            {{ \Carbon\Carbon::parse($attendance->check_out)->format('H:i') }}
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <span class="status-badge status-{{ $attendance->status }}">
                                        {{ ucfirst($attendance->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($attendance->notes)
                                        <small>{{ Str::limit($attendance->notes, 50) }}</small>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                    <h5 class="text-muted">No attendance records found</h5>
                    <p class="text-muted">No attendance data available for the selected period.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Additional Statistics -->
    @if($attendances->count() > 0)
    <div class="row mt-4 mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Attendance by Status</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h5 text-success">{{ number_format(($summary['present'] / $summary['total_records']) * 100, 1) }}%</div>
                                <div class="small text-muted">Present Rate</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h5 text-danger">{{ number_format(($summary['absent'] / $summary['total_records']) * 100, 1) }}%</div>
                                <div class="small text-muted">Absence Rate</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Daily Average</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h5 text-info">{{ number_format($summary['total_records'] / max(1, $startDate->diffInDays($endDate) + 1), 1) }}</div>
                                <div class="small text-muted">Records/Day</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h5 text-warning">{{ $attendances->groupBy('employee_id')->count() }}</div>
                                <div class="small text-muted">Employees</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add any interactive features here if needed
    console.log('Attendance report loaded');

    // Handle PDF download links - prevent loading overlay
    const pdfDownloadLinks = document.querySelectorAll('a[href*="format=pdf"]');
    pdfDownloadLinks.forEach(link => {
        // Add event listener with high priority (capture phase)
        link.addEventListener('click', function(e) {
            // Prevent any loading overlay from showing
            e.stopPropagation();
            e.stopImmediatePropagation();

            // Hide any existing loading overlay immediately
            const loadingOverlay = document.getElementById('loadingOverlay');
            if (loadingOverlay) {
                loadingOverlay.classList.remove('show');
                loadingOverlay.style.display = 'none';
            }

            // Override any global showLoading function temporarily
            const originalShowLoading = window.showLoading;
            window.showLoading = function() {
                console.log('Loading prevented for PDF download');
            };

            // Restore original function after a short delay
            setTimeout(() => {
                window.showLoading = originalShowLoading;
            }, 1000);

            // Add CSS rule to force hide loading overlay
            const style = document.createElement('style');
            style.id = 'pdf-download-style';
            style.textContent = `
                .loading-overlay, #loadingOverlay {
                    display: none !important;
                    opacity: 0 !important;
                    visibility: hidden !important;
                }
            `;
            document.head.appendChild(style);

            // Remove the style after download starts
            setTimeout(() => {
                const styleElement = document.getElementById('pdf-download-style');
                if (styleElement) {
                    styleElement.remove();
                }
            }, 2000);

            // Allow the link to proceed normally
            return true;
        }, true); // Use capture phase for higher priority
    });
});
</script>
@endpush
