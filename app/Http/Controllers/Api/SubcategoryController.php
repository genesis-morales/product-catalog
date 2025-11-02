<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subcategory;
use App\Models\Product;

class SubcategoryController extends Controller
{
    public function products($id)
    {
        return Product::where('subcategory_id', $id)->get();
    }

    public function index()
{
    $subcategories = Subcategory::all();
    return response()->json($subcategories);
}
}
