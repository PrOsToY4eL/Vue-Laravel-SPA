<?php

namespace App\Wrappers;

use App\User;

class UserCreateWrapper
{
    public static function createUser(array $credentials)
    {
        $user = User::create($credentials);
        return $user;
    }
}