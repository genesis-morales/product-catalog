<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => (float) $this->price,
            'stock' => $this->stock,
            'available' => (bool) $this->available,
            'img' => $this-> img,
            'subcategory' => new SubcategoryResource($this->whenLoaded('subcategory')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
