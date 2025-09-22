<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;
use App\Models\Leave;
use App\Services\ImageService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class LeaveImageTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $employee;
    protected $imageService;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test user and employee
        $this->user = User::factory()->create([
            'role' => 'employee',
            'username' => 'test_employee'
        ]);
        
        $this->employee = Employee::factory()->create([
            'user_id' => $this->user->id,
            'employee_code' => 'EMP001',
            'name' => 'Test Employee'
        ]);

        $this->imageService = new ImageService();
        
        // Fake storage for testing
        Storage::fake('public');
    }

    /** @test */
    public function it_can_store_multiple_images_for_leave()
    {
        // Create a leave
        $leave = Leave::create([
            'employee_id' => $this->employee->id,
            'leave_type' => 'annual',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(3),
            'total_days' => 3,
            'reason' => 'Test leave with images',
            'status' => 'pending'
        ]);

        // Create fake image files
        $images = [
            UploadedFile::fake()->image('test1.jpg', 800, 600)->size(1024),
            UploadedFile::fake()->image('test2.png', 1024, 768)->size(2048),
        ];

        // Store images
        $storedImages = $this->imageService->storeLeaveImages($images, $leave);

        // Refresh leave to get updated data
        $leave->refresh();

        // Assertions
        $this->assertCount(2, $storedImages);
        $this->assertTrue($leave->hasImages());
        $this->assertCount(2, $leave->images);
        
        // Check first image data
        $firstImage = $leave->images[0];
        $this->assertEquals('test1.jpg', $firstImage['original_name']);
        $this->assertStringContains('leaves/', $firstImage['path']);
        $this->assertEquals('image/jpeg', $firstImage['mime_type']);
        
        // Check that files exist in storage
        foreach ($leave->images as $image) {
            Storage::disk('public')->assertExists($image['path']);
        }
    }

    /** @test */
    public function it_can_get_image_urls()
    {
        $leave = Leave::create([
            'employee_id' => $this->employee->id,
            'leave_type' => 'sick',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(2),
            'total_days' => 2,
            'reason' => 'Test leave',
            'status' => 'pending',
            'images' => [
                [
                    'original_name' => 'test.jpg',
                    'file_name' => 'test_123.jpg',
                    'path' => 'leaves/test_123.jpg',
                    'mime_type' => 'image/jpeg',
                    'size' => 1024,
                    'width' => 800,
                    'height' => 600,
                    'uploaded_at' => now()->toISOString()
                ]
            ]
        ]);

        $urls = $leave->getImageUrls();
        
        $this->assertCount(1, $urls);
        $this->assertStringContains('/storage/leaves/test_123.jpg', $urls[0]);
    }

    /** @test */
    public function it_can_remove_image_by_index()
    {
        $leave = Leave::create([
            'employee_id' => $this->employee->id,
            'leave_type' => 'emergency',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(1),
            'total_days' => 1,
            'reason' => 'Test leave',
            'status' => 'pending',
            'images' => [
                [
                    'original_name' => 'test1.jpg',
                    'path' => 'leaves/test1.jpg',
                    'mime_type' => 'image/jpeg',
                    'size' => 1024
                ],
                [
                    'original_name' => 'test2.jpg',
                    'path' => 'leaves/test2.jpg',
                    'mime_type' => 'image/jpeg',
                    'size' => 2048
                ]
            ]
        ]);

        // Create fake files in storage
        Storage::disk('public')->put('leaves/test1.jpg', 'fake content 1');
        Storage::disk('public')->put('leaves/test2.jpg', 'fake content 2');

        // Remove first image (index 0)
        $leave->removeImage(0);
        $leave->save();

        // Refresh and check
        $leave->refresh();
        
        $this->assertCount(1, $leave->images);
        $this->assertEquals('test2.jpg', $leave->images[0]['original_name']);
        
        // Check that file was deleted from storage
        Storage::disk('public')->assertMissing('leaves/test1.jpg');
        Storage::disk('public')->assertExists('leaves/test2.jpg');
    }

    /** @test */
    public function it_deletes_images_when_leave_is_deleted()
    {
        $leave = Leave::create([
            'employee_id' => $this->employee->id,
            'leave_type' => 'annual',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(2),
            'total_days' => 2,
            'reason' => 'Test leave',
            'status' => 'pending',
            'images' => [
                [
                    'original_name' => 'test.jpg',
                    'path' => 'leaves/test.jpg',
                    'mime_type' => 'image/jpeg',
                    'size' => 1024
                ]
            ]
        ]);

        // Create fake file in storage
        Storage::disk('public')->put('leaves/test.jpg', 'fake content');
        Storage::disk('public')->assertExists('leaves/test.jpg');

        // Delete leave
        $leave->delete();

        // Check that file was deleted from storage
        Storage::disk('public')->assertMissing('leaves/test.jpg');
    }

    /** @test */
    public function it_can_get_images_with_urls()
    {
        $leave = Leave::create([
            'employee_id' => $this->employee->id,
            'leave_type' => 'annual',
            'start_date' => now()->addDays(1),
            'end_date' => now()->addDays(2),
            'total_days' => 2,
            'reason' => 'Test leave',
            'status' => 'pending',
            'images' => [
                [
                    'original_name' => 'test.jpg',
                    'file_name' => 'test_123.jpg',
                    'path' => 'leaves/test_123.jpg',
                    'mime_type' => 'image/jpeg',
                    'size' => 1024,
                    'width' => 800,
                    'height' => 600,
                    'uploaded_at' => now()->toISOString()
                ]
            ]
        ]);

        $imagesWithUrls = $leave->getImagesWithUrls();
        
        $this->assertCount(1, $imagesWithUrls);
        $this->assertEquals('test.jpg', $imagesWithUrls[0]['original_name']);
        $this->assertStringContains('/storage/leaves/test_123.jpg', $imagesWithUrls[0]['url']);
        $this->assertEquals('1.0 KB', $imagesWithUrls[0]['formatted_size']);
        $this->assertFalse($imagesWithUrls[0]['exists']); // File doesn't actually exist in fake storage
    }
}
