<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationFaildException;
use App\Services\AvatarReplacerService;
use App\Services\UploadFileService;
use App\Services\UserValidationService;
use App\User;
use App\Wrappers\UserSaveWrapper;
use Auth;
use Illuminate\Http\Request;
use Hash;
use Image;
use Storage;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function edit(Request $request)
    {
        /** @var User $user */
        $user = Auth::guard('api')->user();

        try {
            /** @var UserValidationService $userValidationService */
            $userValidationService = new UserValidationService();
            $userValidationService->validateUser($request->all(), $user->id);
        } catch (ValidationFaildException $e) {
            return response()->json($userValidationService->errors(), 500);
        }

        $avatarReplacerService = new AvatarReplacerService(new UploadFileService(), new UserSaveWrapper());
        $avatarReplacerService->replaceUserAvatar($request, $user);

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['errors' => ['Old password is invalid']], 500);
        }

        $user->update([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->newPassword)
        ]);

        return response()->json($user);
    }
}
