<?php

namespace App\Wrappers;

use App\User;

/**
 * Class UserCreateWrapper
 * @package App\Wrappers
 */
class UserCreateWrapper
{
    /**
     * @param array $credentials
     * @return User|null
     */
    public static function createUser(array $credentials)
    {
        if (
            !array_key_exists('name', $credentials)
            || !array_key_exists('email', $credentials)
            || !array_key_exists('password', $credentials)
        ) {
            return null;
        }

        $user = User::create($credentials);

        return $user;
    }
}