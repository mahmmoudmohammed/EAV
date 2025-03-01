<?php

use App\Http\Domains\User\AuthController;
use App\Http\Domains\User\UserController;
use Illuminate\Http\Request;
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
});

/*
|--------------------------------------------------------------------------
| Project routes
|--------------------------------------------------------------------------
|
| Filtration and resource actions.
|
*/
