<?php

namespace App\Services;

use App\Http\Resources\ProjectCollection;
use App\Models\Project;
use App\Models\User;
use http\Env\Request;


class ProjectService
{

    protected $model;
    protected $user;

    public function __construct(Project $project, User $user)
    {
        $this->model = $project;
        $this->user = $user;
    }

    public function getProjects(): \Illuminate\Http\JsonResponse
    {
        $data = $this->model->all();
        $payload = [
            'code' => 200,
            'app_message' => 'Successful',
            'data' => ProjectCollection::collection($data)
        ];
        return response()->json($payload, 200);
    }

    public function assignMembers($request): \Illuminate\Http\JsonResponse
    {
        if (!$request->filled('project_id') || !$request->filled('user_ids')) {
            $payload = [
                'code' => 400,
                'app_message' => 'Invalid! Please Enter Valid Input',
            ];
            return response()->json($payload, 200);
        }

        $project = $this->model->find($request->project_id);
        $result = $project->users()->sync($request->user_ids);
        if ($result){
            $payload = [
                'code' => 200,
                'app_message' => 'Successful',
                'data' => new ProjectCollection($project)
            ];
            return response()->json($payload, 200);
        }

        $payload = [
            'code' => 400,
            'app_message' => 'Failed',
            'data' => new ProjectCollection($project)
        ];
        return response()->json($payload, 200);
    }

    public function filterProjects($request): \Illuminate\Http\JsonResponse
    {
        $query = $data = $this->model->query();

        if($request->filled('from_date')){
            $query = $query->whereDate('created_at','>=',$request->from_date);
        }
        if($request->filled('to_date')){
            $query = $query->whereDate('created_at','<=',$request->to_date);
        }

        if($request->filled('name') ){
            $userIds = $this->user->where('name', 'LIKE', "%$request->name%" )->pluck('id');
            $query = $query->whereHas('users', function ($query) use ($userIds) {
                $query->whereIn('project_user.user_id', $userIds);
            });
        }

        $data = $query->get();
        $payload = [
            'code' => 200,
            'app_message' => 'Successful',
            'data' => ProjectCollection::collection($data)
        ];
        return response()->json($payload, 200);
    }
}

