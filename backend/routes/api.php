<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\GroupController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('registration', [AuthController::class, 'registration']);
    Route::get('get-users', [UserController::class, 'getUsers']);

    Route::middleware(['auth:api'])->group(function () {
        Route::get('get-groups', [GroupController::class, 'getGroups']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});



