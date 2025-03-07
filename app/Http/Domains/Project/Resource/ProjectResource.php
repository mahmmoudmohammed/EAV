<?php

namespace App\Http\Domains\Project\Resource;
use App\Http\Domains\User\Resource\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'users' => UserResource::collection($this->whenLoaded('users')),
            'extra_dynamic_attributes'  => $this->getAttributeValues(),

        ];
    }
}

