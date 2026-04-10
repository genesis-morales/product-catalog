<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadProductImageRequest;
use App\Services\ImageUploadService;

class ProductImageController extends Controller
{
    public function store(UploadProductImageRequest $request, ImageUploadService $imageUpload)
    {
        $path = $imageUpload->uploadProductImage($request->file('image'));
        $url = $imageUpload->url($path);

        return response()->json([
            'path' => $path,
            'url' => $url,
        ], 201);
    }
}

