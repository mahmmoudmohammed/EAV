<?php

namespace App\Http\Domains\Order\Resource;
use App\Http\Domains\User\Resource\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderLogResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'changed_by' => $this->changed_by,
            'notes' => $this->notes,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order' => UserResource::collection($this->whenLoaded('order')),

        ];
    }
}

