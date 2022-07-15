<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getUsers(): \Illuminate\Http\JsonResponse
    {
        return $this->userService->getUsers();
    }

    public function assignProjectToMember(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->userService->assignProjects($request);
    }

}
