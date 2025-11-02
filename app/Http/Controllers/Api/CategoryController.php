<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Subcategory;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::all();
    }

    public function subcategories($id)
    {
        return Subcategory::where('category_id', $id)->get();
    }
}
