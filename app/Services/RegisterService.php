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
    private $userCreateWrapper;

    /**
     * RegisterService constructor.
     * @param UserCreateWrapper $userCreateWrapper
     */
    public function __construct(UserCreateWrapper $userCreateWrapper)
    {
        $this->userCreateWrapper = $userCreateWrapper;
    }

    /**
     * @param $userData
     * @return User
     * @throws UserNotCreatedException
     */
    public function registerUser(array $userData)
    {
        $credentials = [
            'name' => $userData['name'],
            'email' => $userData['email'],
            'password' => bcrypt($userData['password'])
        ];
        $user = $this->userCreateWrapper->createUser($credentials);

        if (!$user instanceof User) {
            throw new UserNotCreatedException('User was not created.');
        }

        return $user;
    }

}