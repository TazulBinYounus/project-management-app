<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GroupService;

class GroupController extends Controller
{

    protected $groupService;

    public function __construct(GroupService $groupService)
    {
        $this->groupService = $groupService;
    }

    public function getGroups(): \Illuminate\Http\JsonResponse
    {
        return $this->groupService->getGroups();
    }

}
