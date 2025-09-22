<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Jobs Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #fa709a;
            padding-bottom: 20px;
        }
        .header h1 {
            color: #fa709a;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .summary-section {
            margin-bottom: 30px;
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 5px;
        }
        .summary-grid {
            display: table;
            width: 100%;
        }
        .summary-row {
            display: table-row;
        }
        .summary-cell {
            display: table-cell;
            padding: 8px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 11px;
        }
        .summary-cell.header {
            background-color: #fa709a;
            color: white;
            font-weight: bold;
        }
        .summary-cell.value {
            background-color: white;
            font-weight: bold;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 6px;
            text-align: left;
            font-size: 10px;
        }
        th {
            background-color: #fa709a;
            color: white;
            font-weight: bold;
        }
        .status-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-in_progress { background-color: #cce7ff; color: #004085; }
        .status-completed { background-color: #d4edda; color: #155724; }
        .status-cancelled { background-color: #f8d7da; color: #721c24; }
        .priority-badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9px;
            font-weight: bold;
        }
        .priority-low { background-color: #e2e3e5; color: #383d41; }
        .priority-medium { background-color: #fff3cd; color: #856404; }
        .priority-high { background-color: #f5c6cb; color: #721c24; }
        .priority-urgent { background-color: #dc3545; color: white; }
        .progress-bar {
            width: 50px;
            height: 8px;
            background-color: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background-color: #28a745;
        }
        .overdue {
            background-color: #fff3cd !important;
        }
        .statistics {
            margin-top: 30px;
            display: table;
            width: 100%;
        }
        .stat-row {
            display: table-row;
        }
        .stat-cell {
            display: table-cell;
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            background-color: #f8f9fa;
        }
        .stat-value {
            font-size: 16px;
            font-weight: bold;
            color: #fa709a;
        }
        .stat-label {
            font-size: 11px;
            color: #666;
            margin-top: 5px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Jobs Report</h1>
        <p>Period: <?php echo e($startDate->format('M d, Y')); ?> - <?php echo e($endDate->format('M d, Y')); ?></p>
        <p>Generated on: <?php echo e(now()->format('M d, Y H:i')); ?></p>
    </div>

    <!-- Summary Section -->
    <div class="summary-section">
        <h3 style="margin-top: 0; color: #fa709a;">Jobs Summary</h3>
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell header">Total Jobs</div>
                <div class="summary-cell header">Pending</div>
                <div class="summary-cell header">In Progress</div>
                <div class="summary-cell header">Completed</div>
                <div class="summary-cell header">Overdue</div>
                <div class="summary-cell header">Avg Progress</div>
            </div>
            <div class="summary-row">
                <div class="summary-cell value"><?php echo e($data['summary']['total_jobs']); ?></div>
                <div class="summary-cell value"><?php echo e($data['summary']['pending']); ?></div>
                <div class="summary-cell value"><?php echo e($data['summary']['in_progress']); ?></div>
                <div class="summary-cell value"><?php echo e($data['summary']['completed']); ?></div>
                <div class="summary-cell value"><?php echo e($data['summary']['overdue']); ?></div>
                <div class="summary-cell value"><?php echo e(number_format($data['summary']['average_progress'], 1)); ?>%</div>
            </div>
        </div>
    </div>

    <!-- Jobs Records Table -->
    <?php if($data['jobs']->count() > 0): ?>
    <h3 style="color: #fa709a; border-bottom: 1px solid #fa709a; padding-bottom: 5px;">Job Records</h3>
    <table>
        <thead>
            <tr>
                <th>Job Title</th>
                <th>Employee</th>
                <th>Priority</th>
                <th>Status</th>
                <th>Progress</th>
                <th>Start Date</th>
                <th>Due Date</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php $__currentLoopData = $data['jobs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="<?php echo e(($job->due_date && $job->due_date < now() && $job->job_status !== 'completed') ? 'overdue' : ''); ?>">
                <td>
                    <div style="font-weight: bold;"><?php echo e(\Illuminate\Support\Str::limit($job->name ?? 'N/A', 25)); ?></div>
                    <?php if($job->due_date && $job->due_date < now() && $job->job_status !== 'completed'): ?>
                        <div style="font-size: 8px; color: #dc3545;">⚠ Overdue</div>
                    <?php endif; ?>
                </td>
                <td>
                    <div style="font-weight: bold;"><?php echo e($job->employee->name ?? 'N/A'); ?></div>
                    <div style="font-size: 8px; color: #666;"><?php echo e($job->employee->employee_code ?? 'N/A'); ?></div>
                </td>
                <td>
                    <span class="priority-badge priority-<?php echo e($job->priority); ?>">
                        <?php echo e(ucfirst($job->priority)); ?>

                    </span>
                </td>
                <td>
                    <span class="status-badge status-<?php echo e($job->job_status); ?>">
                        <?php echo e(ucfirst(str_replace('_', ' ', $job->job_status))); ?>

                    </span>
                </td>
                <td>
                    <div style="display: flex; align-items: center;">
                        <div class="progress-bar">
                            <div class="progress-fill" style="width: <?php echo e($job->progress_percentage); ?>%;
                                <?php if($job->progress_percentage >= 100): ?> background-color: #28a745;
                                <?php elseif($job->progress_percentage >= 75): ?> background-color: #17a2b8;
                                <?php elseif($job->progress_percentage >= 50): ?> background-color: #ffc107;
                                <?php else: ?> background-color: #dc3545;
                                <?php endif; ?>"></div>
                        </div>
                        <span style="margin-left: 5px; font-size: 8px;"><?php echo e($job->progress_percentage); ?>%</span>
                    </div>
                </td>
                <td>
                    <?php echo e($job->start_date ? \Carbon\Carbon::parse($job->start_date)->format('M d, Y') : '-'); ?>

                </td>
                <td style="<?php echo e(($job->due_date && $job->due_date < now() && $job->job_status !== 'completed') ? 'color: #dc3545; font-weight: bold;' : ''); ?>">
                    <?php echo e($job->due_date ? \Carbon\Carbon::parse($job->due_date)->format('M d, Y') : '-'); ?>

                </td>
                <td><?php echo e($job->description ? \Illuminate\Support\Str::limit($job->description, 40) : '-'); ?></td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>

    <!-- Statistics -->
    <div class="statistics">
        <div class="stat-row">
            <div class="stat-cell">
                <div class="stat-value">
                    <?php echo e($data['summary']['total_jobs'] > 0 ? number_format(($data['summary']['completed'] / $data['summary']['total_jobs']) * 100, 1) : 0); ?>%
                </div>
                <div class="stat-label">Completion Rate</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    <?php echo e($data['jobs']->whereIn('priority', ['high', 'urgent'])->count()); ?>

                </div>
                <div class="stat-label">High/Urgent Priority</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    <?php echo e($data['jobs']->groupBy('employee_id')->count()); ?>

                </div>
                <div class="stat-label">Active Employees</div>
            </div>
            <div class="stat-cell">
                <div class="stat-value">
                    <?php echo e($data['summary']['total_jobs'] > 0 ? number_format(($data['summary']['overdue'] / $data['summary']['total_jobs']) * 100, 1) : 0); ?>%
                </div>
                <div class="stat-label">Overdue Rate</div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div style="text-align: center; padding: 50px; color: #666;">
        <h3>No jobs found</h3>
        <p>No job data available for the selected period.</p>
    </div>
    <?php endif; ?>

    <div class="footer">
        <p>Employee Management System - Jobs Report | Generated on <?php echo e(now()->format('M d, Y H:i')); ?></p>
    </div>
</body>
</html>
<?php /**PATH D:\backoffice-fasya\resources\views/reports/pdf/jobs.blade.php ENDPATH**/ ?>