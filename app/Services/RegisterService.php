<?php
/**
 * Created by PhpStorm.
 * User: yaroslav
 * Date: 17.10.18
 * Time: 12:25
 */

namespace App\Http\Services;

use App\User;
use App\Exceptions\UserNotCreatedException;
use App\Wrappers\UserCreateWrapper;
class RegisterService
{
    /**
     * @param $userData
     * @return User
     * @throws UserNotCreatedException
     */
    public static function registerUser(array $userData)
    {
        $credentials = [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password'])
        ];
        //$user = User::create($credentials);
        $user = UserCreateWrapper::createUser($credentials);
        if (!$user instanceof User) {
            throw new UserNotCreatedException();
        }

        return $user;
    }

}