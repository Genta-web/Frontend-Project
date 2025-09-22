<?php

namespace App\Helpers;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LeavePermissionHelper
{
    /**
     * Check if user can view leave details
     */
    public static function canView(User $user, Leave $leave): bool
    {
        // Admin, HR, Manager can view all leaves
        if ($user->hasRole(['admin', 'hr', 'manager'])) {
            return true;
        }

        // Employee can only view their own leaves
        if ($user->isEmployee() && $user->employee) {
            return $leave->employee_id === $user->employee->id;
        }

        return false;
    }

    /**
     * Check if user can create leave request
     */
    public static function canCreate(User $user): bool
    {
        // All authenticated users can create leave requests
        return true;
    }

    /**
     * Check if user can edit leave request
     */
    public static function canEdit(User $user, Leave $leave): bool
    {
        // Only pending leaves can be edited
        if (!$leave->isPending()) {
            return false;
        }

        // Admin, HR, Manager can edit any pending leave
        if ($user->hasRole(['admin', 'hr', 'manager'])) {
            return true;
        }

        // Employee can only edit their own pending leaves
        if ($user->isEmployee() && $user->employee) {
            return $leave->employee_id === $user->employee->id;
        }

        return false;
    }

    /**
     * Check if user can delete leave request
     */
    public static function canDelete(User $user, Leave $leave): bool
    {
        // Only pending leaves can be deleted
        if (!$leave->isPending()) {
            return false;
        }

        // Admin, HR, Manager can delete any pending leave
        if ($user->hasRole(['admin', 'hr', 'manager'])) {
            return true;
        }

        // Employee can only delete their own pending leaves
        if ($user->isEmployee() && $user->employee) {
            return $leave->employee_id === $user->employee->id;
        }

        return false;
    }

    /**
     * Check if user can approve leave request
     */
    public static function canApprove(User $user, Leave $leave): bool
    {
        // Only pending or waiting leaves can be approved
        if (!in_array($leave->status, ['pending', 'waiting'])) {
            return false;
        }

        // Only Admin, HR, Manager can approve
        return $user->hasRole(['admin', 'hr', 'manager']);
    }

    /**
     * Check if user can reject leave request
     */
    public static function canReject(User $user, Leave $leave): bool
    {
        // Only pending or waiting leaves can be rejected
        if (!in_array($leave->status, ['pending', 'waiting'])) {
            return false;
        }

        // Only Admin, HR, Manager can reject
        return $user->hasRole(['admin', 'hr', 'manager']);
    }

    /**
     * Check if user can perform bulk actions
     */
    public static function canBulkAction(User $user): bool
    {
        // Only Admin, HR, Manager can perform bulk actions
        return $user->hasRole(['admin', 'hr', 'manager']);
    }

    /**
     * Get available actions for a leave request
     */
    public static function getAvailableActions(User $user, Leave $leave): array
    {
        $actions = [];

        if (self::canView($user, $leave)) {
            $actions[] = 'view';
        }

        if (self::canEdit($user, $leave)) {
            $actions[] = 'edit';
        }

        if (self::canDelete($user, $leave)) {
            $actions[] = 'delete';
        }

        if (self::canApprove($user, $leave)) {
            $actions[] = 'approve';
        }

        if (self::canReject($user, $leave)) {
            $actions[] = 'reject';
        }

        return $actions;
    }

    /**
     * Get user context for leave management
     */
    public static function getUserContext(User $user): array
    {
        return [
            'isEmployee' => $user->isEmployee(),
            'hasManagePermission' => $user->hasRole(['admin', 'hr', 'manager']),
            'canBulkAction' => self::canBulkAction($user),
            'role' => $user->role,
            'employeeId' => $user->employee?->id
        ];
    }

    /**
     * Filter leaves based on user permissions
     */
    public static function filterLeavesForUser(User $user, $query)
    {
        // Admin, HR, Manager can see all leaves
        if ($user->hasRole(['admin', 'hr', 'manager'])) {
            return $query;
        }

        // Employee can only see their own leaves
        if ($user->isEmployee() && $user->employee) {
            return $query->where('employee_id', $user->employee->id);
        }

        // If no valid role/employee, return empty result
        return $query->whereRaw('1 = 0');
    }

    /**
     * Check if user can access leave management system
     */
    public static function canAccessLeaveManagement(User $user): bool
    {
        // All authenticated users can access leave management
        // But they will see different views based on their role
        return true;
    }

    /**
     * Get permission error message
     */
    public static function getPermissionErrorMessage(string $action): string
    {
        $messages = [
            'view' => 'You do not have permission to view this leave request.',
            'edit' => 'You do not have permission to edit this leave request.',
            'delete' => 'You do not have permission to delete this leave request.',
            'approve' => 'You do not have permission to approve leave requests.',
            'reject' => 'You do not have permission to reject leave requests.',
            'bulk' => 'You do not have permission to perform bulk actions.',
            'create' => 'You do not have permission to create leave requests.',
        ];

        return $messages[$action] ?? 'You do not have permission to perform this action.';
    }

    /**
     * Validate action permission and throw exception if not allowed
     */
    public static function validateAction(User $user, Leave $leave, string $action): void
    {
        $canPerform = match($action) {
            'view' => self::canView($user, $leave),
            'edit' => self::canEdit($user, $leave),
            'delete' => self::canDelete($user, $leave),
            'approve' => self::canApprove($user, $leave),
            'reject' => self::canReject($user, $leave),
            default => false
        };

        if (!$canPerform) {
            abort(403, self::getPermissionErrorMessage($action));
        }
    }

    /**
     * Get leave status that user can filter by
     */
    public static function getFilterableStatuses(User $user): array
    {
        $statuses = ['pending', 'approved', 'rejected'];

        // All users can filter by all statuses
        // The actual data filtering is handled by filterLeavesForUser
        return $statuses;
    }

    /**
     * Check if user should see bulk action controls
     */
    public static function shouldShowBulkActions(User $user): bool
    {
        return self::canBulkAction($user);
    }
}
