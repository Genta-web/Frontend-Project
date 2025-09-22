<?php

namespace App\Services;

class LeaveResponseTemplateService
{
    /**
     * Get approval templates
     */
    public static function getApprovalTemplates(): array
    {
        return [
            'standard' => [
                'title' => 'Standard Approval',
                'message' => 'Your leave request has been approved. Please ensure proper handover of your responsibilities before your leave begins.',
                'category' => 'approval'
            ],
            'conditional' => [
                'title' => 'Conditional Approval',
                'message' => 'Your leave request has been approved with the following conditions: Please coordinate with your team lead and ensure all pending tasks are completed or properly delegated.',
                'category' => 'approval'
            ],
            'early_approval' => [
                'title' => 'Early Approval',
                'message' => 'Your leave request has been approved earlier than usual due to good planning and advance notice. Thank you for your professionalism.',
                'category' => 'approval'
            ],
            'urgent_approved' => [
                'title' => 'Urgent Leave Approved',
                'message' => 'Your urgent leave request has been approved. We understand the circumstances and hope everything works out well for you.',
                'category' => 'approval'
            ],
            'partial_approval' => [
                'title' => 'Partial Approval',
                'message' => 'Your leave request has been partially approved. Please contact HR to discuss the modified dates and duration.',
                'category' => 'approval'
            ]
        ];
    }

    /**
     * Get rejection templates
     */
    public static function getRejectionTemplates(): array
    {
        return [
            'insufficient_notice' => [
                'title' => 'Insufficient Notice Period',
                'message' => 'Your leave request cannot be approved due to insufficient notice period. Please submit your request at least [X] days in advance as per company policy.',
                'category' => 'rejection'
            ],
            'peak_period' => [
                'title' => 'Peak Business Period',
                'message' => 'Unfortunately, your leave request coincides with our peak business period. We need all hands on deck during this time. Please consider rescheduling your leave.',
                'category' => 'rejection'
            ],
            'staffing_shortage' => [
                'title' => 'Staffing Shortage',
                'message' => 'Your leave request cannot be approved due to current staffing shortage in your department. Please coordinate with your team and resubmit when coverage is available.',
                'category' => 'rejection'
            ],
            'conflicting_requests' => [
                'title' => 'Conflicting Leave Requests',
                'message' => 'Multiple team members have requested leave for the same period. Please coordinate with your colleagues and submit alternative dates.',
                'category' => 'rejection'
            ],
            'incomplete_documentation' => [
                'title' => 'Incomplete Documentation',
                'message' => 'Your leave request is missing required documentation. Please provide the necessary documents and resubmit your request.',
                'category' => 'rejection'
            ],
            'exceeds_allowance' => [
                'title' => 'Exceeds Leave Allowance',
                'message' => 'Your request exceeds your available leave balance. Please check your leave balance and adjust your request accordingly.',
                'category' => 'rejection'
            ],
            'project_deadline' => [
                'title' => 'Critical Project Deadline',
                'message' => 'Your leave request conflicts with critical project deadlines. Please complete your current assignments or arrange proper handover before resubmitting.',
                'category' => 'rejection'
            ]
        ];
    }

    /**
     * Get quick response templates
     */
    public static function getQuickResponseTemplates(): array
    {
        return [
            'need_more_info' => [
                'title' => 'Need More Information',
                'message' => 'We need additional information to process your leave request. Please provide more details about [specify what information is needed].',
                'category' => 'inquiry'
            ],
            'alternative_dates' => [
                'title' => 'Suggest Alternative Dates',
                'message' => 'The requested dates are not available. Would you consider alternative dates? Please let us know your flexibility.',
                'category' => 'inquiry'
            ],
            'discuss_in_person' => [
                'title' => 'Schedule Discussion',
                'message' => 'Please schedule a meeting with HR/your manager to discuss your leave request in detail.',
                'category' => 'inquiry'
            ],
            'pending_review' => [
                'title' => 'Under Review',
                'message' => 'Your leave request is currently under review. We will get back to you within [X] business days.',
                'category' => 'status'
            ]
        ];
    }

    /**
     * Get all templates grouped by category
     */
    public static function getAllTemplates(): array
    {
        return [
            'approval' => self::getApprovalTemplates(),
            'rejection' => self::getRejectionTemplates(),
            'quick_response' => self::getQuickResponseTemplates()
        ];
    }

    /**
     * Get template by key
     */
    public static function getTemplate(string $category, string $key): ?array
    {
        $templates = self::getAllTemplates();
        return $templates[$category][$key] ?? null;
    }

    /**
     * Get personalized message
     */
    public static function getPersonalizedMessage(string $template, array $variables = []): string
    {
        $message = $template;
        
        foreach ($variables as $key => $value) {
            $message = str_replace("[{$key}]", $value, $message);
        }
        
        return $message;
    }

    /**
     * Get common variables for templates
     */
    public static function getCommonVariables(): array
    {
        return [
            'employee_name' => 'Employee Name',
            'leave_type' => 'Leave Type',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'total_days' => 'Total Days',
            'department' => 'Department',
            'manager_name' => 'Manager Name',
            'hr_contact' => 'HR Contact',
            'company_policy_days' => 'Company Policy Days',
            'alternative_dates' => 'Alternative Dates',
            'required_documents' => 'Required Documents',
            'project_name' => 'Project Name',
            'deadline_date' => 'Deadline Date'
        ];
    }

    /**
     * Generate response with employee context
     */
    public static function generateResponse(string $category, string $templateKey, $leave, array $customVariables = []): array
    {
        $template = self::getTemplate($category, $templateKey);
        
        if (!$template) {
            return [
                'success' => false,
                'message' => 'Template not found'
            ];
        }

        // Default variables from leave data
        $variables = [
            'employee_name' => $leave->employee->name ?? 'Employee',
            'leave_type' => $leave->leave_type_display ?? 'Leave',
            'start_date' => $leave->start_date->format('d M Y'),
            'end_date' => $leave->end_date->format('d M Y'),
            'total_days' => $leave->total_days,
            'department' => $leave->employee->department ?? 'N/A'
        ];

        // Merge with custom variables
        $variables = array_merge($variables, $customVariables);

        // Generate personalized message
        $personalizedMessage = self::getPersonalizedMessage($template['message'], $variables);

        return [
            'success' => true,
            'title' => $template['title'],
            'message' => $personalizedMessage,
            'category' => $template['category'],
            'variables_used' => $variables
        ];
    }

    /**
     * Get response statistics
     */
    public static function getResponseStats(): array
    {
        $allTemplates = self::getAllTemplates();
        
        return [
            'total_templates' => array_sum(array_map('count', $allTemplates)),
            'approval_templates' => count($allTemplates['approval']),
            'rejection_templates' => count($allTemplates['rejection']),
            'quick_response_templates' => count($allTemplates['quick_response']),
            'categories' => array_keys($allTemplates)
        ];
    }
}
