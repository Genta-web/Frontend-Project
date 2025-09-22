@extends('layouts.admin')

@section('title', 'Employee Dashboard')

@push('styles')
<style>
    /* Custom Styles for Modern Dashboard */
    :root {
        --primary-blue: #4A90E2; --dark-blue: #3A7BC8; --accent-green: #50E3C2;
        --accent-yellow: #F5A623; --accent-red: #D0021B; --text-dark: #333A45;
        --text-secondary: #7A869A; --border-light: #E8EDF2; --card-bg: #FFFFFF;
        --body-bg: #F8FAFC; --shadow-soft: 0 4px 12px rgba(0, 0, 0, 0.08);
        --pastel-red: #e68a89; --pastel-red-hover: #d97a79;
    }
    body { background-color: var(--body-bg); color: var(--text-dark); font-family: 'Inter', sans-serif; }
    .dashboard-greeting h1 { font-weight: 700; font-size: 1.75rem; }
    .dashboard-greeting p { color: var(--text-secondary); font-size: 1rem; }
    .current-time { background-color: var(--card-bg); padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid var(--border-light); font-weight: 500; color: var(--text-secondary); }
    .dashboard-card { background-color: var(--card-bg); border-radius: 12px; box-shadow: var(--shadow-soft); padding: 1.5rem; border: 1px solid var(--border-light); height: 100%; display: flex; flex-direction: column; }
    .card-today { text-align: center; }
    .card-today-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
    .card-today-header h5 { font-weight: 600; margin: 0; }
    .status-badge { font-size: 0.75rem; font-weight: 600; padding: 0.25rem 0.75rem; border-radius: 99px; }
    .status-badge.absent { background-color: #FEE2E2; color: var(--accent-red); }
    .status-badge.present { background-color: #D1FAE5; color: #065F46; }
    .progress-circle { position: relative; width: 150px; height: 150px; border-radius: 50%; background: conic-gradient(var(--accent-yellow) 0% 67%, var(--border-light) 67% 100%); margin: 0 auto 1.5rem auto; display: flex; align-items: center; justify-content: center; transition: background 0.5s ease; }
    .progress-circle::before { content: ''; position: absolute; width: 85%; height: 85%; background-color: var(--card-bg); border-radius: 50%; }
    .progress-inner { position: relative; z-index: 1; }
    .progress-percent { font-size: 2rem; font-weight: 700; display: block; }
    .progress-label { font-size: 0.8rem; color: var(--text-secondary); }
    .time-tracker { font-size: 0.9rem; font-weight: 500; margin-bottom: 1.5rem; }
    .time-tracker.time-left { color: var(--accent-red); }
    .time-tracker.working-time { color: var(--primary-blue); }
    .action-btn { width: 100%; padding: 0.8rem; font-size: 1rem; font-weight: 600; border: none; border-radius: 8px; cursor: pointer; transition: background-color 0.2s, opacity 0.2s; }
    .action-btn:disabled { opacity: 0.6; cursor: not-allowed; }
    .btn-checkin { background-color: var(--primary-blue); color: white; }
    .btn-checkin:hover:not(:disabled) { background-color: var(--dark-blue); }
    .btn-checkout { background-color: var(--accent-yellow); color: #fff; }
    .btn-checkout:hover:not(:disabled) { background-color: #e09418; }
    .stat-card { background-color: var(--card-bg); border-radius: 12px; box-shadow: var(--shadow-soft); padding: 1.5rem; border: 1px solid var(--border-light); display: flex; flex-direction: column; justify-content: space-between; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 16px rgba(0,0,0,0.1); }
    .stat-card a { text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%; }
    .stat-card-title { color: var(--text-secondary); font-size: 0.9rem; font-weight: 500; }
    .stat-card-value { font-size: 1.25rem; font-weight: 600; margin-top: 0.5rem; color: var(--text-dark); transition: all 0.3s ease; }
    .stat-card-value.updating { transform: scale(1.1); color: var(--primary-blue); }
    .btn-request-leave { background-color: var(--pastel-red); color: white !important; width: 100%; padding: 0.6rem; border-radius: 8px; border: none; cursor: pointer; margin-top: 1rem; font-weight: 600; text-align: center; text-decoration: none; display: block; transition: background-color 0.2s; }
    .btn-request-leave:hover { background-color: var(--pastel-red-hover); }
    .work-log-preview-header h5 { font-weight: 600; margin: 0; }
    .task-summary { list-style: none; padding: 0; margin: 0 0 1.5rem 0; }
    .task-item { padding: 0.75rem 0; border-bottom: 1px solid var(--border-light); color: var(--text-secondary); }
    .task-item:last-child { border-bottom: none; }
    .work-status-title { font-weight: 600; color: var(--text-dark); margin-bottom: 0.5rem; }
    .status-badge.on-progress { background-color: #DBEAFE; color: #3B82F6; }

    /* Style untuk pop-up notifikasi */
    .popup-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center; z-index: 1000; }
    .popup-card { background: white; padding: 2.5rem; border-radius: 1.5rem; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1); text-align: center; max-width: 400px; width: 90%; }
    .popup-icon { width: 80px; height: 80px; margin: 0 auto 1.5rem auto; border-radius: 50%; display: flex; justify-content: center; align-items: center; }
    .popup-icon svg { width: 40px; height: 40px; }
    .popup-title { font-size: 1.75rem; font-weight: 700; color: #1F2937; margin: 0 0 0.5rem 0; }
    .popup-message { font-size: 1rem; color: #6B7280; margin: 0 0 2rem 0; }
    .popup-button { width: 100%; padding: 0.8rem 1rem; color: white; border: none; border-radius: 0.75rem; font-size: 1rem; font-weight: 500; cursor: pointer; }
    .popup-success .popup-icon { background-color: #D1FAE5; }
    .popup-success .popup-icon svg { color: #065F46; }
    .popup-success .popup-button { background-color: #10B981; }
    .popup-error .popup-icon { background-color: #FEE2E2; }
    .popup-error .popup-icon svg { color: #991B1B; }
    .popup-error .popup-button { background-color: #EF4444; }
    .popup-warning .popup-icon { background-color: #FEF3C7; }
    .popup-warning .popup-icon svg { color: #92400E; }
    .popup-warning .popup-button { background-color: #F59E0B; }

    /* Location Status Styles */
    .location-status {
        padding: 0.75rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        font-size: 0.875rem;
        font-weight: 500;
        text-align: center;
        transition: all 0.3s ease;
    }

    .location-status.loading {
        background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
        color: white;
        animation: pulse 2s infinite;
    }

    .location-status.success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: white;
    }

    .location-status.error {
        background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        color: white;
    }

    .location-status.info {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
        color: white;
    }

    @keyframes pulse {
        0%, 100% {
            opacity: 1;
        }
        50% {
            opacity: 0.7;
        }
    }

    /* Location Display Styles */
    .location-display {
        background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        padding: 1rem;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .location-display-header {
        display: flex;
        align-items: center;
        font-weight: 600;
        color: #475569;
        font-size: 0.875rem;
        margin-bottom: 0.5rem;
    }

    .location-display-text {
        font-size: 0.8rem;
        color: #64748b;
        line-height: 1.4;
        margin-bottom: 0.5rem;
    }

    .location-accuracy {
        font-size: 0.75rem;
        color: #94a3b8;
        font-style: italic;
    }

    .location-display.active {
        background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
        border-color: #10b981;
    }

    .location-display.active .location-display-header {
        color: #065f46;
    }

    .location-display.active .location-display-text {
        color: #047857;
    }
</style>
@endpush

@section('content')
@if(session('success') || session('error') || session('warning'))
    @php
        $status = session('success') ? 'success' : (session('error') ? 'error' : 'warning');
        $message = session($status);
        $title = ucfirst($status);
        $iconSvg = $status === 'success'
            ? '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />'
            : '<path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />';
    @endphp
    <div class="popup-overlay" id="sessionPopup">
        <div class="popup-card popup-{{ $status }}">
            <div class="popup-icon">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">{!! $iconSvg !!}</svg>
            </div>
            <h2 class="popup-title">{{ $title }}!</h2>
            <p class="popup-message">{{ $message }}</p>
            <button class="popup-button" id="closePopup">OK</button>
        </div>
    </div>
@endif

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center dashboard-greeting">
        <div>
            <h1 id="greeting-text">Good afternoon, {{ $employee->name ?? 'Guest' }}!</h1>
            <p id="dynamic-info">
                @if(($leaveStats['pending_requests'] ?? 0) > 0)
                    You have {{ $leaveStats['pending_requests'] }} leave request{{ $leaveStats['pending_requests'] > 1 ? 's' : '' }} pending
                @else
                    Welcome back! Have a productive day.
                @endif
            </p>
        </div>
        <div class="current-time">
            <i class="far fa-clock me-2"></i>
            <span id="live-time">{{ now()->format('d M Y, h:i A') }}</span>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 mb-4">
            <div class="dashboard-card card-today">
                @php
                    $attendanceToday = $attendanceToday ?? null; // Memastikan variabel ada
                    $hasCheckedIn = $attendanceToday && $attendanceToday->check_in;
                    $hasCheckedOut = $hasCheckedIn && $attendanceToday->check_out;
                    $statusText = $hasCheckedIn ? 'Present' : 'Absent';
                    $statusClass = $hasCheckedIn ? 'present' : 'absent';
                    $statusMessage = $hasCheckedIn ? 'You have checked in for today.' : 'You have not marked yourself as present today!';
                @endphp
                <div class="card-today-header">
                    <h5>Today</h5>
                    <span id="attendance-status-badge" class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                </div>
                <div class="progress-circle" id="attendance-progress">
                    <div class="progress-inner">
                        <span class="progress-percent">{{ $attendanceStats['percentage'] ?? 0 }}%</span>
                        <span class="progress-label">attendance</span>
                    </div>
                </div>
                <p id="attendance-status-text">{{ $statusMessage }}</p>
                <p id="time-tracker" class="time-tracker time-left">Calculating...</p>

                <div class="mt-auto">
                    <!-- Location Status Display -->
                    <div id="location-status" class="location-status" style="display: none;"></div>

                    <!-- Current Location Display -->
                    <div id="current-location-display" class="location-display" style="display: none;">
                        <div class="location-display-header">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            <span>Current Location</span>
                        </div>
                        <div id="current-location-text" class="location-display-text"></div>
                        <div id="location-accuracy" class="location-accuracy"></div>
                    </div>

                    <form action="{{ route('attendance.checkin') }}" method="POST" class="d-grid" id="checkin-form">
                        @csrf
                        <button type="submit" class="action-btn btn-checkin mb-2" id="checkin-btn" {{ $hasCheckedIn ? 'disabled' : '' }}>
                            <i class="fas fa-map-marker-alt me-2"></i>Check In
                        </button>
                    </form>
                    <form action="{{ route('attendance.checkout') }}" method="POST" class="d-grid" id="checkout-form">
                        @csrf
                        <button type="submit" class="action-btn btn-checkout" id="checkout-btn" {{ !$hasCheckedIn || $hasCheckedOut ? 'disabled' : '' }}>
                            <i class="fas fa-map-marker-alt me-2"></i>Check Out
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-3 mb-4">
            <div class="stat-card mb-4">
                <a href="{{ route('worklogs.index') }}">
                    <i class="far fa-folder-open fa-2x text-warning mb-3"></i>
                    <div class="stat-card-title">Total Work Logs</div>
                    <div class="stat-card-value" id="total-work-logs">{{ $stats['total_work_logs'] ?? 0 }}</div>
                </a>
            </div>
            <div class="stat-card mb-4">
                <a href="{{ route('attendance.index') }}">
                    <i class="far fa-check-circle fa-2x text-info mb-3"></i>
                    <div class="stat-card-title">Attendance Rate</div>
                    <div class="stat-card-value" id="attendance-percentage">{{ $attendanceStats['percentage'] ?? 0 }}%</div>
                </a>
            </div>
            <div class="stat-card">
                <i class="far fa-calendar-times fa-2x mb-3" style="color: #c97c7b;"></i>
                <div class="stat-card-title">Pending Leaves</div>
                <div class="stat-card-value" id="pending-leaves">{{ $leaveStats['pending_requests'] ?? 0 }}</div>
                <a href="{{ route('leave.index') }}" class="btn-request-leave">View Leaves</a>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="dashboard-card work-log-preview" style="background: #f7fbff; border-radius: 16px; box-shadow: 0 4px 16px rgba(74,144,226,0.07);">
                <div class="work-log-preview-header d-flex justify-content-between align-items-center mb-3 pb-2" style="border-bottom: 1px solid #e8edf2;">
                    <h5 style="font-weight:700;color:#4A90E2;margin:0;display:flex;align-items:center;gap:0.5rem;"><i class="fas fa-tasks"></i> Recent Work Logs</h5>
                    <a href="{{ route('worklogs.index') }}" class="btn btn-sm btn-outline-primary" style="border-radius:8px;font-weight:600;">View All</a>
                </div>

                @if($recentWorkLogs->count() > 0)
                    <div class="mb-4">
                        <p class="work-status-title mb-2" style="font-weight:600;color:#333A45;">Recent Tasks</p>
                        <ul class="task-summary" style="padding:0;margin:0;list-style:none;">
                            @foreach($recentWorkLogs->take(3) as $workLog)
                                <li class="task-item" style="background:#fff;border-radius:10px;padding:1rem 1.2rem;margin-bottom:1rem;box-shadow:0 2px 8px rgba(74,144,226,0.05);border:1px solid #e8edf2;display:flex;justify-content:space-between;align-items:center;">
                                    <div style="flex:1;min-width:0;">
                                        <div style="font-weight:600;font-size:1rem;color:#333A45;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($workLog->task_summary, 40) }}</div>
                                        <div style="font-size:0.95rem;color:#7A869A;margin-top:2px;">
                                            <i class="far fa-calendar-alt me-1"></i>{{ $workLog->work_date->format('M j, Y') }}
                                        </div>
                                    </div>
                                    <div style="display:flex;flex-direction:column;align-items:flex-end;gap:0.3rem;">
                                        <span class="badge bg-primary" style="font-size:0.95rem;padding:0.5em 1em;border-radius:8px;">{{ $workLog->start_time }} - {{ $workLog->end_time }}</span>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-auto d-flex align-items-center justify-content-between pt-2" style="border-top:1px solid #e8edf2;">
                        <p class="work-status-title mb-0" style="font-weight:600;color:#333A45;">This Month</p>
                        <span class="status-badge on-progress" style="font-size:1rem;padding:0.5em 1.2em;">{{ $stats['work_logs_this_month'] ?? 0 }} Work Logs</span>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No work logs yet</p>
                        <a href="{{ route('worklogs.create') }}" class="btn btn-primary btn-sm">Create First Work Log</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // === SCRIPT HANYA UNTUK FUNGSI VISUAL DI BROWSER ===

    // 1. Logika untuk menutup pop-up session
    const sessionPopup = document.getElementById('sessionPopup');
    if (sessionPopup) {
        const closeBtn = sessionPopup.querySelector('#closePopup');
        const closePopupFunc = () => { sessionPopup.style.display = 'none'; };
        if(closeBtn) closeBtn.addEventListener('click', closePopupFunc);
        sessionPopup.addEventListener('click', (e) => { if (e.target === sessionPopup) closePopupFunc(); });
    }

    // 2. Logika untuk jam dan sapaan dinamis
    const greetingEl = document.getElementById('greeting-text');
    const timeEl = document.getElementById('live-time');
    const employeeName = "{{ $employee->name ?? 'Guest' }}";

    function updateTimeAndGreeting() {
    const now = new Date();
    const hour = now.getHours(); // Mendapatkan jam (0-23)
    let greeting;

    if (hour >= 5 && hour < 12) {
        // Dari jam 5 pagi hingga 11:59 siang
        greeting = 'Good morning';
    } else if (hour >= 12 && hour < 18) {
        // Dari jam 12 siang hingga 5:59 sore
        greeting = 'Good afternoon';
    } else if (hour >= 18 && hour < 22) {
        // Dari jam 6 sore hingga 9:59 malam
        greeting = 'Good evening';
    } else {
        // Jam 10 malam hingga 4:59 pagi
        greeting = 'Good night';
    }

    // Memperbarui tulisan di HTML
    if (greetingEl) {
        greetingEl.textContent = `${greeting}, ${employeeName}!`;
    }

    // Memperbarui jam di HTML dengan detik
    if (timeEl) {
        timeEl.textContent = now.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ', ' + now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false });
    }
}


    updateTimeAndGreeting();

    // Atur agar fungsi dijalankan setiap 1 detik untuk jam berjalan real-time
    setInterval(updateTimeAndGreeting, 1000);

    // 3. Logika untuk countdown dan timer (menggunakan data dari server)
    const timeTrackerEl = document.getElementById('time-tracker');
    const attendanceToday = @json($attendanceToday ?? null);
    let timerInterval = null;

    // Debug: Log attendance data
    console.log('Attendance Today:', attendanceToday);

    // 4. Update progress circle dynamically
    function updateProgressCircle() {
        const progressCircle = document.getElementById('attendance-progress');
        const percentage = {{ $attendanceStats['percentage'] ?? 0 }};

        if (progressCircle) {
            // Update CSS custom property for conic-gradient
            const gradientValue = `conic-gradient(var(--accent-yellow) 0% ${percentage}%, var(--border-light) ${percentage}% 100%)`;
            progressCircle.style.background = gradientValue;
        }
    }

    function updateProgressCircleWithValue(percentage) {
        const progressCircle = document.getElementById('attendance-progress');

        if (progressCircle) {
            // Animate the progress circle
            const gradientValue = `conic-gradient(var(--accent-yellow) 0% ${percentage}%, var(--border-light) ${percentage}% 100%)`;
            progressCircle.style.background = gradientValue;

            // Update the percentage text
            const percentText = progressCircle.querySelector('.progress-percent');
            if (percentText) {
                percentText.textContent = percentage + '%';
            }
        }
    }

    // 5. Auto-refresh dashboard data every 5 minutes
    function refreshDashboardData() {
        // Update stats without full page reload
        fetch('/api/dashboard-stats', {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Animate and update work logs count
                const workLogsEl = document.getElementById('total-work-logs');
                if (workLogsEl) {
                    workLogsEl.classList.add('updating');
                    setTimeout(() => {
                        workLogsEl.textContent = data.stats.total_work_logs;
                        workLogsEl.classList.remove('updating');
                    }, 150);
                }

                // Animate and update attendance percentage
                const attendanceEl = document.getElementById('attendance-percentage');
                if (attendanceEl) {
                    attendanceEl.classList.add('updating');
                    setTimeout(() => {
                        attendanceEl.textContent = data.stats.attendance_percentage + '%';
                        attendanceEl.classList.remove('updating');
                        // Update progress circle
                        updateProgressCircleWithValue(data.stats.attendance_percentage);
                    }, 150);
                }

                // Animate and update pending leaves
                const leavesEl = document.getElementById('pending-leaves');
                if (leavesEl) {
                    leavesEl.classList.add('updating');
                    setTimeout(() => {
                        leavesEl.textContent = data.stats.pending_leaves;
                        leavesEl.classList.remove('updating');
                    }, 150);
                }

                // Update dynamic info
                const infoEl = document.getElementById('dynamic-info');
                if (infoEl && data.stats.pending_leaves > 0) {
                    infoEl.textContent = `You have ${data.stats.pending_leaves} leave request${data.stats.pending_leaves > 1 ? 's' : ''} pending`;
                } else if (infoEl) {
                    infoEl.textContent = 'Welcome back! Have a productive day.';
                }
            }
        })
        .catch(error => console.log('Dashboard refresh error:', error));
    }

    // Variable to store the actual start time for timer
    let workingStartTime = null;

    function startTimer() {
        // Create check-in time with more robust parsing
        let checkInTime = null;
        let checkOutTime = null;

        if (attendanceToday && attendanceToday.check_in) {
            const dateStr = attendanceToday.date;
            const timeStr = attendanceToday.check_in;
            checkInTime = new Date(`${dateStr}T${timeStr}`);

            // Fallback if date parsing fails
            if (isNaN(checkInTime.getTime())) {
                const today = new Date();
                const [hours, minutes, seconds] = timeStr.split(':');
                checkInTime = new Date(today.getFullYear(), today.getMonth(), today.getDate(), hours, minutes, seconds || 0);
            }
        }

        if (attendanceToday && attendanceToday.check_out) {
            const dateStr = attendanceToday.date;
            const timeStr = attendanceToday.check_out;
            checkOutTime = new Date(`${dateStr}T${timeStr}`);

            // Fallback if date parsing fails
            if (isNaN(checkOutTime.getTime())) {
                const today = new Date();
                const [hours, minutes, seconds] = timeStr.split(':');
                checkOutTime = new Date(today.getFullYear(), today.getMonth(), today.getDate(), hours, minutes, seconds || 0);
            }
        }

        if (timerInterval) clearInterval(timerInterval);

        if (checkOutTime) { // Jika sudah check out
            timeTrackerEl.textContent = "You have checked out for today.";
            return;
        }

        timerInterval = setInterval(() => {
            const now = new Date();
            if (checkInTime) { // Mode "Working"
                // Use workingStartTime if set (for fresh check-ins), otherwise use checkInTime from database
                const startTime = workingStartTime || checkInTime;
                const diff = now - startTime;
                const hours = String(Math.floor(diff / 3600000)).padStart(2, '0');
                const minutes = String(Math.floor((diff / 60000) % 60)).padStart(2, '0');
                const seconds = String(Math.floor((diff / 1000) % 60)).padStart(2, '0');
                timeTrackerEl.className = 'time-tracker working-time';
                timeTrackerEl.textContent = `Working: ${hours}h ${minutes}m ${seconds}s`;
            } else { // Mode "Countdown"
                const deadline = new Date();
                deadline.setHours(16, 0, 0, 0); // Deadline jam 4 sore
                if (now >= deadline) {
                    timeTrackerEl.textContent = "Check-in time has passed.";
                    clearInterval(timerInterval);
                } else {
                    const diff = deadline - now;
                    const hours = String(Math.floor(diff / 3600000)).padStart(2, '0');
                    const minutes = String(Math.floor((diff / 60000) % 60)).padStart(2, '0');
                    const seconds = String(Math.floor((diff / 1000) % 60)).padStart(2, '0');
                    timeTrackerEl.className = 'time-tracker time-left';
                    timeTrackerEl.textContent = `Time Left: ${hours}h ${minutes}m ${seconds}s`;
                }
            }
        }, 1000);
    }

    if(timeTrackerEl) {
        startTimer();
    }

    // Geolocation functionality
    let currentLocation = null;
    let locationStatus = 'unknown';

    function getCurrentLocation() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('Geolocation is not supported by this browser'));
                return;
            }

            const options = {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 300000 // 5 minutes
            };

            navigator.geolocation.getCurrentPosition(
                async (position) => {
                    const coords = {
                        latitude: position.coords.latitude,
                        longitude: position.coords.longitude,
                        accuracy: position.coords.accuracy
                    };

                    try {
                        // Reverse geocoding to get readable address
                        const address = await reverseGeocode(coords.latitude, coords.longitude);
                        resolve({
                            ...coords,
                            address: address
                        });
                    } catch (error) {
                        // If reverse geocoding fails, still return coordinates
                        resolve({
                            ...coords,
                            address: `${coords.latitude.toFixed(6)}, ${coords.longitude.toFixed(6)}`
                        });
                    }
                },
                (error) => {
                    let errorMessage = 'Unable to retrieve location';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage = 'Location access denied by user';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage = 'Location information unavailable';
                            break;
                        case error.TIMEOUT:
                            errorMessage = 'Location request timed out';
                            break;
                    }
                    reject(new Error(errorMessage));
                },
                options
            );
        });
    }

    async function reverseGeocode(lat, lng) {
        try {
            // Using OpenStreetMap Nominatim API for reverse geocoding
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&zoom=18&addressdetails=1`);
            const data = await response.json();

            if (data && data.display_name) {
                return data.display_name;
            } else {
                return `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
            }
        } catch (error) {
            console.warn('Reverse geocoding failed:', error);
            return `${lat.toFixed(6)}, ${lng.toFixed(6)}`;
        }
    }

    function showLocationStatus(message, type = 'info') {
        const statusEl = document.getElementById('location-status');
        if (statusEl) {
            statusEl.textContent = message;
            statusEl.className = `location-status ${type}`;
            statusEl.style.display = 'block';
        }
    }

    function hideLocationStatus() {
        const statusEl = document.getElementById('location-status');
        if (statusEl) {
            statusEl.style.display = 'none';
        }
    }

    function showCurrentLocation(location) {
        const displayEl = document.getElementById('current-location-display');
        const textEl = document.getElementById('current-location-text');
        const accuracyEl = document.getElementById('location-accuracy');

        if (displayEl && textEl && accuracyEl) {
            textEl.textContent = location.address;
            accuracyEl.textContent = `Accuracy: ±${Math.round(location.accuracy)}m`;
            displayEl.classList.add('active');
            displayEl.style.display = 'block';
        }
    }

    function hideCurrentLocation() {
        const displayEl = document.getElementById('current-location-display');
        if (displayEl) {
            displayEl.classList.remove('active');
            displayEl.style.display = 'none';
        }
    }

    // Handle check-in button click with geolocation
    const checkinForm = document.getElementById('checkin-form');
    if (checkinForm) {
        checkinForm.addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent immediate form submission

            const submitBtn = document.getElementById('checkin-btn');
            const originalText = submitBtn.textContent;

            try {
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.textContent = 'Getting Location...';
                showLocationStatus('Capturing your location...', 'loading');

                // Get current location
                const location = await getCurrentLocation();
                currentLocation = location;

                // Add location data to form
                const form = e.target;

                // Remove existing hidden inputs if any
                const existingInputs = form.querySelectorAll('input[name^="location"], input[name^="latitude"], input[name^="longitude"]');
                existingInputs.forEach(input => input.remove());

                // Add new hidden inputs
                const latInput = document.createElement('input');
                latInput.type = 'hidden';
                latInput.name = 'latitude';
                latInput.value = location.latitude;
                form.appendChild(latInput);

                const lngInput = document.createElement('input');
                lngInput.type = 'hidden';
                lngInput.name = 'longitude';
                lngInput.value = location.longitude;
                form.appendChild(lngInput);

                const locInput = document.createElement('input');
                locInput.type = 'hidden';
                locInput.name = 'location';
                locInput.value = location.address;
                form.appendChild(locInput);

                showLocationStatus(`Location captured: ${location.address}`, 'success');
                showCurrentLocation(location);

                // Update UI immediately
                workingStartTime = new Date();
                timeTrackerEl.className = 'time-tracker working-time';
                timeTrackerEl.textContent = 'Working: 00h 00m 00s';

                const statusBadge = document.getElementById('attendance-status-badge');
                const statusText = document.getElementById('attendance-status-text');
                if (statusBadge) {
                    statusBadge.className = 'status-badge present';
                    statusBadge.textContent = 'Present';
                }
                if (statusText) {
                    statusText.textContent = 'You have checked in for today.';
                }

                const checkoutBtn = document.getElementById('checkout-btn');
                if (checkoutBtn) checkoutBtn.disabled = false;

                startTimer();

                // Submit the form
                submitBtn.textContent = 'Checking In...';
                form.submit();

            } catch (error) {
                console.error('Location error:', error);
                showLocationStatus(error.message, 'error');

                // Ask user if they want to proceed without location
                const proceed = confirm(`${error.message}\n\nWould you like to check in without location data?`);
                if (proceed) {
                    // Update UI and submit without location
                    workingStartTime = new Date();
                    timeTrackerEl.className = 'time-tracker working-time';
                    timeTrackerEl.textContent = 'Working: 00h 00m 00s';

                    const statusBadge = document.getElementById('attendance-status-badge');
                    const statusText = document.getElementById('attendance-status-text');
                    if (statusBadge) {
                        statusBadge.className = 'status-badge present';
                        statusBadge.textContent = 'Present';
                    }
                    if (statusText) {
                        statusText.textContent = 'You have checked in for today.';
                    }

                    const checkoutBtn = document.getElementById('checkout-btn');
                    if (checkoutBtn) checkoutBtn.disabled = false;

                    startTimer();

                    submitBtn.textContent = 'Checking In...';
                    e.target.submit();
                } else {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    hideLocationStatus();
                }
            }
        });
    }

    // Handle check-out button click with geolocation
    const checkoutForm = document.getElementById('checkout-form');
    if (checkoutForm) {
        checkoutForm.addEventListener('submit', async function(e) {
            e.preventDefault(); // Prevent immediate form submission

            const submitBtn = document.getElementById('checkout-btn');
            const originalText = submitBtn.textContent;

            try {
                // Show loading state
                submitBtn.disabled = true;
                submitBtn.textContent = 'Getting Location...';
                showLocationStatus('Capturing your location...', 'loading');

                // Get current location
                const location = await getCurrentLocation();

                // Add location data to form
                const form = e.target;

                // Remove existing hidden inputs if any
                const existingInputs = form.querySelectorAll('input[name^="location"], input[name^="latitude"], input[name^="longitude"]');
                existingInputs.forEach(input => input.remove());

                // Add new hidden inputs
                const latInput = document.createElement('input');
                latInput.type = 'hidden';
                latInput.name = 'latitude';
                latInput.value = location.latitude;
                form.appendChild(latInput);

                const lngInput = document.createElement('input');
                lngInput.type = 'hidden';
                lngInput.name = 'longitude';
                lngInput.value = location.longitude;
                form.appendChild(lngInput);

                const locInput = document.createElement('input');
                locInput.type = 'hidden';
                locInput.name = 'location';
                locInput.value = location.address;
                form.appendChild(locInput);

                showLocationStatus(`Location captured: ${location.address}`, 'success');
                showCurrentLocation(location);

                // Clear the timer when checking out
                if (timerInterval) {
                    clearInterval(timerInterval);
                }
                timeTrackerEl.textContent = "You have checked out for today.";

                // Submit the form
                submitBtn.textContent = 'Checking Out...';
                form.submit();

            } catch (error) {
                console.error('Location error:', error);
                showLocationStatus(error.message, 'error');

                // Ask user if they want to proceed without location
                const proceed = confirm(`${error.message}\n\nWould you like to check out without location data?`);
                if (proceed) {
                    // Clear timer and submit without location
                    if (timerInterval) {
                        clearInterval(timerInterval);
                    }
                    timeTrackerEl.textContent = "You have checked out for today.";

                    submitBtn.textContent = 'Checking Out...';
                    e.target.submit();
                } else {
                    // Reset button state
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                    hideLocationStatus();
                }
            }
        });
    }

    // Initialize progress circle
    updateProgressCircle();

    // Initialize geolocation on page load
    initializeGeolocation();

    // Auto-refresh dashboard every 5 minutes
    setInterval(refreshDashboardData, 300000); // 5 minutes

    // Geolocation initialization and permission handling
    function initializeGeolocation() {
        if (!navigator.geolocation) {
            showLocationStatus('Geolocation is not supported by this browser', 'error');
            return;
        }

        // Check if we have permission
        if (navigator.permissions) {
            navigator.permissions.query({name: 'geolocation'}).then(function(result) {
                if (result.state === 'granted') {
                    showLocationStatus('Location access granted', 'success');
                    setTimeout(hideLocationStatus, 3000);
                } else if (result.state === 'prompt') {
                    showLocationStatus('Location access will be requested when needed', 'info');
                    setTimeout(hideLocationStatus, 5000);
                } else if (result.state === 'denied') {
                    showLocationStatus('Location access denied. Check-in/out will work without location.', 'error');
                    setTimeout(hideLocationStatus, 8000);
                }
            }).catch(function(error) {
                console.log('Permission query not supported:', error);
            });
        }
    }

    // Enhanced location permission request
    function requestLocationPermission() {
        return new Promise((resolve, reject) => {
            if (!navigator.geolocation) {
                reject(new Error('Geolocation is not supported by this browser'));
                return;
            }

            // First try to get position to trigger permission request
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    resolve(true);
                },
                (error) => {
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            reject(new Error('Location access was denied. Please enable location access in your browser settings to use this feature.'));
                            break;
                        case error.POSITION_UNAVAILABLE:
                            reject(new Error('Location information is unavailable. Please check your device settings.'));
                            break;
                        case error.TIMEOUT:
                            reject(new Error('Location request timed out. Please try again.'));
                            break;
                        default:
                            reject(new Error('An unknown error occurred while retrieving location.'));
                            break;
                    }
                },
                {
                    enableHighAccuracy: false,
                    timeout: 5000,
                    maximumAge: 300000
                }
            );
        });
    }
});
</script>
@endpush
