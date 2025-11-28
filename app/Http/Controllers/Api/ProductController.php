<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10); // tamaño de página
        $products = Product::with('subcategory.category')
            ->orderBy('id', 'desc')        // orden por defecto
            ->paginate($perPage);

        return response()->json($products);    
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
            'img' => 'nullable|string',

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
