<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_code',
        'name',
        'email',
        'phone',
        'department',
        'position',
        'hire_date',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'hire_date' => 'date',
    ];

    /**
     * Get the user that belongs to the employee.
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }

    /**
     * Get the attendance records for the employee.
     */
    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the work logs for the employee.
     */
    public function workLogs()
    {
        return $this->hasMany(WorkLog::class);
    }

    /**
     * Get the job batches initiated by the employee.
     */
    public function jobBatches()
    {
        return $this->hasMany(JobBatch::class);
    }

    /**
     * Get the employee jobs/tasks.
     */
    public function employeeJobs()
    {
        return $this->hasMany(EmployeeJob::class);
    }

    /**
     * Get the leaves for the employee.
     */
    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }

    /**
     * Scope a query to only include active employees.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include inactive employees.
     */
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }

    /**
     * Get the employee's full name with employee code.
     */
    public function getFullNameWithCodeAttribute()
    {
        return $this->employee_code . ' - ' . $this->name;
    }

    /**
     * Get the employee's status badge class for Bootstrap.
     */
    public function getStatusBadgeClassAttribute()
    {
        return $this->status === 'active' ? 'badge-success' : 'badge-secondary';
    }
}
