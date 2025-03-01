<?php

namespace App\Http\Domains\User;


use App\Http\Controllers\Controller;
use App\Http\Domains\User\Filter\UserFilter;
use App\Http\Domains\User\Contract\UserInterface;
use App\Http\Domains\User\Model\User;
use App\Http\Domains\User\Request\CreateUserRequest;
use App\Http\Domains\User\Resource\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class UserController extends Controller
{
    private $repository;

    public function __construct(UserInterface $user)
    {
        $this->repository = $user;
    }
    public function store(CreateUserRequest $request)
    {
        $user = $this->repository->create($request->validated());

        return $this->responseResource(
            UserResource::make($user),
            status: 201
        );
    }

    public function find(User $model): UserResource|JsonResponse
    {
        $user = $this->repository->getById($model->id);
        if (!$user)
            return $this->error(__('common.not_found'), 404);
        $user->load('details');

        return $this->responseResource(
            UserResource::make($user),
        );
    }

    public function delete(User $model): JsonResponse
    {
        $deleted = $this->repository->delete($model->id);
        if (1 > $deleted)
            return $this->error(__('common.not_found'), 404);

        return $this->success();
    }

    public function index(Request $request): JsonResponse
    {
        $query = UserFilter::apply($request);
        $models = $this->repository->list($query);

        return $this->responseResource(
            UserResource::collection($models)
        );
    }

}
