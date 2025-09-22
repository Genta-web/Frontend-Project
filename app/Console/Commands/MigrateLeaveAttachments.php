<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Leave;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class MigrateLeaveAttachments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leave:migrate-attachments {--dry-run : Show what would be migrated without actually moving files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Migrate leave attachments from old public/uploads/leaves to new storage/app/public/leaves system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting leave attachments migration...');

        $dryRun = $this->option('dry-run');

        if ($dryRun) {
            $this->warn('DRY RUN MODE - No files will be moved');
        }

        // Get all leaves with attachments that don't start with 'leaves/'
        $leaves = Leave::whereNotNull('attachment')
                      ->where('attachment', '!=', '')
                      ->where('attachment', 'not like', 'leaves/%')
                      ->get();

        if ($leaves->isEmpty()) {
            $this->info('No attachments need migration.');
            return;
        }

        $this->info("Found {$leaves->count()} attachments to migrate.");

        $migrated = 0;
        $errors = 0;

        foreach ($leaves as $leave) {
            $oldPath = public_path('uploads/leaves/' . $leave->attachment);

            if (!file_exists($oldPath)) {
                $this->error("File not found: {$oldPath}");
                $errors++;
                continue;
            }

            $newPath = 'leaves/' . $leave->attachment;

            $this->line("Migrating: {$leave->attachment}");

            if (!$dryRun) {
                try {
                    // Ensure the storage directory exists
                    Storage::disk('public')->makeDirectory('leaves');

                    // Copy file to new location
                    $fileContents = file_get_contents($oldPath);
                    Storage::disk('public')->put($newPath, $fileContents);

                    // Update database record
                    $leave->update(['attachment' => $newPath]);

                    // Verify the file was copied successfully
                    if (Storage::disk('public')->exists($newPath)) {
                        $this->info("✓ Migrated: {$leave->attachment} -> {$newPath}");
                        $migrated++;

                        // Optionally delete old file (commented out for safety)
                        // unlink($oldPath);
                    } else {
                        $this->error("✗ Failed to copy: {$leave->attachment}");
                        $errors++;
                    }
                } catch (\Exception $e) {
                    $this->error("✗ Error migrating {$leave->attachment}: " . $e->getMessage());
                    $errors++;
                }
            } else {
                $this->line("Would migrate: {$leave->attachment} -> {$newPath}");
                $migrated++;
            }
        }

        $this->info("\nMigration Summary:");
        $this->info("Successfully migrated: {$migrated}");
        if ($errors > 0) {
            $this->error("Errors: {$errors}");
        }

        if (!$dryRun && $migrated > 0) {
            $this->info("\nFiles have been migrated to the new storage system.");
            $this->warn("Old files in public/uploads/leaves/ are still there for safety.");
            $this->warn("You can manually delete them after verifying everything works correctly.");
        }

        if ($dryRun) {
            $this->info("\nTo actually perform the migration, run:");
            $this->line("php artisan leave:migrate-attachments");
        }
    }
}
