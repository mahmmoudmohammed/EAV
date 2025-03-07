<?php

namespace App\Http\Domains\User;

use App\Http\Controllers\Controller;
use App\Http\Domains\User\Contract\AuthInterface;
use App\Http\Domains\User\Request\CreateUserRequest;
use App\Http\Domains\User\Request\UserLoginRequest;
use App\Http\Domains\User\Resource\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthInterface $repository)
    {
    }

    public function register(CreateUserRequest $request)
    {
        $user = $this->repository->register($request->validated());

        return (new UserResource($user))->additional([
            'token' => $user->createToken($request->ip())->accessToken,
        ]);
    }

    public function login(UserLoginRequest $request): UserResource|JsonResponse
    {
        $admin = $this->repository->login($request->validated());
        if (!$admin) {
            //TODO:: add translation message
            return $this->ApiResponse(401, __('auth.failed'));
        }
        return (new UserResource($admin))->additional([
            'token' => $admin->createToken($request->ip())->accessToken,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();

        return $this->success();
    }
}
