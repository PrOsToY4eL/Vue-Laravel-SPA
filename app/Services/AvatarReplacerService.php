<?php

namespace App\Services;


use App\Exceptions\ValidationFaildException;
use App\User;
use File;
use Illuminate\Http\UploadedFile;
use Image;
use phpDocumentor\Reflection\Types\Boolean;
use Storage;
use function Symfony\Component\Debug\Tests\testHeader;
use Validator;

class AvatarReplacerService
{

    /* @var UploadFileService $uploadFileService */
    private $uploadFileService;

    /* @var User $user */
    private $user;

    /**
     * AvatarReplacerService constructor.
     * @param UploadFileService $uploadFileService
     * @param User $user
     */
    public function __construct(UploadFileService $uploadFileService, User $user)
    {
        $this->uploadFileService = $uploadFileService;
        $this->user = $user;
    }

    public function replaceUserAvatar($avatar)
    {
        if ($avatar instanceof UploadedFile) {
            if ($this->user->avatar !== 'storage/avatars/default.png') {
                unlink(public_path().'/'.$this->user->avatar);
            }
            $this->user->avatar = $this->uploadFileService->uploadUserAvatar($avatar, $this->user->id);
        }
        else {
            $this->user->avatar = 'storage/avatars/default.png';
        }
        $this->user->save();
    }
}