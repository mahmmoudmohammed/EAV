<?php

use App\Http\Domains\EAV\AttributeController;
use App\Http\Domains\Project\ProjectController;
use App\Http\Domains\User\AuthController;
use App\Http\Domains\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User routes
|--------------------------------------------------------------------------
|
| Authentication and resource actions.
|
*/

Route::name('user.')
    ->middleware('throttle:5,60')
    ->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::middleware(['auth:api'])->name('user.')->group(function () {
    Route::get('logout', [UserController::class, 'logout']);
    Route::apiResource('users', UserController::class);
});

/*
|--------------------------------------------------------------------------
| Project routes
|--------------------------------------------------------------------------
|
| Filtration and resource actions.
|
*/


Route::middleware(['auth:api'])->name('project.')->group(function () {
    Route::apiResource('projects', ProjectController::class);
});

/*
|--------------------------------------------------------------------------
| Attribute routes
|--------------------------------------------------------------------------
|
| Filtration and resource actions.
|
*/

Route::middleware(['auth:api'])->name('attribute.')->group(function () {
    Route::apiResource('attributes', AttributeController::class);
});
