<?php

namespace Tests\Unit;

use App\Services\AvatarReplacerService;
use App\Services\UploadFileService;
use App\User;
use Faker\Factory;
use Illuminate\Http\UploadedFile;
use Image;
use Storage;
use Tests\TestCase;


class AvatarReplacerTest extends TestCase
{
    /**
     * @return void
     */
    public function testAvatarReplaceSuccess()
    {
        $avatar = UploadedFile::fake()->image('avatar.png', 100, 100)->size(100);
        /* @var User $user */
        $user = factory(User::class)->make();

        $avatarReplacerService = new AvatarReplacerService(new UploadFileService(), $user);
        $avatarReplacerService->replaceUserAvatar($avatar);

        $this->assertEquals('/avatars/user_'.$user->id.'.png', $user->avatar);

        Storage::disk('public')->assertExists('/avatars/user_'.$user->id.'.png');

        //unlink(public_path().$user->avatar);
    }
}
