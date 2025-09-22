<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkLog extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'employee_id',
        'work_date',
        'start_time',
        'end_time',
        'task_summary',
        'status',
        'action_details',
        'attachment_image',
        'status_update_image',
        'status_updated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'work_date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
        'status_updated_at' => 'datetime',
    ];

    /**
     * Get the employee that owns the work log.
     */
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Calculate the duration of work in hours.
     */
    public function getDurationAttribute()
    {
        if ($this->start_time && $this->end_time) {
            $start = \Carbon\Carbon::parse($this->start_time);
            $end = \Carbon\Carbon::parse($this->end_time);
            return $end->diffInHours($start);
        }
        return 0;
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'ongoing' => 'bg-warning',
            'in_progress' => 'bg-info',
            'done' => 'bg-success',
            default => 'bg-secondary'
        };
    }

    /**
     * Get the status display name.
     */
    public function getStatusDisplayAttribute(): string
    {
        return match($this->status) {
            'ongoing' => 'Ongoing',
            'in_progress' => 'In Progress',
            'done' => 'Done',
            default => ucfirst($this->status)
        };
    }

    /**
     * Check if work log is ongoing.
     */
    public function isOngoing(): bool
    {
        return $this->status === 'ongoing';
    }

    /**
     * Check if work log is in progress.
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if work log is done.
     */
    public function isDone(): bool
    {
        return $this->status === 'done';
    }

    /**
     * Scope for ongoing work logs.
     */
    public function scopeOngoing($query)
    {
        return $query->where('status', 'ongoing');
    }

    /**
     * Scope for in progress work logs.
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope for done work logs.
     */
    public function scopeDone($query)
    {
        return $query->where('status', 'done');
    }
}
