<?php

namespace App\Services;


use App\Exceptions\ValidationFaildException;
use phpDocumentor\Reflection\Types\Boolean;
use function Symfony\Component\Debug\Tests\testHeader;
use Validator;

class UserValidationService
{
    private const NAME_RULE = 'required|string|max:255';
    private const EMAIL_RULE = 'required|string|email|max:255|unique:users';
    private const PASSWORD_RULE = 'required|min:6';
    private const AVATAR_RULE = 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048';

    /**
     * @var Validator $validator
     */
    private $validator;
    /**
     * @param int $id
     * @return string
     */
    private function emailRule(int $id = null):string
    {
        return ($id === null) ? self::EMAIL_RULE : self::EMAIL_RULE . ',email,' . $id;
    }

    /**
     * @param array $credentials
     * @param int $id
     * @return void
     * @throws ValidationFaildException
     */
    public function validateUser(array $credentials, int $id = null):void
    {
        $this->validator = Validator::make($credentials, [
            'name' => self::NAME_RULE,
            'email' => self::emailRule($id),
            'password'=> self::PASSWORD_RULE,
            'newPassword' => 'nullable|'.self::PASSWORD_RULE,
            'avatar' => self::AVATAR_RULE
        ]);
        if ($this->validator->fails()){
            throw new ValidationFaildException();
        }
    }

    /**
     * @return array
     */
    public function errors()
    {
        return $this->validator->errors();
    }

}