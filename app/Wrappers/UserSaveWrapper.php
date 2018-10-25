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
     * @return void
     */
    public static function saveUser(User $user)
    {
        $user->save();
    }
}