<?php

namespace App\Services;

use App\Models\Leave;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageService
{
    /**
     * Process and store multiple images for a leave request.
     */
    public function storeLeaveImages(array $files, Leave $leave): array
    {
        $storedImages = [];

        foreach ($files as $index => $file) {
            if ($file instanceof UploadedFile && $file->isValid()) {
                $imageData = $this->processAndStoreImage($file, $index);

                if ($imageData && !empty($imageData)) {
                    $leave->addImage($imageData);
                    $storedImages[] = $imageData;
                } else {
                    \Log::warning('ImageService: Failed to process image', [
                        'file' => $file->getClientOriginalName()
                    ]);
                }
            } else {
                \Log::warning('ImageService: Invalid file skipped', [
                    'index' => $index,
                    'original_name' => $file instanceof UploadedFile ? $file->getClientOriginalName() : 'N/A'
                ]);
            }
        }

        // Only save if we have valid images
        if (!empty($storedImages)) {
            $leave->save();
            \Log::info('ImageService: Successfully stored images', [
                'leave_id' => $leave->id,
                'count' => count($storedImages)
            ]);
        }

        return $storedImages;
    }

    /**
     * Process and store a single image.
     */
    private function processAndStoreImage(UploadedFile $file, int $index): ?array
    {
        try {
            // Generate unique filename
            $originalName = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '_' . $index . '_' . uniqid() . '.' . $extension;
            $filePath = 'leaves/' . $fileName;

            // Store the original image
            $storedPath = $file->storeAs('leaves', $fileName, 'public');

            // Verify file was actually stored
            if (!Storage::disk('public')->exists($filePath)) {
                \Log::error('ImageService: File was not stored properly', [
                    'file_path' => $filePath,
                    'original_name' => $originalName
                ]);
                return null;
            }

            // Optimize image if it's too large
            $this->optimizeImage($filePath);

            // Get image dimensions
            $dimensions = $this->getImageDimensions($file);

            // Return image data array
            return [
                'original_name' => $originalName ?? 'unknown',
                'file_name' => $fileName,
                'path' => $filePath,
                'mime_type' => $file->getMimeType() ?? 'application/octet-stream',
                'size' => $file->getSize() ?? 0,
                'width' => $dimensions['width'] ?? null,
                'height' => $dimensions['height'] ?? null,
                'uploaded_at' => now()->toISOString()
            ];

        } catch (\Exception $e) {
            \Log::error('ImageService: Failed to process image', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'original_name' => $file->getClientOriginalName() ?? 'unknown'
            ]);
            return null;
        }
    }



    /**
     * Get image dimensions.
     */
    private function getImageDimensions(UploadedFile $file): array
    {
        try {
            if ($this->isImage($file)) {
                $imageSize = getimagesize($file->getRealPath());
                return [
                    'width' => $imageSize[0] ?? null,
                    'height' => $imageSize[1] ?? null
                ];
            }
        } catch (\Exception $e) {
            \Log::error('Failed to get image dimensions: ' . $e->getMessage());
        }

        return ['width' => null, 'height' => null];
    }

    /**
     * Check if file is an image.
     */
    private function isImage(UploadedFile $file): bool
    {
        return strpos($file->getMimeType(), 'image/') === 0;
    }

    /**
     * Delete image by index from leave.
     */
    public function deleteImageByIndex(Leave $leave, int $index): bool
    {
        try {
            $leave->removeImage($index);
            $leave->save();
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to delete image: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete all images from leave.
     */
    public function deleteAllImages(Leave $leave): bool
    {
        try {
            if ($leave->images && is_array($leave->images)) {
                foreach ($leave->images as $image) {
                    if (is_array($image) && isset($image['path']) && !empty($image['path'])) {
                        if (Storage::disk('public')->exists($image['path'])) {
                            Storage::disk('public')->delete($image['path']);
                        }
                    }
                }
            }
            $leave->images = [];
            $leave->save();
            return true;
        } catch (\Exception $e) {
            \Log::error('Failed to delete all images: ' . $e->getMessage(), [
                'leave_id' => $leave->id
            ]);
            return false;
        }
    }

    /**
     * Optimize image if it's too large.
     */
    private function optimizeImage(string $filePath): void
    {
        try {
            $fullPath = storage_path('app/public/' . $filePath);

            if (!file_exists($fullPath)) {
                return;
            }

            // Check file size (if larger than 2MB, try to optimize)
            $fileSize = filesize($fullPath);
            if ($fileSize > 2 * 1024 * 1024) {
                $imageInfo = getimagesize($fullPath);
                if ($imageInfo === false) {
                    return;
                }

                $width = $imageInfo[0];
                $height = $imageInfo[1];
                $mimeType = $imageInfo['mime'];

                // If image is very large, resize it
                if ($width > 1920 || $height > 1920) {
                    $this->resizeImage($fullPath, $mimeType, 1920, 1920);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to optimize image: ' . $e->getMessage());
        }
    }

    /**
     * Resize image using GD library.
     */
    private function resizeImage(string $filePath, string $mimeType, int $maxWidth, int $maxHeight): void
    {
        try {
            // Create image resource based on type
            switch ($mimeType) {
                case 'image/jpeg':
                    $source = imagecreatefromjpeg($filePath);
                    break;
                case 'image/png':
                    $source = imagecreatefrompng($filePath);
                    break;
                case 'image/gif':
                    $source = imagecreatefromgif($filePath);
                    break;
                default:
                    return;
            }

            if (!$source) {
                return;
            }

            $originalWidth = imagesx($source);
            $originalHeight = imagesy($source);

            // Calculate new dimensions
            $ratio = min($maxWidth / $originalWidth, $maxHeight / $originalHeight);
            $newWidth = (int)($originalWidth * $ratio);
            $newHeight = (int)($originalHeight * $ratio);

            // Create new image
            $destination = imagecreatetruecolor($newWidth, $newHeight);

            // Preserve transparency for PNG and GIF
            if ($mimeType === 'image/png' || $mimeType === 'image/gif') {
                imagealphablending($destination, false);
                imagesavealpha($destination, true);
                $transparent = imagecolorallocatealpha($destination, 255, 255, 255, 127);
                imagefilledrectangle($destination, 0, 0, $newWidth, $newHeight, $transparent);
            }

            // Resize image
            imagecopyresampled($destination, $source, 0, 0, 0, 0, $newWidth, $newHeight, $originalWidth, $originalHeight);

            // Save resized image
            switch ($mimeType) {
                case 'image/jpeg':
                    imagejpeg($destination, $filePath, 85);
                    break;
                case 'image/png':
                    imagepng($destination, $filePath, 6);
                    break;
                case 'image/gif':
                    imagegif($destination, $filePath);
                    break;
            }

            // Clean up
            imagedestroy($source);
            imagedestroy($destination);

        } catch (\Exception $e) {
            \Log::error('Failed to resize image: ' . $e->getMessage());
        }
    }
}
