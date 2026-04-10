<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubcategoryResource;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryController extends Controller
{
    public function index()
    {
        return CategoryResource::collection(Category::with('subcategories')->get());
    }

    public function subcategories($id)
    {
        $subcategories = Subcategory::where('category_id', $id)->get();

        return SubcategoryResource::collection($subcategories);
    }
}
