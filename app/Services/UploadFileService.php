<?php

namespace App\Services;


use App\Exceptions\ValidationFaildException;
use File;
use Illuminate\Http\UploadedFile;
use Image;
use phpDocumentor\Reflection\Types\Boolean;
use Storage;
use function Symfony\Component\Debug\Tests\testHeader;
use Validator;

class UploadFileService
{

    /**
     * @param UploadedFile $avatar
     * @param int $user_id
     * @return string
     */
    public static function uploadUserAvatar(UploadedFile $avatar, int $user_id):string
    {
        $image = Image::make($avatar);
        $square = ($image->width() > $image->height()) ? $image->width() : $image->height();
        $coef = ($square > 300) ? 300 / $square : 1;
        $basePath = '/storage/avatars/user_' . $user_id . '.' . $avatar->getClientOriginalExtension();
        $image->resize($image->width() * $coef, $image->height() * $coef)
            ->save(public_path().$basePath);

        return $basePath;
    }
}