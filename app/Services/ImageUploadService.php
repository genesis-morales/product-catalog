<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Cloudinary\Configuration\Configuration;
use Illuminate\Http\UploadedFile;

class ImageUploadService
{
    private Cloudinary $cloudinary;

    public function __construct()
    {
        $this->cloudinary = new Cloudinary(
            Configuration::instance([
                'cloud' => [
                    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
                    'api_key'    => env('CLOUDINARY_API_KEY'),
                    'api_secret' => env('CLOUDINARY_API_SECRET'),
                ],
                'url' => [
                    'secure' => true,
                ],
            ])
        );
    }

    public function uploadProductImage(UploadedFile $file): string
    {
        $result = $this->cloudinary->uploadApi()->upload($file->getRealPath(), [
            'folder' => 'product-catalog/products',
            'transformation' => [
                'width'        => 800,
                'height'       => 800,
                'crop'         => 'fill',
                'quality'      => 'auto',
                'fetch_format' => 'auto',
            ],
        ]);

        return $result['secure_url'];
    }

    public function url(string $path): string
    {
        return $path;
    }
}