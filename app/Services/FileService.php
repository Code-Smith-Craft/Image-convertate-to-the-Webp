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
            $img->encode('webp', 90);
            $file_path = Carbon::now()->format('d-m-Y');
            $filePath = $path . '/' . $file_path . '/' . time() . uniqid() . '-' . $file->getClientOriginalName();
            Storage::disk('public')->put($filePath, (string) $img);
            return [
                'file_path' => $filePath,
                'url' => Storage::url($filePath)
            ];
        } else {
            throw new \Exception('Fayl topilmadi.');
        }
    }
}
