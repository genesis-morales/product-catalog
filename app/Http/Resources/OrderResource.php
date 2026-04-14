<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array {return [
            'id'           => $this->id,
            'order_number' => $this->order_number,
            'status'       => $this->status,
            'subtotal'     => (float) $this->subtotal,
            'total'        => (float) $this->total,
            'shipping'     => [
                'name'    => $this->shipping_name,
                'phone'   => $this->shipping_phone,
                'address' => $this->shipping_address,
                'city'    => $this->shipping_city,
                'notes'   => $this->shipping_notes,
            ],
            'items'        => $this->items->map(fn ($item) => [
                'id'           => $item->id,
                'product_name' => $item->product_name,
                'unit_price'   => (float) $item->unit_price,
                'quantity'     => $item->quantity,
                'total_price'  => (float) $item->total_price,
            ]),
            'created_at'   => $this->created_at->format('d/m/Y H:i'),
        ];
    }
}
