<?php

namespace App\Http\Controllers;

use App\Exceptions\ValidationFaildException;
use App\Services\UserValidationService;
use App\User;
use App\Wrappers\UserCreateWrapper;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions\UserNotCreatedException;
use App\Http\Services\RegisterService;
use Validator;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \App\Exceptions\ValidationFaildException
     */
    public function edit(Request $request)
    {
        $path = $request->file('avatar')->storeAs(
            'avatars', 'users_avatar_'.$request->user()->id.'.'.$request->imgExtension
        );
        try {
            /** @var User $user */
            $user = $this->guard()->user();
            $userValidationService = new UserValidationService();
            $userValidationService->validateUser($request->all(), $user->id);
        }
        catch (ValidationFaildException $e){
            return response()->json($userValidationService->errors(),401);
        }

        if (!Hash::check($request->password, $user->password))
        {
            return response()->json(['errors' => ['Old password is invalid']], 401);
        }

        $user->update([
            'email' => $request->email,
            'name' => $request->name,
            'password' => bcrypt($request->newPassword)
        ]);

        return response()->json($user);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password'=> 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),401);
        }
        try {
            $registerService = new RegisterService(new UserCreateWrapper());
            $user = $registerService->registerUser($request->all());
            Auth::login($user);
            $token = auth('api')->attempt([
                'email' => $request->email,
                'password' => $request->password
            ]);
            return $this->respondWithToken($token);
        } catch (UserNotCreatedException $e){
            $response = new Response();
            $response->setStatusCode(500);
            $response->setContent(['Errors'=> ['Error: can`t create new user']]);
            return $response;
        }
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = auth('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth('api')->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth('api')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'user' => $this->guard()->user(),
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ]);
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard|\Illuminate\Contracts\Auth\StatefulGuard
     */
    public function guard() {
        return \Auth::Guard('api');
    }
}
