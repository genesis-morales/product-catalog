<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', 'image', 'max:2048'], // máx ~2MB
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public'); // storage/app/public/products
            $url = asset('storage/' . $path); // URL pública

            return response()->json([
                'path' => $path,
                'url'  => $url,
            ]);
        }

        return response()->json(['message' => 'No se recibió archivo'], 400);
    }
}

