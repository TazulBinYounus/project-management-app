<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    public function getProjects(): \Illuminate\Http\JsonResponse
    {
        return $this->projectService->getProjects();
    }

    public function assignMembersToProject(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->projectService->assignMembers($request);
    }

    public function filterProjects(Request $request): \Illuminate\Http\JsonResponse
    {
        return $this->projectService->filterProjects($request);
    }

}
