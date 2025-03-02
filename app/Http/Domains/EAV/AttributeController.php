<?php

namespace App\Http\Domains\EAV;


use App\Http\Controllers\Controller;
use App\Http\Domains\EAV\Contract\AttributeInterface;
use App\Http\Domains\EAV\Filter\AttributeFilter;
use App\Http\Domains\EAV\Model\Attribute;
use App\Http\Domains\EAV\Request\CreateAttributeRequest;
use App\Http\Domains\EAV\Request\UpdateAttributeRequest;
use App\Http\Domains\EAV\Resource\AttributeResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AttributeController extends Controller
{
    public function __construct(private AttributeInterface $repository)
    {
    }

    public function store(CreateAttributeRequest $request)
    {
        $attribute = $this->repository->create($request->validated());

        return $this->responseResource(AttributeResource::make($attribute), status: 201);
    }

    public function update(UpdateAttributeRequest $request, Attribute $attribute)
    {
        $attribute = $this->repository->update($attribute, $request->validated());

        return $this->responseResource(AttributeResource::make($attribute));
    }

    public function show(Attribute $attribute): AttributeResource|JsonResponse
    {
        return $this->responseResource(AttributeResource::make($attribute));
    }

    public function delete(Attribute $attribute): JsonResponse
    {
        $deleted = $this->repository->delete($attribute);
        if (!$deleted)
            return $this->error(__('common.not_found'), 404);

        return $this->success();
    }

    public function index(Request $request): JsonResponse
    {
        $query = AttributeFilter::apply($request);
        $attributes = $this->repository->list($query);

        return $this->responseResource(
            AttributeResource::collection($attributes)
        );
    }

}
