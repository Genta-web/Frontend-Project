@extends('layouts.admin')

@section('title', 'Leave Management')

@push('styles')
<style>
    :root {
        --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        --warning-gradient: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        --danger-gradient: linear-gradient(135deg, #ff6b6b 0%, #ee5a24 100%);
        --info-gradient: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);

        --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        --card-shadow-hover: 0 20px 40px rgba(0, 0, 0, 0.15);
        --border-radius: 15px;
        --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    /* Modern Layout */
    .leave-dashboard-container {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        min-height: calc(100vh - 120px);
        border-radius: var(--border-radius);
        margin: 1rem;
        padding: 2rem;
    }

    .dashboard-header {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: var(--card-shadow);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .dashboard-header h1 {
        background: var(--primary-gradient);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        font-size: 2rem;
        font-weight: 700;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 1rem;
    }

    .btn-modern {
        background: var(--primary-gradient);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 25px;
        font-weight: 600;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
        box-shadow: var(--card-shadow-hover);
        color: white;
        text-decoration: none;
    }

    /* Modern Statistics Cards */
    .leave-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-item {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--card-shadow);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .stat-item:hover {
        transform: translateY(-5px);
        box-shadow: var(--card-shadow-hover);
    }

    .stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: var(--gradient);
    }

    .stat-item.total::before { background: var(--primary-gradient); }
    .stat-item.approved::before { background: var(--success-gradient); }
    .stat-item.rejected::before { background: var(--danger-gradient); }
    .stat-item.pending::before { background: var(--warning-gradient); }

    .stat-content {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .stat-icon {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        color: white;
        flex-shrink: 0;
    }

    .stat-icon.total { background: var(--primary-gradient); }
    .stat-icon.approved { background: var(--success-gradient); }
    .stat-icon.rejected { background: var(--danger-gradient); }
    .stat-icon.pending { background: var(--warning-gradient); }

    .stat-info h3 {
        font-size: 2.5rem;
        font-weight: 700;
        margin: 0;
        color: #2d3748;
    }

    .stat-info p {
        font-size: 1rem;
        color: #718096;
        margin: 0.5rem 0 0 0;
        font-weight: 500;
    }

    .stat-trend {
        font-size: 0.875rem;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .trend-up { color: #48bb78; }
    .trend-down { color: #f56565; }

    /* Modern Calendar Section */
    .calendar-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--card-shadow);
        margin-bottom: 2rem;
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f7fafc;
    }

    .calendar-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .time-toggle {
        display: flex;
        background: #f7fafc;
        border-radius: 25px;
        padding: 0.25rem;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
    }

    .time-toggle button {
        background: transparent;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 20px;
        cursor: pointer;
        font-weight: 600;
        color: #718096;
        transition: var(--transition);
        position: relative;
    }

    .time-toggle button.active {
        background: var(--primary-gradient);
        color: white;
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        transform: translateY(-1px);
    }
        .calendar-legend { display: flex; flex-wrap: wrap; gap: 1.5rem; margin-top: 1.5rem; font-size: 0.8rem; }
        .legend-item { display: flex; align-items: center; gap: 0.5rem; }
        .legend-item .color-box { width: 12px; height: 12px; border-radius: 2px; }

        /* Calendar Views */
        .calendar-view { display: none; } /* Sembunyikan semua view secara default */
        .calendar-view.active { display: grid; } /* Tampilkan view yang aktif */

        /* Week View */
        .calendar-week-view { grid-template-columns: repeat(7, 1fr); border-top: 1px solid var(--border-color); border-left: 1px solid var(--border-color); }
        .calendar-day { padding: 0.75rem; border-right: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); min-height: 100px; }
        .day-header { display: flex; justify-content: space-between; font-size: 0.75rem; color: var(--text-secondary); margin-bottom: 0.5rem; font-weight: 600; }
        .event { padding: 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; margin-top: 0.5rem; color: var(--text-dark); }
        .event.green { background-color: var(--color-green-light); border-left: 3px solid var(--color-green); }
        .event.yellow { background-color: var(--color-yellow-light); border-left: 3px solid var(--color-yellow); }
        .event.blue { background-color: var(--color-blue-light); border-left: 3px solid var(--color-blue); }
        .event.public-holiday { font-weight: 500; color: var(--primary-red); }

        /* Month View */
        .calendar-month-view { grid-template-columns: repeat(7, 1fr); }
        .month-day-header { text-align: center; padding: 0.75rem 0; font-weight: 600; font-size: 0.8rem; color: var(--text-secondary); border-bottom: 1px solid var(--border-color); }
        .month-day-cell { border-right: 1px solid var(--border-color); border-bottom: 1px solid var(--border-color); padding: 0.5rem; min-height: 80px; font-size: 0.8rem; }
        .month-day-cell:nth-child(7n) { border-right: none; }
        .day-number { font-weight: 500; }
        .day-number.other-month { color: var(--text-secondary); opacity: 0.5; }
        .event-dots { display: flex; gap: 4px; margin-top: 4px; }
        .event-dot { width: 6px; height: 6px; border-radius: 50%; }

        /* Year View */
        .calendar-year-view { grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; }
        .mini-month { border: 1px solid var(--border-color); border-radius: 0.5rem; padding: 1rem; }
        .mini-month-header { text-align: center; font-weight: 600; margin-bottom: 1rem; }
        .mini-month-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
        .mini-day-cell { width: 100%; padding-bottom: 100%; /* trick for square cells */ background-color: #F3F4F6; border-radius: 2px; }
        .mini-day-cell.has-event { background-color: var(--color-blue-light); }

        /* Right Column (Team Availability) */
        .right-column { display: flex; flex-direction: column; gap: 2rem; }
        .info-card { background-color: var(--bg-white); border: 1px solid var(--border-color); border-radius: 0.75rem; padding: 1.5rem; }
        .info-card h2 { font-size: 1.125rem; font-weight: 600; margin-bottom: 1rem; }
        .info-list { list-style: none; }
        .info-list li { display: flex; align-items: center; justify-content: space-between; padding: 0.75rem 0; border-bottom: 1px solid var(--border-color); }
        .info-list li:last-child { border-bottom: none; }
        .user-info { display: flex; align-items: center; gap: 0.75rem; }
        .user-info img { width: 40px; height: 40px; border-radius: 50%; }
        .user-info .name { font-weight: 500; }
        .user-info .leave-type { font-size: 0.75rem; color: var(--text-secondary); }
        .status-badge { font-size: 0.75rem; font-weight: 500; padding: 0.25rem 0.75rem; border-radius: 999px; }
        .status-badge.available { background-color: var(--color-green-light); color: var(--color-green); }
        .holiday-date { color: var(--text-secondary); }
        .holiday-list-container { max-height: 300px; overflow-y: auto; }

    /* Modern Leave Approval Section */
    .leave-approval-section {
        background: white;
        border-radius: var(--border-radius);
        padding: 2rem;
        box-shadow: var(--card-shadow);
        margin-top: 2rem;
    }

    .approval-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid #f7fafc;
    }

    .approval-header h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2d3748;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .pending-badge {
        background: var(--warning-gradient);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .modern-table-container {
        background: #f8fafc;
        border-radius: var(--border-radius);
        padding: 1rem;
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
    }

    .modern-table th {
        background: var(--primary-gradient);
        color: white;
        padding: 1rem;
        text-align: left;
        font-weight: 600;
        font-size: 0.875rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .modern-table th:first-child { border-radius: 10px 0 0 0; }
    .modern-table th:last-child { border-radius: 0 10px 0 0; }

    .modern-table td {
        padding: 1.25rem 1rem;
        border-bottom: 1px solid #e2e8f0;
        font-size: 0.875rem;
        color: #4a5568;
    }

    .modern-table tbody tr:hover {
        background: #f7fafc;
        transition: var(--transition);
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    .employee-info {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .employee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: var(--primary-gradient);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 0.875rem;
    }

    .employee-details h4 {
        margin: 0;
        font-weight: 600;
        color: #2d3748;
        font-size: 0.875rem;
    }

    .employee-details p {
        margin: 0;
        color: #718096;
        font-size: 0.75rem;
    }

    .leave-type-badge {
        background: var(--info-gradient);
        color: white;
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-block;
    }

    .date-range {
        font-weight: 600;
        color: #4a5568;
    }

    .reason-text {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Modern Action Buttons */
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

    .action-btn {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.75rem;
        cursor: pointer;
        transition: var(--transition);
        border: none;
        display: flex;
        align-items: center;
        gap: 0.25rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .action-btn.approve {
        background: var(--success-gradient);
        color: white;
    }

    .action-btn.approve:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(79, 172, 254, 0.4);
    }

    .action-btn.deny {
        background: var(--danger-gradient);
        color: white;
    }

    .action-btn.deny:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(255, 107, 107, 0.4);
    }

    .action-btn.view {
        background: var(--info-gradient);
        color: white;
    }

    .action-btn.view:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(168, 237, 234, 0.4);
    }

        /* Responsive adjustments for the table */
        @media (max-width: 768px) {
            .main-content-grid {
                grid-template-columns: 1fr; /* Stack columns on smaller screens */
            }
            .leave-dashboard-container {
                padding: 1.5rem;
            }
            .leave-stats {
                flex-wrap: wrap;
            }
            .stat-item {
                flex-basis: calc(50% - 1rem); /* Two items per row */
            }
            .leave-approval-table-container {
                overflow-x: scroll; /* Allow horizontal scrolling for table */
            }
            .leave-approval-table {
                min-width: 600px; /* Ensure table doesn't get too squished */
            }
        }

        @media (max-width: 480px) {
            .stat-item {
                flex-basis: 100%; /* One item per row on very small screens */
            }
        }

</style>
@endpush

@section('content')
<div class="leave-dashboard-container">
    <header class="dashboard-header">
        <div>
            <h1><i class="fas fa-calendar-alt me-2"></i>Leave Management</h1>
            <p class="text-muted mb-0">Manage employee leave requests and approvals</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('leave.create') }}" class="btn-modern">
                <i class="fas fa-plus"></i>
                New Request
            </a>
            <a href="{{ route('leave.index') }}" class="btn-modern" style="background: var(--success-gradient);">
                <i class="fas fa-list"></i>
                View All
            </a>
        </div>
    </header>

    <section class="leave-stats">
        <div class="stat-item total">
            <div class="stat-content">
                <div class="stat-icon total">
                    <i class="fas fa-clipboard-list"></i>
                </div>
                <div class="stat-info">
                    <h3>53</h3>
                    <p>Total Requests</p>
                    <div class="stat-trend trend-up">
                        <i class="fas fa-arrow-up"></i>
                        +12% from last month
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-item approved">
            <div class="stat-content">
                <div class="stat-icon approved">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>40</h3>
                    <p>Approved</p>
                    <div class="stat-trend trend-up">
                        <i class="fas fa-arrow-up"></i>
                        +8% approval rate
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-item rejected">
            <div class="stat-content">
                <div class="stat-icon rejected">
                    <i class="fas fa-times-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>3</h3>
                    <p>Rejected</p>
                    <div class="stat-trend trend-down">
                        <i class="fas fa-arrow-down"></i>
                        -2% rejection rate
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-item pending">
            <div class="stat-content">
                <div class="stat-icon pending">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>15</h3>
                    <p>Pending</p>
                    <div class="stat-trend">
                        <i class="fas fa-exclamation-triangle text-warning"></i>
                        Needs attention
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="calendar-section">
        <div class="calendar-header">
            <h2>
                <i class="fas fa-calendar me-2 text-primary"></i>
                Leave Calendar
            </h2>
            <div class="time-toggle">
                <button data-view="week" class="active">
                    <i class="fas fa-calendar-week me-1"></i>
                    Week
                </button>
                <button data-view="month">
                    <i class="fas fa-calendar-alt me-1"></i>
                    Month
                </button>
                <button data-view="year">
                    <i class="fas fa-calendar me-1"></i>
                    Year
                </button>
            </div>
        </div>

            <div id="calendar-views">
                <div id="week-view" class="calendar-view active calendar-week-view">
                    <div class="calendar-day">
                        <div class="day-header"><span>SUN</span><span>26</span></div>
                        <div class="event green">Benny Chagur <br> Annual Leave</div>
                    </div>
                    <div class="calendar-day">
                        <div class="day-header"><span>MON</span><span>27</span></div>
                    </div>
                    <div class="calendar-day"><div class="day-header"><span>TUE</span><span>28</span></div><div class="event green">Lisa Annual leave from 28th to 29th</div></div>
                    <div class="calendar-day"><div class="day-header"><span>WED</span><span>29</span></div><div class="event green">Lisa Annual leave from 28th to 29th</div><div class="event yellow">Sarah HR Sick Leave</div></div>
                    <div class="calendar-day"><div class="day-header"><span>THU</span><span>30</span></div><div class="event yellow">Michael Emergency Leave for 1 day</div></div>
                    <div class="calendar-day"><div class="day-header"><span>FRI</span><span>01</span></div><p class="event public-holiday">Public Holiday: Chinese New Year</p></div>
                    <div class="calendar-day"><div class="day-header"><span>SAT</span><span>02</span></div></div>
                </div>

                <div id="month-view" class="calendar-view calendar-month-view">
                    <div class="month-day-header">SUN</div>
                    <div class="month-day-header">MON</div>
                    <div class="month-day-header">TUE</div>
                    <div class="month-day-header">WED</div>
                    <div class="month-day-header">THU</div>
                    <div class="month-day-header">FRI</div>
                    <div class="month-day-header">SAT</div>
                    {{-- Contoh Statis untuk satu bulan --}}
                    <div class="month-day-cell"><span class="day-number other-month">26</span></div>
                    <div class="month-day-cell"><span class="day-number other-month">27</span></div>
                    <div class="month-day-cell"><span class="day-number other-month">28</span></div>
                    <div class="month-day-cell"><span class="day-number other-month">29</span></div>
                    <div class="month-day-cell"><span class="day-number other-month">30</span></div>
                    <div class="month-day-cell"><span class="day-number">1</span><div class="event-dots"><div class="event-dot" style="background:var(--primary-red)"></div></div></div>
                    <div class="month-day-cell"><span class="day-number">2</span></div>
                    <div class="month-day-cell"><span class="day-number">3</span><div class="event-dots"><div class="event-dot" style="background:var(--color-green)"></div></div></div>
                    <div class="month-day-cell"><span class="day-number">4</span></div>
                    <div class="month-day-cell"><span class="day-number">5</span><div class="event-dots"><div class="event-dot" style="background:var(--color-yellow)"></div><div class="event-dot" style="background:var(--color-blue)"></div></div></div>
                    {{-- Ulangi untuk sisa hari... --}}
                    @for ($i = 6; $i <= 35; $i++)
                        <div class="month-day-cell"><span class="day-number">{{ $i <= 31 ? $i : $i-31 }}</span> @if($i > 31) <span class="day-number other-month"></span> @endif </div>
                    @endfor
                </div>

                <div id="year-view" class="calendar-view calendar-year-view">
                    {{-- Contoh Statis untuk beberapa bulan --}}
                    @foreach (['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'] as $month)
                    <div class="mini-month">
                        <div class="mini-month-header">{{ $month }}</div>
                        <div class="mini-month-grid">
                            @for ($i = 0; $i < 35; $i++)
                                <div class="mini-day-cell {{ rand(0,5) == 1 ? 'has-event' : '' }}"></div>
                            @endfor
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="calendar-legend">
                <div class="legend-item"><span class="color-box" style="background-color: var(--color-green);"></span> Annual Leave</div>
                <div class="legend-item"><span class="color-box" style="background-color: var(--color-yellow);"></span> Sick Leave</div>
                <div class="legend-item"><span class="color-box" style="background-color: var(--color-grey);"></span> Others Leave</div>
                <div class="legend-item"><span class="color-box" style="background-color: var(--primary-red);"></span> Public Holiday</div>
            </div>
        </section>


    {{-- Bagian Leave Approval (yang diubah menjadi dinamis) --}}
    <section class="leave-approval-section">
        <div class="approval-header">
            <h2>
                <i class="fas fa-tasks me-2 text-primary"></i>
                Pending Leave Requests
            </h2>
            @if(isset($pending_leaves) && $pending_leaves->count() > 0)
                <div class="pending-badge">
                    <i class="fas fa-bell"></i>
                    {{ $pending_leaves->count() }}
                </div>
            @endif
        </div>

        <div class="modern-table-container">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Leave Type</th>
                        <th>Date Range</th>
                        <th>Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Loop untuk menampilkan setiap pengajuan cuti yang pending --}}
                    @forelse ($pending_leaves as $leave)
                        <tr>
                            <td>
                                <div class="employee-info">
                                    <div class="employee-avatar">
                                        {{-- Inisial nama karyawan --}}
                                        {{ strtoupper(substr($leave->user->name, 0, 2)) }}
                                    </div>
                                    <div class="employee-details">
                                        <h4>{{ $leave->user->name }}</h4>
                                        <p>{{ $leave->user->department->name ?? 'No Department' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="leave-type-badge">{{ $leave->leaveType->name }}</span>
                            </td>
                            <td class="date-range">
                                {{ \Carbon\Carbon::parse($leave->start_date)->format('d M Y') }} - {{ \Carbon\Carbon::parse($leave->end_date)->format('d M Y') }}
                            </td>
                            <td>
                                <p class="reason-text" title="{{ $leave->reason }}">{{ $leave->reason }}</p>
                            </td>
                            <td>
                                <div class="action-buttons">
                                    {{-- Tombol Approve --}}
                                    <form action="{{ route('leave.approve', $leave->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn approve" style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="display: flex; align-items: center; justify-content: center; width: 22px; height: 22px;">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            <span>Approve</span>
                                        </button>
                                    </form>

                                    {{-- Tombol Reject --}}
                                    <form action="{{ route('leave.reject', $leave->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="action-btn deny" style="display: flex; align-items: center; gap: 0.5rem;">
                                            <span style="display: flex; align-items: center; justify-content: center; width: 22px; height: 22px;">
                                                <i class="fas fa-times"></i>
                                            </span>
                                            <span>Reject</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        {{-- Pesan jika tidak ada pengajuan cuti yang pending --}}
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                                <h4 class="mb-0">All leave requests have been processed.</h4>
                                <p class="text-muted">No pending requests at the moment.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Calendar view toggle functionality
    const timeToggleButtons = document.querySelectorAll('.time-toggle button');
    const calendarViews = document.querySelectorAll('.calendar-view');

    timeToggleButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            timeToggleButtons.forEach(btn => btn.classList.remove('active'));
            // Add active class to clicked button
            this.classList.add('active');

            // Get target view from data-view attribute
            const targetViewId = this.getAttribute('data-view') + '-view';

            // Hide all calendar views
            calendarViews.forEach(view => {
                view.classList.remove('active');
            });

            // Show target view
            const targetView = document.getElementById(targetViewId);
            if(targetView) {
                targetView.classList.add('active');
            }
        });
    });

    // Action button animations
    // Note: The form will submit, but the animation will still trigger on click.
    const actionButtons = document.querySelectorAll('.action-btn');
    actionButtons.forEach(button => {
        button.addEventListener('mousedown', function(e) {
            // Add click animation
            this.style.transform = 'scale(0.95)';
        });
        button.addEventListener('mouseup', function(e) {
            // Reset animation
             this.style.transform = '';
        });
        button.addEventListener('mouseleave', function(e) {
            // Also reset animation if mouse leaves button while pressed
             this.style.transform = '';
        });
    });

    // Auto-hide alerts after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (typeof bootstrap !== 'undefined' && bootstrap.Alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});
</script>
@endpush
