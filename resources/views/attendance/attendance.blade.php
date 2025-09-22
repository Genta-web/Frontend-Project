@extends('layouts.app')

@section('content')
<style>
    body {
        background: #e0f7ff;
        font-family: 'Poppins', sans-serif;
    }

    .attendance-card {
        background: #fff;
        border-radius: 1rem;
        padding: 2rem;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .attendance-title {
        font-size: 1.8rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
        text-align: center;
    }

    .table th, .table td {
        vertical-align: middle;
        font-size: 0.95rem;
    }

    .badge {
        font-size: 0.85rem;
        border-radius: 0.5rem;
        padding: 0.35rem 0.75rem;
    }

    .badge-present { background-color: #4CAF50; color: white; }
    .badge-sick { background-color: #FFC107; color: white; }
    .badge-leave { background-color: #17A2B8; color: white; }
    .badge-absent { background-color: #DC3545; color: white; }
</style>

<div class="container py-4">
    <div class="attendance-card">
        <h3 class="attendance-title">Attendance Records</h3>

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Attachment</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $index => $attendance)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $attendance->employee->name ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($attendance->date)->format('d M Y') }}</td>
                            <td>{{ $attendance->check_in ?? '-' }}</td>
                            <td>{{ $attendance->check_out ?? '-' }}</td>
                            <td>
                                <span class="badge badge-{{ $attendance->status }}">
                                    {{ ucfirst($attendance->status) }}
                                </span>
                            </td>
                            <td>{{ $attendance->notes ?? '-' }}</td>
                            <td>
                                @if($attendance->attachment_image)
                                    <a href="{{ asset('storage/' . $attendance->attachment_image) }}" target="_blank">View</a>
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">No attendance records found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
