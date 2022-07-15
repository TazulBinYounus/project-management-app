<?php

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function login($request): \Illuminate\Http\JsonResponse
    {
        $user = $this->model->where('email', '=', trim($request->email))->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('ProjectManagementApp')->accessToken;
            $payload = [
                'code' => 200,
                'app_message' => 'login Successful, credentials matched.',
                'user_message' => 'login Successful.',
                'access_token' => $token,
                'data' => new UserCollection($user)
            ];
            return response()->json($payload, 200);
        }
        $payload = [
            'code' => 401,
            'app_message' => 'Login unsuccessful, unauthorised access attempt',
            'user_message' => 'Login unsuccessful, unauthorised access attempt.',
        ];
        return response()->json($payload, 401);
    }

    public function registration($request): \Illuminate\Http\JsonResponse
    {
        $inputs = $request->all();
        $inputs['password'] = Hash::make($request->password);
        $user = $this->model->create($inputs);
        if ($user) {
            $payload = [
                'code' => 200,
                'app_message' => 'Registration Successful',
                'user_message' => 'Registration Successful.',
                'data' => new UserCollection($user),
            ];
            return response()->json($payload, 200);
        }
        $payload = [
            'code' => 500,
            'app_message' => 'Registration unsuccessful',
            'user_message' => 'Registration unsuccessful.',
        ];
        return response()->json($payload, 500);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        if (Auth::user()) {
            $token = \auth()->user()->token();
            $token->revoke();
            $payload = [
                'code' => 200,
                'app_message' => 'You have been successfully logged out!',
                'user_message' => 'You have been successfully logged out!'
            ];
            return response()->json($payload, 200);
        }
        $payload = [
            'code' => 401,
            'app_message' => 'not found',
            'user_message' => 'Invalid user.'
        ];
        return response()->json($payload, 401);
    }
}

