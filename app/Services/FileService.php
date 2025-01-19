<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class FileService
{
    public function createFunction($path,$image)
    {
        if ($image->hasFile('file')) {
            $file = $image->file('file');

            $driver = config('image.driver', 'gd');
            $manager = new ImageManager(['driver' => $driver]);
            $img = $manager->make($file->getPathname());

            // Faylni WebP formatida kodlaymiz
            $img->encode('webp', 90);

            // Fayl yo'lini yaratamiz
            $file_path = Carbon::now()->format('d-m-Y');
            $filePath = $path . '/' . (string)$file_path . '/' . time() . uniqid() . '-' . $file->getClientOriginalName();



        } else {
            throw new \Exception('Fayl topilmadi.');
        }
    }
}
