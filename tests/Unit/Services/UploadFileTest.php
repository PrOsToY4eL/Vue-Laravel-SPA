<?php

namespace Tests\Unit;

use App\Exceptions\ValidationFaildException;
use App\Services\UploadFileService;
use App\Services\UserValidationService;
use Illuminate\Http\UploadedFile;
use Image;
use Symfony\Component\HttpFoundation\Tests\File\UploadedFileTest;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UploadFileTest extends TestCase
{
    public function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    /**
     * @return void
     */
    public function testUploadFileSuccess()
    {
        $file = UploadedFile::fake()->image('avatar.png', 100, 100)->size(100);
        $basePath = UploadFileService::uploadUserAvatar($file,0);

        $this->assertEquals(public_path().'/storage/avatars/user_0.png', public_path().$basePath);
        unlink(public_path().$basePath);
    }

    /**
     * @return void
     */
    public function testUploadFileSuccessWithResizing()
    {
        $file = UploadedFile::fake()->image('avatar.png', 750, 750)->size(100);
        $basePath = UploadFileService::uploadUserAvatar($file,0);

        $image = Image::make(public_path().$basePath);
        $this->assertEquals($image->height(), $image->height());
        $this->assertEquals($image->height(), 300);

        $this->assertEquals(public_path().'/storage/avatars/user_0.png', public_path().$basePath);
        unlink(public_path().$basePath);
    }

}