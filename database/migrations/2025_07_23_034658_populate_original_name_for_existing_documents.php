<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Document;
use Illuminate\Support\Facades\Storage;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Populate original_name for existing documents
        $documents = Document::whereNull('original_name')->get();

        foreach ($documents as $document) {
            if ($document->path) {
                // Extract filename from path as fallback
                $filename = basename($document->path);

                // Try to get file info if file exists
                if (Storage::exists($document->path)) {
                    $fullPath = Storage::path($document->path);
                    $fileSize = filesize($fullPath);
                    $mimeType = mime_content_type($fullPath);

                    $document->update([
                        'original_name' => $filename,
                        'file_size' => $fileSize,
                        'mime_type' => $mimeType
                    ]);
                } else {
                    // File doesn't exist, just set the filename
                    $document->update([
                        'original_name' => $filename
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset the fields to null
        Document::query()->update([
            'original_name' => null,
            'file_size' => null,
            'mime_type' => null
        ]);
    }
};
