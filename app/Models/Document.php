<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table= 'documents';

    protected $fillable=[
        'title',
        'path',
        'original_name',
        'file_size',
        'mime_type',
        'uploaded_by',
        'description',
    ];

    /**
     * Get the formatted file size
     */
    public function getFormattedFileSizeAttribute()
    {
        if (!$this->file_size) {
            return 'Unknown';
        }

        $bytes = (int) $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the file extension from original name
     */
    public function getFileExtensionAttribute()
    {
        return $this->original_name ? strtolower(pathinfo($this->original_name, PATHINFO_EXTENSION)) : '';
    }

    /**
     * Get the user who uploaded this document
     */
    public function uploader()
    {
        return $this->belongsTo(\App\Models\User::class, 'uploaded_by');
    }

    /**
     * Get the uploader name with fallback
     */
    public function getUploaderNameAttribute()
    {
        if ($this->uploader) {
            return $this->uploader->username;
        }
        return 'Unknown User';
    }
}
