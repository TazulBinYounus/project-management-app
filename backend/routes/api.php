<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api','middleware' => ['OriginAllowPolicy']], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);

    Route::get('get-users', [UserController::class, 'getUsers']);

    Route::middleware(['auth:api'])->group(function () {

        Route::post('logout', [AuthController::class, 'logout']);
//        Route::get('get-users', [UserController::class, 'getUsers']);
        Route::get('user', [UserController::class, 'getAuthUser']);
        Route::post('assign-projects-to-member', [UserController::class, 'assignProjectToMember']);

        Route::get('get-groups', [GroupController::class, 'getGroups']);
        Route::get('get-projects', [ProjectController::class, 'getProjects']);
        Route::post('filter-projects', [ProjectController::class, 'filterProjects']);
        Route::post('assign-members-to-project', [ProjectController::class, 'assignMembersToProject']);
        Route::post('project-submit', [ProjectController::class, 'projectSubmit']);

    });
});



