<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Services\ImageUploadService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 10);

        $products = Product::with(['subcategory.category'])
            ->orderByDesc('id')
            ->paginate($perPage);

        return ProductResource::collection($products);
    }

    public function store(StoreProductRequest $request, ImageUploadService $imageUpload)
    {
        $validated = $request->safe()->only(['name', 'description', 'price', 'stock', 'available', 'subcategory_id']);

        if ($request->hasFile('image')) {
            $validated['img'] = $imageUpload->uploadProductImage($request->file('image'));
        }

        $product = Product::create($validated);

        return new ProductResource($product->load(['subcategory.category']));
    }

    public function update(UpdateProductRequest $request, Product $product, ImageUploadService $imageUpload)
    {
        $validated = $request->safe()->only(['name', 'description', 'price', 'stock', 'available', 'subcategory_id']);

        if ($request->hasFile('image')) {
            $validated['img'] = $imageUpload->uploadProductImage($request->file('image'));
        }

        $product->update(array_filter($validated, fn ($value) => $value !== null));

        return new ProductResource($product->fresh(['subcategory.category']));
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Producto eliminado correctamente'], 200);
    }
}
