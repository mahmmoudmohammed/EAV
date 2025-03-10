<?php

namespace App\Http\Domains\Order\Resource;
use App\Http\Domains\User\Resource\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            //TODO::replace sku and name with Product Resource
            'id' => $this->id,
            'product_name' => $this->product->name,
            'product_sku' => $this->product->sku,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'subtotal' => $this->subtotal,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'order' => UserResource::collection($this->whenLoaded('order')),
        ];
    }
}

