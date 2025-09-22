<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JobBatch extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'job_batches';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'employee_id',
        'batch_type',
        'description',
        'metadata',
        'total_jobs',
        'pending_jobs',
        'failed_jobs',
        'failed_job_ids',
        'options',
        'cancelled_at',
        'created_at',
        'finished_at',
        'priority',
        'start_date',
        'due_date',
        'completed_date',
        'notes',
        'attachment',
        'progress_percentage',
        'job_status',
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
        'metadata' => 'array',
        'failed_job_ids' => 'array',
        'options' => 'array',
        'cancelled_at' => 'timestamp',
        'created_at' => 'timestamp',
        'finished_at' => 'timestamp',
        'start_date' => 'date',
        'due_date' => 'date',
        'completed_date' => 'date',
        'reviewed_at' => 'datetime',
    ];

    /**
     * Get the employee that owns the job batch.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the user who reviewed this job.
     */
    public function reviewedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Check if the job batch is completed.
     */
    public function isCompleted(): bool
    {
        return $this->finished_at !== null;
    }

    /**
     * Check if the job batch is cancelled.
     */
    public function isCancelled(): bool
    {
        return $this->cancelled_at !== null;
    }

    /**
     * Check if the job batch is in progress.
     */
    public function isInProgress(): bool
    {
        return !$this->isCompleted() && !$this->isCancelled() && $this->pending_jobs > 0;
    }

    /**
     * Get the progress percentage of the job batch.
     */
    public function getProgressPercentage(): float
    {
        if ($this->total_jobs === 0) {
            return 0;
        }

        $completed_jobs = $this->total_jobs - $this->pending_jobs;
        return round(($completed_jobs / $this->total_jobs) * 100, 2);
    }

    /**
     * Get the status of the job batch.
     */
    public function getStatus(): string
    {
        if ($this->isCancelled()) {
            return 'cancelled';
        }

        if ($this->isCompleted()) {
            return $this->failed_jobs > 0 ? 'completed_with_failures' : 'completed';
        }

        if ($this->isInProgress()) {
            return 'in_progress';
        }

        return 'pending';
    }

    /**
     * Scope a query to only include job batches for a specific employee.
     */
    public function scopeForEmployee($query, $employeeId)
    {
        return $query->where('employee_id', $employeeId);
    }

    /**
     * Scope a query to only include job batches of a specific type.
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('batch_type', $type);
    }

    /**
     * Scope a query to only include completed job batches.
     */
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('finished_at');
    }

    /**
     * Scope a query to only include in-progress job batches.
     */
    public function scopeInProgress($query)
    {
        return $query->whereNull('finished_at')
                    ->whereNull('cancelled_at')
                    ->where('pending_jobs', '>', 0);
    }

    // Job Management Methods

    /**
     * Check if the job is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->due_date && $this->due_date < \Carbon\Carbon::today() && !$this->isJobCompleted();
    }

    /**
     * Check if the job is completed.
     */
    public function isJobCompleted(): bool
    {
        return $this->job_status === 'completed';
    }

    /**
     * Check if the job is in progress.
     */
    public function isJobInProgress(): bool
    {
        return $this->job_status === 'in_progress';
    }

    /**
     * Check if the job is pending.
     */
    public function isJobPending(): bool
    {
        return $this->job_status === 'pending';
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
     * Get the job status badge class.
     */
    public function getJobStatusBadgeClassAttribute(): string
    {
        return match($this->job_status) {
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
        return ucfirst($this->priority ?? 'medium');
    }

    /**
     * Get the job status display name.
     */
    public function getJobStatusDisplayAttribute(): string
    {
        return ucfirst(str_replace('_', ' ', $this->job_status ?? 'pending'));
    }

    /**
     * Get days until due date.
     */
    public function getDaysUntilDueAttribute(): int
    {
        if (!$this->due_date) return 0;
        return \Carbon\Carbon::today()->diffInDays($this->due_date, false);
    }

    /**
     * Scope a query to only include jobs with a specific job status.
     */
    public function scopeWithJobStatus($query, $status)
    {
        return $query->where('job_status', $status);
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
        return $query->where('due_date', '<', \Carbon\Carbon::today())
                    ->whereNotIn('job_status', ['completed', 'cancelled']);
    }

    /**
     * Scope a query to only include jobs due today.
     */
    public function scopeDueToday($query)
    {
        return $query->where('due_date', \Carbon\Carbon::today())
                    ->whereNotIn('job_status', ['completed', 'cancelled']);
    }

    /**
     * Scope a query to only include jobs due this week.
     */
    public function scopeDueThisWeek($query)
    {
        return $query->whereBetween('due_date', [\Carbon\Carbon::today(), \Carbon\Carbon::today()->addWeek()])
                    ->whereNotIn('job_status', ['completed', 'cancelled']);
    }
}
