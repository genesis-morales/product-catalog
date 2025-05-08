<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Subcategory extends Model
{
    use HasFactory;

    public function category() {

        //Una subcategoria pertenece a una categoría
        return $this->belongsTo(Category::class);
    }
    
    public function products() {

        //Una subcategoria tiene muchos productos
        return $this->hasMany(Product::class);
    }
    
}
