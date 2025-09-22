<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait HasPermissions
{
    /**
     * Check if current user has specific permission.
     */
    protected function hasPermission(string $permission): bool
    {
        if (!Auth::check()) {
            return false;
        }

        $user = Auth::user();
        $permissions = $this->getRolePermissions($user->role);
        
        return in_array($permission, $permissions);
    }

    /**
     * Check if current user has any of the specified permissions.
     */
    protected function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if current user has all of the specified permissions.
     */
    protected function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get permissions for each role.
     */
    private function getRolePermissions($role): array
    {
        $permissions = [
            'admin' => [
                'employees.view',
                'employees.create',
                'employees.edit',
                'employees.delete',
                'attendance.view',
                'attendance.create',
                'attendance.edit',
                'attendance.delete',
                'work_logs.view',
                'work_logs.create',
                'work_logs.edit',
                'work_logs.delete',
                'users.view',
                'users.create',
                'users.edit',
                'users.delete',
                'reports.view',
                'settings.manage',
            ],
            'hr' => [
                'employees.view',
                'employees.create',
                'employees.edit',
                'attendance.view',
                'attendance.create',
                'attendance.edit',
                'work_logs.view',
                'reports.view',
            ],
            'manager' => [
                'employees.view',
                'attendance.view',
                'work_logs.view',
                'reports.view',
            ],
            'employee' => [
                'attendance.view_own',
                'work_logs.view_own',
                'work_logs.create_own',
                'work_logs.edit_own',
            ],
            'system' => [
                // System user has no UI permissions
            ],
        ];

        return $permissions[$role] ?? [];
    }

    /**
     * Authorize user for specific permission or abort.
     */
    protected function authorize(string $permission, string $message = 'Access denied.'): void
    {
        if (!$this->hasPermission($permission)) {
            abort(403, $message);
        }
    }
}
