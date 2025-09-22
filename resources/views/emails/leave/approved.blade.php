<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Approved</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .email-container {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #28a745;
        }
        .success-icon {
            font-size: 48px;
            color: #28a745;
            margin-bottom: 10px;
        }
        .title {
            color: #28a745;
            font-size: 24px;
            font-weight: bold;
            margin: 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .greeting {
            font-size: 18px;
            margin-bottom: 20px;
            color: #2c3e50;
        }
        .main-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background: #f8f9fa;
            border-radius: 8px;
            overflow: hidden;
        }
        .details-table th,
        .details-table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }
        .details-table th {
            background: #e9ecef;
            font-weight: bold;
            color: #495057;
        }
        .admin-message {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 15px;
            margin: 20px 0;
        }
        .admin-message-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 10px;
        }
        .action-button {
            display: inline-block;
            background: #28a745;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 14px;
        }
        .company-info {
            margin-top: 20px;
            font-size: 12px;
            color: #adb5bd;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="success-icon">✅</div>
            <h1 class="title">Leave Request Approved!</h1>
        </div>

        <div class="content">
            <div class="greeting">Dear {{ $employee_name }},</div>

            <div class="main-message">
                <strong>Great news!</strong> Your {{ $leave_type }} request has been approved by {{ $approver_name }}.
            </div>

            <table class="details-table">
                <tr>
                    <th>Leave Type</th>
                    <td>{{ $leave_type }}</td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td>{{ $start_date }}</td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td>{{ $end_date }}</td>
                </tr>
                <tr>
                    <th>Total Days</th>
                    <td>{{ $total_days }} day(s)</td>
                </tr>
                <tr>
                    <th>Approved By</th>
                    <td>{{ $approver_name }}</td>
                </tr>
                <tr>
                    <th>Approved On</th>
                    <td>{{ $approved_at }}</td>
                </tr>
            </table>

            @if(!empty($admin_message))
            <div class="admin-message">
                <div class="admin-message-title">📝 Message from {{ $approver_name }}:</div>
                <div>{{ $admin_message }}</div>
            </div>
            @endif

            <div style="margin: 25px 0;">
                <strong>Next Steps:</strong>
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Ensure proper handover of your responsibilities</li>
                    <li>Coordinate with your team members</li>
                    <li>Update your calendar and out-of-office message</li>
                    <li>Complete any pending urgent tasks</li>
                </ul>
            </div>

            <div style="text-align: center;">
                <a href="{{ $leave_details_url }}" class="action-button">View Leave Details</a>
            </div>

            <div style="margin-top: 25px; padding: 15px; background: #e3f2fd; border-radius: 8px;">
                <strong>📞 Need Help?</strong><br>
                If you have any questions about your approved leave, please contact:
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Your direct supervisor</li>
                    <li>HR Department</li>
                    <li>Email: hr@company.com</li>
                </ul>
            </div>
        </div>

        <div class="footer">
            <p>Best regards,<br>
            <strong>HR Team</strong><br>
            {{ config('app.name', 'Company Name') }}</p>
            
            <div class="company-info">
                This is an automated notification from the Leave Management System.<br>
                Please do not reply to this email.
            </div>
        </div>
    </div>
</body>
</html>
