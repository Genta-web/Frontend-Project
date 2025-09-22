<?php

namespace App\Services;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class LeaveNotificationService
{
    /**
     * Send approval notification to employee
     */
    public static function sendApprovalNotification(Leave $leave, string $adminMessage = ''): bool
    {
        try {
            $employee = $leave->employee;
            $approver = $leave->approvedBy;
            
            if (!$employee || !$employee->email) {
                Log::warning('Cannot send approval notification: Employee email not found', [
                    'leave_id' => $leave->id,
                    'employee_id' => $leave->employee_id
                ]);
                return false;
            }

            $data = [
                'employee_name' => $employee->name,
                'leave_type' => $leave->leave_type_display,
                'start_date' => $leave->start_date->format('d M Y'),
                'end_date' => $leave->end_date->format('d M Y'),
                'total_days' => $leave->total_days,
                'approver_name' => $approver->username ?? 'Admin',
                'approved_at' => $leave->approved_at->format('d M Y H:i'),
                'admin_message' => $adminMessage,
                'leave_details_url' => route('leave.show', $leave->id)
            ];

            // Send email notification
            Mail::send('emails.leave.approved', $data, function ($message) use ($employee, $leave) {
                $message->to($employee->email, $employee->name)
                        ->subject('Leave Request Approved - ' . $leave->leave_type_display);
            });

            // Log notification
            Log::info('Leave approval notification sent', [
                'leave_id' => $leave->id,
                'employee_email' => $employee->email,
                'admin_message_included' => !empty($adminMessage)
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send approval notification', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send rejection notification to employee
     */
    public static function sendRejectionNotification(Leave $leave, array $rejectionData = []): bool
    {
        try {
            $employee = $leave->employee;
            $rejector = $leave->approvedBy;
            
            if (!$employee || !$employee->email) {
                Log::warning('Cannot send rejection notification: Employee email not found', [
                    'leave_id' => $leave->id,
                    'employee_id' => $leave->employee_id
                ]);
                return false;
            }

            $data = [
                'employee_name' => $employee->name,
                'leave_type' => $leave->leave_type_display,
                'start_date' => $leave->start_date->format('d M Y'),
                'end_date' => $leave->end_date->format('d M Y'),
                'total_days' => $leave->total_days,
                'rejector_name' => $rejector->username ?? 'Admin',
                'rejected_at' => $leave->approved_at->format('d M Y H:i'),
                'rejection_reason' => $rejectionData['reason'] ?? $leave->admin_notes,
                'alternative_suggestions' => $rejectionData['alternative_suggestions'] ?? '',
                'follow_up_actions' => $rejectionData['follow_up_actions'] ?? [],
                'hr_contact' => config('app.hr_email', 'hr@company.com'),
                'leave_details_url' => route('leave.show', $leave->id)
            ];

            // Send email notification
            Mail::send('emails.leave.rejected', $data, function ($message) use ($employee, $leave) {
                $message->to($employee->email, $employee->name)
                        ->subject('Leave Request Update - ' . $leave->leave_type_display);
            });

            // Log notification
            Log::info('Leave rejection notification sent', [
                'leave_id' => $leave->id,
                'employee_email' => $employee->email,
                'has_alternatives' => !empty($rejectionData['alternative_suggestions']),
                'has_follow_up' => !empty($rejectionData['follow_up_actions'])
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send rejection notification', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Send bulk action notification
     */
    public static function sendBulkActionNotification(array $leaves, string $action, array $data = []): array
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        foreach ($leaves as $leave) {
            try {
                if ($action === 'approved') {
                    $success = self::sendApprovalNotification($leave, $data['admin_message'] ?? '');
                } elseif ($action === 'rejected') {
                    $success = self::sendRejectionNotification($leave, $data);
                } else {
                    $success = false;
                }

                if ($success) {
                    $results['success']++;
                } else {
                    $results['failed']++;
                }

            } catch (\Exception $e) {
                $results['failed']++;
                $results['errors'][] = [
                    'leave_id' => $leave->id,
                    'employee_name' => $leave->employee->name ?? 'Unknown',
                    'error' => $e->getMessage()
                ];
            }
        }

        return $results;
    }

    /**
     * Send admin notification for new leave request
     */
    public static function sendAdminNotification(Leave $leave): bool
    {
        try {
            // Get admin users
            $admins = User::whereIn('role', ['admin', 'hr', 'manager'])->get();
            
            if ($admins->isEmpty()) {
                Log::warning('No admin users found for leave notification');
                return false;
            }

            $data = [
                'employee_name' => $leave->employee->name ?? 'Unknown',
                'leave_type' => $leave->leave_type_display,
                'start_date' => $leave->start_date->format('d M Y'),
                'end_date' => $leave->end_date->format('d M Y'),
                'total_days' => $leave->total_days,
                'submitted_at' => $leave->created_at->format('d M Y H:i'),
                'reason' => $leave->reason,
                'leave_review_url' => route('leave.show', $leave->id),
                'leave_index_url' => route('leave.index')
            ];

            foreach ($admins as $admin) {
                if ($admin->email) {
                    Mail::send('emails.leave.admin_notification', $data, function ($message) use ($admin, $leave) {
                        $message->to($admin->email, $admin->username)
                                ->subject('New Leave Request - ' . ($leave->employee->name ?? 'Employee'));
                    });
                }
            }

            Log::info('Admin notification sent for new leave request', [
                'leave_id' => $leave->id,
                'admin_count' => $admins->count()
            ]);

            return true;

        } catch (\Exception $e) {
            Log::error('Failed to send admin notification', [
                'leave_id' => $leave->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Get notification templates
     */
    public static function getNotificationTemplates(): array
    {
        return [
            'approval' => [
                'subject' => 'Leave Request Approved - {leave_type}',
                'greeting' => 'Dear {employee_name},',
                'main_message' => 'Your {leave_type} request from {start_date} to {end_date} has been approved.',
                'closing' => 'Best regards,<br>HR Team'
            ],
            'rejection' => [
                'subject' => 'Leave Request Update - {leave_type}',
                'greeting' => 'Dear {employee_name},',
                'main_message' => 'We have reviewed your {leave_type} request from {start_date} to {end_date}.',
                'closing' => 'Please feel free to contact HR if you have any questions.<br>Best regards,<br>HR Team'
            ],
            'admin_new_request' => [
                'subject' => 'New Leave Request - {employee_name}',
                'greeting' => 'Dear Admin,',
                'main_message' => '{employee_name} has submitted a new {leave_type} request.',
                'closing' => 'Please review and take appropriate action.<br>System Notification'
            ]
        ];
    }

    /**
     * Format notification message with variables
     */
    public static function formatMessage(string $template, array $variables): string
    {
        $message = $template;
        
        foreach ($variables as $key => $value) {
            $message = str_replace('{' . $key . '}', $value, $message);
        }
        
        return $message;
    }
}
