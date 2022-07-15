<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Services\AuthService;

class AuthController extends Controller
{

    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->authService->login($request);
    }

    public function registration(RegistrationRequest $request): \Illuminate\Http\JsonResponse
    {
        return $this->authService->registration($request);
    }

    public function logout(): \Illuminate\Http\JsonResponse
    {
        return $this->authService->logout();
    }
}
