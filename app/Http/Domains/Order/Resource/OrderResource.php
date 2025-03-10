<?php

namespace App\Http\Domains\Order\Resource;
use App\Http\Domains\User\Resource\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'items' => UserResource::collection($this->whenLoaded('items')),
            'history' => OrderLogResource::collection($this->whenLoaded('history')),
            'user' => UserResource::collection($this->whenLoaded('user')),

        ];
    }
}

