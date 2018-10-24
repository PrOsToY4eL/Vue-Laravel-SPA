<?php

namespace Tests\Unit;

use App\Services\UploadFileService;
use Illuminate\Http\UploadedFile;
use Image;
use Storage;
use Tests\TestCase;


class UploadFileTest extends TestCase
{
    /**
     * @return void
     */
    public function testUploadFileSuccess()
    {
        $file = UploadedFile::fake()->image('avatar.png', 100, 100)->size(100);

        $uploadedFileService = new UploadFileService();
        $basePath = $uploadedFileService->uploadUserAvatar($file,0);

        $this->assertEquals(public_path().'/storage/avatars/user_0.png', public_path().$basePath);
        Storage::disk('public')->assertExists('/avatars/user_0.png');

        unlink(public_path().$basePath);
    }

    /**
     * @return void
     */
    public function testUploadFileSuccessWithResizing()
    {
        $file = UploadedFile::fake()->image('avatar.png', 750, 750)->size(100);

        $uploadedFileService = new UploadFileService();
        $basePath = $uploadedFileService->uploadUserAvatar($file,0);

        $image = Image::make(public_path().$basePath);
        $this->assertEquals($image->height(), $image->height());
        $this->assertEquals($image->height(), 300);

        $this->assertEquals(public_path().'/storage/avatars/user_0.png', public_path().$basePath);
        Storage::disk('public')->assertExists('/avatars/user_0.png');
        unlink(public_path().$basePath);
    }

}
