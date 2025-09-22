<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();
        
        if (!$this->hasPermission($user, $permission)) {
            abort(403, 'Access denied. You do not have permission to perform this action.');
        }

        return $next($request);
    }

    /**
     * Check if user has specific permission based on role.
     */
    private function hasPermission($user, $permission): bool
    {
        $permissions = $this->getRolePermissions($user->role);
        return in_array($permission, $permissions);
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
}
