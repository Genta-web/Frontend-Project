<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Document;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Find documents without uploader information
        $documentsWithoutUploader = Document::whereNull('uploaded_by')->get();

        if ($documentsWithoutUploader->count() > 0) {
            // Try to find the first admin user as fallback
            $adminUser = User::where('role', 'admin')->first();

            if ($adminUser) {
                // Update all documents without uploader to be uploaded by the first admin
                Document::whereNull('uploaded_by')->update([
                    'uploaded_by' => $adminUser->id
                ]);
            }
            // If no admin user found, leave as null (will show "Unknown User")
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reset uploader field to null for all documents
        Document::query()->update(['uploaded_by' => null]);
    }
};
