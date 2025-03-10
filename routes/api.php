<?php

use App\Http\Domains\EAV\AttributeController;
use App\Http\Domains\Order\ApprovalController;
use App\Http\Domains\Order\OrderController;
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
    Route::get('logout', [AuthController::class, 'logout']);
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


/*
|--------------------------------------------------------------------------
| Attribute routes
|--------------------------------------------------------------------------
|
| Filtration and resource actions.
|
*/

Route::prefix('orders')->middleware(['auth:api'])->name('order.')->group(function () {

    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::get('/{order}', [OrderController::class, 'show']);
    Route::post('/{order}/submit', [OrderController::class, 'submitForApproval']);
    Route::get('/{order}/history', [OrderController::class, 'history']);
    Route::prefix('approvals')->group(function () {
        Route::get('/pending', [ApprovalController::class, 'pending']);
        Route::post('/{order}/approve', [ApprovalController::class, 'approve']);
        Route::post('/{order}/reject', [ApprovalController::class, 'reject']);
    });

});
