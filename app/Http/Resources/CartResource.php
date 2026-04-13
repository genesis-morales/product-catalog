<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'guest_token' => $this->guest_token,
            'items' => CartItemResource::collection($this->whenLoaded('items')),
            'subtotal' => (float) $this->subtotal,
            'total' => (float) $this->total,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
        ];
    }
}
