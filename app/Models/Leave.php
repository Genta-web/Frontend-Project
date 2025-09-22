<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Leave extends Model
{
    protected $fillable = [
        'employee_id',
        'leave_type',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'status',
        'admin_notes',
        'attachment',
        'images',
        'approved_by',
        'approved_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
        'images' => 'array'
    ];

    /**
     * Get the employee that owns the leave.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get the user who approved the leave.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get all image URLs for this leave.
     */
    public function getImageUrls(): array
    {
        if (!$this->images) {
            return [];
        }

        return collect($this->images)->map(function ($image) {
            return isset($image['path']) ? Storage::url($image['path']) : null;
        })->filter()->toArray();
    }

    /**
     * Get the first image URL.
     */
    public function getFirstImageUrl(): ?string
    {
        $urls = $this->getImageUrls();
        return !empty($urls) ? $urls[0] : null;
    }

    /**
     * Get image data with URLs.
     */
    public function getImagesWithUrls(): array
    {
        if (!$this->images) {
            return [];
        }

        return collect($this->images)->map(function ($image) {
            // Skip invalid images without path
            if (!isset($image['path']) || empty($image['path'])) {
                return null;
            }

            return array_merge($image, [
                'url' => Storage::url($image['path']),
                'exists' => Storage::disk('public')->exists($image['path']),
                'formatted_size' => $this->formatFileSize($image['size'] ?? 0)
            ]);
        })->filter()->values()->toArray();
    }

    /**
     * Get the attachment URL with backward compatibility.
     */
    public function getAttachmentUrlAttribute()
    {
        if (!$this->attachment) {
            return null;
        }

        // Check if it's a new storage path (contains 'leaves/')
        if (strpos($this->attachment, 'leaves/') === 0) {
            // New Laravel Storage system
            return \Storage::url($this->attachment);
        } else {
            // Old system - files stored in public/uploads/leaves/
            return asset('uploads/leaves/' . $this->attachment);
        }
    }

    /**
     * Check if attachment exists with backward compatibility.
     */
    public function attachmentExists()
    {
        if (!$this->attachment) {
            return false;
        }

        // Check if it's a new storage path
        if (strpos($this->attachment, 'leaves/') === 0) {
            return \Storage::disk('public')->exists($this->attachment);
        } else {
            // Old system
            return file_exists(public_path('uploads/leaves/' . $this->attachment));
        }
    }

    /**
     * Get attachment file size with backward compatibility.
     */
    public function getAttachmentSize()
    {
        if (!$this->attachment) {
            return 0;
        }

        try {
            if (strpos($this->attachment, 'leaves/') === 0) {
                // New storage system
                return \Storage::disk('public')->size($this->attachment);
            } else {
                // Old system
                $filePath = public_path('uploads/leaves/' . $this->attachment);
                return file_exists($filePath) ? filesize($filePath) : 0;
            }
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Get the status badge class.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-warning',
            'approved' => 'bg-success',
            'rejected' => 'bg-danger',
            default => 'bg-secondary'
        };
    }

    /**
     * Get the leave type display name.
     */
    public function getLeaveTypeDisplayAttribute(): string
    {
        return match($this->leave_type) {
            'annual' => 'Annual Leave',
            'sick' => 'Sick Leave',
            'emergency' => 'Emergency Leave',
            'maternity' => 'Maternity Leave',
            'paternity' => 'Paternity Leave',
            'unpaid' => 'Unpaid Leave',
            default => ucfirst($this->leave_type)
        };
    }

    /**
     * Check if leave is pending.
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if leave is approved.
     */
    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    /**
     * Check if leave is rejected.
     */
    public function isRejected(): bool
    {
        return $this->status === 'rejected';
    }

    /**
     * Calculate total days between start and end date.
     */
    public static function calculateTotalDays($startDate, $endDate): int
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);

        return $start->diffInDays($end) + 1; // +1 to include both start and end dates
    }

    /**
     * Scope for pending leaves.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved leaves.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope for current year leaves.
     */
    public function scopeCurrentYear($query)
    {
        return $query->whereYear('start_date', now()->year);
    }

    /**
     * Check if this leave has any images.
     */
    public function hasImages(): bool
    {
        if (!$this->images || !is_array($this->images) || count($this->images) === 0) {
            return false;
        }

        // Check if any image has valid data (not empty array)
        foreach ($this->images as $image) {
            if (is_array($image) && !empty($image) && isset($image['path']) && !empty($image['path'])) {
                return true;
            }
        }

        return false;
    }

    /**
     * Add an image to the leave.
     */
    public function addImage(array $imageData): void
    {
        // Validate image data before adding
        if (empty($imageData) || !isset($imageData['path']) || empty($imageData['path'])) {
            \Log::warning('Leave: Attempted to add invalid image data', [
                'leave_id' => $this->id,
                'has_path' => isset($imageData['path']),
                'path_empty' => isset($imageData['path']) ? empty($imageData['path']) : 'N/A'
            ]);
            return;
        }

        $images = $this->images ?? [];
        $images[] = $imageData;
        $this->images = $images;
    }

    /**
     * Remove an image by index.
     */
    public function removeImage(int $index): void
    {
        $images = $this->images ?? [];
        if (isset($images[$index]) && is_array($images[$index])) {
            // Delete the file from storage
            if (isset($images[$index]['path']) && !empty($images[$index]['path'])) {
                try {
                    if (Storage::disk('public')->exists($images[$index]['path'])) {
                        Storage::disk('public')->delete($images[$index]['path']);
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to delete image file: ' . $e->getMessage(), [
                        'leave_id' => $this->id,
                        'image_path' => $images[$index]['path'],
                        'index' => $index
                    ]);
                }
            }
            unset($images[$index]);
            $this->images = array_values($images); // Re-index array
        }
    }

    /**
     * Format file size.
     */
    private function formatFileSize(int $bytes): string
    {
        if ($bytes > 1024 * 1024) {
            return number_format($bytes / (1024 * 1024), 1) . ' MB';
        } else {
            return number_format($bytes / 1024, 1) . ' KB';
        }
    }

    /**
     * Clean up invalid image data.
     */
    public function cleanupImages(): void
    {
        if (!$this->images || !is_array($this->images)) {
            return;
        }

        $validImages = [];
        foreach ($this->images as $image) {
            if (is_array($image) && isset($image['path']) && !empty($image['path'])) {
                $validImages[] = $image;
            }
        }

        if (count($validImages) !== count($this->images)) {
            $this->images = $validImages;
            $this->save();
        }
    }

    /**
     * Delete all associated image files when leave is deleted.
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($leave) {
            // Delete all associated image files
            if ($leave->images && is_array($leave->images)) {
                foreach ($leave->images as $image) {
                    if (is_array($image) && isset($image['path']) && !empty($image['path'])) {
                        try {
                            if (Storage::disk('public')->exists($image['path'])) {
                                Storage::disk('public')->delete($image['path']);
                            }
                        } catch (\Exception $e) {
                            \Log::error('Failed to delete image file: ' . $e->getMessage(), [
                                'leave_id' => $leave->id,
                                'image_path' => $image['path']
                            ]);
                        }
                    }
                }
            }
        });
    }

}
