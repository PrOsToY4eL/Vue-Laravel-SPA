<?php

namespace App\Services;


use App\Exceptions\ValidationFaildException;
use App\User;
use App\Wrappers\UserSaveWrapper;
use File;
use Illuminate\Http\UploadedFile;
use Image;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Http\Request;
use Storage;
use function Symfony\Component\Debug\Tests\testHeader;
use Validator;

class AvatarReplacerService
{

    /* @var UploadFileService $uploadFileService */
    private $uploadFileService;

    /* @var UserSaveWrapper $userSaveWrapper */
    private  $userSaveWrapper;

    /**
     * AvatarReplacerService constructor.
     * @param UploadFileService $uploadFileService
     * @param UserSaveWrapper $userSaveWrapper
     */
    public function __construct(UploadFileService $uploadFileService, UserSaveWrapper $userSaveWrapper)
    {
        $this->uploadFileService = $uploadFileService;
        $this->userSaveWrapper = $userSaveWrapper;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function replaceUserAvatar(Request $request, User $user)
    {
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            if ($user->avatar !== 'storage/avatars/default.png') {
                unlink(public_path().'/'.$user->avatar);
            }
            $user->avatar = $this->uploadFileService->uploadUserAvatar($avatar, $user->id);
        }
        $this->userSaveWrapper->saveUser($user);
    }
}