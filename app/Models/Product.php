<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Product extends Model
{
    use HasFactory;

    public function subcategory() {

        //Un producto pertenece a una subcategoría
        return $this->belongsTo(Subcategory::class);
    }
    
}
