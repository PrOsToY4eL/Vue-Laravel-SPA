<?php

namespace App\Wrappers;

use App\User;

/**
 * Class UserCreateWrapper
 * @package App\Wrappers
 */
class UserSaveWrapper
{
    /**
     * @param User $user
     * @return User|null
     */
    public static function saveUser(User $user)
    {
        $user->save();
        return $user;
    }
}