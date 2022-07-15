<?php

namespace App\Services;

use App\Http\Resources\GroupCollection;
use App\Http\Resources\UserCollection;
use App\Models\Group;


class GroupService
{

    protected $model;

    public function __construct(Group $group)
    {
        $this->model = $group;
    }

    public function getGroups(): \Illuminate\Http\JsonResponse
    {
        $user = $this->model->all();
        $payload = [
            'code' => 200,
            'app_message' => 'Successful',
            'data' => GroupCollection::collection($user)
        ];
        return response()->json($payload, 200);
    }
}

