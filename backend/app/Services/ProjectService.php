<?php

namespace App\Services;

use App\Http\Resources\ProjectCollection;
use App\Models\Project;


class ProjectService
{

    protected $model;

    public function __construct(Project $project)
    {
        $this->model = $project;
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

//        $explodeUserIds = explode(',', $request->user_ids);
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
}

