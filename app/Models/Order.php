<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
   protected $fillable = [
        'user_id', 'order_number', 'status',
        'subtotal', 'total',
        'shipping_name', 'shipping_phone',
        'shipping_address', 'shipping_city', 'shipping_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
