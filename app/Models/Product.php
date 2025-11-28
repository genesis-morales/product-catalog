<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    //Esto le dice a Laravel qué campos se pueden guardar con create().
    protected $fillable = ['name', 'description', 'price', 'stock', 'available', 'img', 'subcategory_id','img'];    
    
    use HasFactory;

    public function subcategory() {
        return $this->belongsTo(Subcategory::class);
    }
}
