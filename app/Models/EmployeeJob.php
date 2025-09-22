<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class EmployeeJob extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'title',
        'description',
        'priority',
        'status',
        'start_date',
        'due_date',
        'completed_date',
        'notes',
        'attachment',
        'progress_percentage',
        'metadata',
        'assigned_by',
        'reviewed_at',
        'reviewed_by',
        'review_notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'completed_date' => 'date',
        'metadata' => 'array',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the employee that owns the job.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the user who assigned this job.
     */
    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    /**
     * Get the user who reviewed this job.
     */
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Check if the job is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_date < Carbon::today() && !$this->isCompleted();
    }

    /**
     * Check if the job is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Check if the job is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if the job is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Get the priority badge class.
     */
    public function getPriorityBadgeClassAttribute(): string
    {
        return match($this->priority) {
            'urgent' => 'bg-danger',
            'high' => 'bg-warning',
            'medium' => 'bg-info',
            'low' => 'bg-secondary',
            default => 'bg-secondary'
        };
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'completed' => 'bg-success',
            'in_progress' => 'bg-info',
            'pending' => 'bg-warning',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get the priority display name.
     */
    public function getPriorityDisplayAttribute(): string
    {
        return ucfirst($this->priority);
    }

    /**
     * Get the status display name.
     */
    public function getStatusDisplayAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->status));
    }

    /**
     * Get days until due date.
     */
    public function getDaysUntilDueAttribute(): int
    {
        return Carbon::today()->diffInDays($this->due_date, false);
    }

    /**
     * Scope a query to only include jobs for a specific employee.
     */
    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    /**
     * Scope a query to only include jobs with a specific status.
     */
    public function scopeWithStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include jobs with a specific priority.
     */
    public function scopeWithPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to only include overdue jobs.
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', Carbon::today())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    /**
     * Scope a query to only include jobs due today.
     */
    public function scopeDueToday($query)
    {
        return $query->where('due_date', Carbon::today())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    /**
     * Scope a query to only include jobs due this week.
     */
    public function scopeDueThisWeek($query)
    {
        return $query->whereBetween('due_date', [Carbon::today(), Carbon::today()->addWeek()])
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }
}
