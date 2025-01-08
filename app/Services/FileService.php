<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class FileService
{
    public function createFunction($data)
    {
        if ($data->hasFile('file')) {
            // Original rasmni saqlash (webp formatida)
            $imagePath = $data->file('file')->store('images', 'public');
            $image = \Intervention\Image\Facades\Image::make($data->file('file'));
            $webpPath = 'images/' . pathinfo($imagePath, PATHINFO_FILENAME) . '.webp';
            $image->encode('webp', 90); // 90% sifat bilan WebP formatga o'girish
            Storage::disk('public')->put($webpPath, (string) $image);
            $imageUrl = url('storage/' . $webpPath);

            // Blur rasmni tayyorlash va siqish (webp formatida)
            $blurredImage = $image->blur(10)->encode('webp', 100); // Sifatni 100% ga tushirish
            $blurredPath = 'images/blurred_' . pathinfo($imagePath, PATHINFO_FILENAME) . '.webp';
            Storage::disk('public')->put($blurredPath, (string) $blurredImage);
            $blurredUrl = url('storage/' . $blurredPath);

            // Rasm hajmini tekshirish va kerak bo'lsa o'lchamini o'zgartirish
            $driver = config('image.driver', 'gd');
            $manager = new ImageManager(['driver' => $driver]);
            $img = $manager->make($data->file('file')->getPathname());

            $maxDimension = 1024;
            if ($img->width() > $maxDimension || $img->height() > $maxDimension) {
                $img->resize($maxDimension, $maxDimension, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }

            // Ma'lumotlarni bazaga saqlash yoki boshqa maqsadlar uchun qaytarish
            return [
                'original_url' => $imageUrl,
                'blurred_url' => $blurredUrl,
            ];
        } else {
            throw new \Exception('Fayl topilmadi.');
        }
    }
}
