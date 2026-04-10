<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'stock',
        'available',
        'img',
        'subcategory_id',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'available' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function getImageUrlAttribute()
    {
        if (! $this->img) {
            return null;
        }

        return Storage::disk(config('filesystems.default'))->url($this->img);
    }
}
