<?php

namespace App\Services;


use App\Exceptions\ValidationFaildException;
use phpDocumentor\Reflection\Types\Boolean;
use Storage;
use function Symfony\Component\Debug\Tests\testHeader;
use Validator;

class UploadFileService
{
    /**
     * @param string $path
     * @param $contents
     */
    public static function uploadFile(string $path, $contents)
    {
        Storage::disk('local')->put($path, $contents);
    }
}