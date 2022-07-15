<?php

namespace App\Services;

use App\Http\Resources\UserCollection;
use App\Models\User;

class UserService
{

    protected $model;

    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public function getUsers(): \Illuminate\Http\JsonResponse
    {
        $user = $this->model->all();
        $payload = [
            'code' => 200,
            'app_message' => 'Successful',
            'data' => UserCollection::collection($user)
        ];
        return response()->json($payload, 200);
    }
}

