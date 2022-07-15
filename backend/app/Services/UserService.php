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

    public function getAuthUser(): \Illuminate\Http\JsonResponse
    {
        $data = auth()->user();
        $payload = [
            'code' => 200,
            'app_message' => 'Successful',
            'data' => new UserCollection($data)
        ];
        return response()->json($payload, 200);
    }


    public function assignProjects($request): \Illuminate\Http\JsonResponse
    {

        if (!$request->filled('user_id') || !$request->filled('project_ids')) {
            $payload = [
                'code' => 500,
                'app_message' => 'Invalid! Please Enter Valid Input',
            ];
            return response()->json($payload, 200);
        }




        $explodeProjectIds = explode(',', $request->project_ids);
        $user = $this->model->find($request->user_id);
        $result = $user->projects()->sync($explodeProjectIds);
        if ($result){
            $payload = [
                'code' => 200,
                'app_message' => 'Successful',
                'data' => new UserCollection($user)
            ];

            return response()->json($payload, 200);
        }

        $payload = [
            'code' => 400,
            'app_message' => 'Failed',
            'data' => new UserCollection($user)
        ];
        return response()->json($payload, 200);
    }
}

