<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic as Image;

class ImageUploadService
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = config('filesystems.default', 'public');
    }

    public function uploadProductImage(UploadedFile $image): string
    {
        $path = $image->store('products', $this->disk);

        if (class_exists(Image::class)) {
            $this->optimizeImage($path);
        }

        return $path;
    }

    public function url(string $path): string
    {
        return Storage::disk($this->disk)->url($path);
    }

    protected function optimizeImage(string $path): void
    {
        try {
            $imagePath = Storage::disk($this->disk)->path($path);
            Image::make($imagePath)
                ->resize(1200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })
                ->encode('webp', 80)
                ->save($imagePath);
        } catch (\Throwable $exception) {
            // Si no está instalado Intervention/Image o falla, no bloqueamos la subida.
        }
    }
}
