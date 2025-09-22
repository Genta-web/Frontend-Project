<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Update</title>
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
            border-bottom: 2px solid #dc3545;
        }
        .warning-icon {
            font-size: 48px;
            color: #dc3545;
            margin-bottom: 10px;
        }
        .title {
            color: #dc3545;
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
            background: #f8d7da;
            border: 1px solid #f5c6cb;
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
        .rejection-reason {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .rejection-reason-title {
            font-weight: bold;
            color: #856404;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .alternatives {
            background: #d1ecf1;
            border: 1px solid #bee5eb;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .alternatives-title {
            font-weight: bold;
            color: #0c5460;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .follow-up {
            background: #e2e3e5;
            border: 1px solid #d6d8db;
            border-radius: 8px;
            padding: 20px;
            margin: 20px 0;
        }
        .follow-up-title {
            font-weight: bold;
            color: #383d41;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .action-button {
            display: inline-block;
            background: #007bff;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px 5px;
        }
        .action-button.secondary {
            background: #6c757d;
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
        .support-section {
            margin-top: 25px;
            padding: 20px;
            background: #e3f2fd;
            border-radius: 8px;
            border-left: 4px solid #2196f3;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <div class="warning-icon">📋</div>
            <h1 class="title">Leave Request Update</h1>
        </div>

        <div class="content">
            <div class="greeting">Dear {{ $employee_name }},</div>

            <div class="main-message">
                We have reviewed your {{ $leave_type }} request from {{ $start_date }} to {{ $end_date }}.
                After careful consideration, we are unable to approve your request at this time.
            </div>

            <table class="details-table">
                <tr>
                    <th>Leave Type</th>
                    <td>{{ $leave_type }}</td>
                </tr>
                <tr>
                    <th>Requested Dates</th>
                    <td>{{ $start_date }} to {{ $end_date }}</td>
                </tr>
                <tr>
                    <th>Total Days</th>
                    <td>{{ $total_days }} day(s)</td>
                </tr>
                <tr>
                    <th>Reviewed By</th>
                    <td>{{ $rejector_name }}</td>
                </tr>
                <tr>
                    <th>Review Date</th>
                    <td>{{ $rejected_at }}</td>
                </tr>
            </table>

            <div class="rejection-reason">
                <div class="rejection-reason-title">📝 Reason for Decision:</div>
                <div>{{ $rejection_reason }}</div>
            </div>

            @if(!empty($alternative_suggestions))
            <div class="alternatives">
                <div class="alternatives-title">💡 Alternative Suggestions:</div>
                <div>{{ $alternative_suggestions }}</div>
            </div>
            @endif

            @if(!empty($follow_up_actions) && count($follow_up_actions) > 0)
            <div class="follow-up">
                <div class="follow-up-title">📋 Recommended Next Steps:</div>
                <ul style="margin: 0; padding-left: 20px;">
                    @foreach($follow_up_actions as $action)
                        <li>
                            @if($action === 'schedule_meeting')
                                Schedule a meeting to discuss alternatives
                            @elseif($action === 'request_documents')
                                Provide additional documentation
                            @elseif($action === 'coordinate_team')
                                Coordinate with team for alternative dates
                            @else
                                {{ ucfirst(str_replace('_', ' ', $action)) }}
                            @endif
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div style="text-align: center; margin: 30px 0;">
                <a href="{{ $leave_details_url }}" class="action-button">View Request Details</a>
                <a href="mailto:{{ $hr_contact }}" class="action-button secondary">Contact HR</a>
            </div>

            <div class="support-section">
                <strong>🤝 We're Here to Help</strong><br>
                We understand this may be disappointing. Please don't hesitate to:
                <ul style="margin: 10px 0; padding-left: 20px;">
                    <li>Contact HR to discuss alternative options</li>
                    <li>Schedule a meeting with your supervisor</li>
                    <li>Submit a new request with different dates</li>
                    <li>Provide additional information if needed</li>
                </ul>
                
                <div style="margin-top: 15px;">
                    <strong>Contact Information:</strong><br>
                    📧 Email: {{ $hr_contact }}<br>
                    📞 HR Department: [Phone Number]<br>
                    🕒 Office Hours: Monday - Friday, 9:00 AM - 5:00 PM
                </div>
            </div>

            <div style="margin-top: 25px; padding: 15px; background: #fff3cd; border-radius: 8px; border-left: 4px solid #ffc107;">
                <strong>💼 Company Policy Reminder:</strong><br>
                Please ensure future leave requests are submitted with adequate notice and include all required documentation. 
                This helps us process your requests more efficiently.
            </div>
        </div>

        <div class="footer">
            <p>Best regards,<br>
            <strong>HR Team</strong><br>
            {{ config('app.name', 'Company Name') }}</p>
            
            <div class="company-info">
                This is an automated notification from the Leave Management System.<br>
                Please do not reply to this email. For assistance, contact HR directly.
            </div>
        </div>
    </div>
</body>
</html>
