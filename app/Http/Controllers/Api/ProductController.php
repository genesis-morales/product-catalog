<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        return Product::all();
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'available' => 'boolean',
            'subcategory_id' => 'required|integer',
        ]);

        return Product::create($validated);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'string',
            'description' => 'string',
            'price' => 'numeric',
            'stock' => 'integer',
            'available' => 'boolean',
        ]);

        $product->update($validated);
        return $product;
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Producto eliminado'], 200);
    }
}
