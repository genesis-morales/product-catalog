<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SubcategoryResource;
use App\Models\Subcategory;
use App\Models\Product;

class SubcategoryController extends Controller
{
    public function products($id)
    {
        $products = Product::with('subcategory.category')
            ->where('subcategory_id', $id)
            ->get();

        return ProductResource::collection($products);
    }

    public function index()
    {
        $subcategories = Subcategory::all();

        return SubcategoryResource::collection($subcategories);
    }
}
