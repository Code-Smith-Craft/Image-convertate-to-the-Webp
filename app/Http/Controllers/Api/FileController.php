<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Image\ImageStoreRequest;
use App\Services\FileService;
use Illuminate\Http\Request;

class FileController extends Controller
{
    protected $file_service;

    public function __construct(FileService $file_service)
    {
        $this->file_service = $file_service;
    }

    public function store(ImageStoreRequest $request)
    {
        try {
            $response = $this->file_service->createFunction($request);
            return response()->json([
                "success" => true,
                "message" => "Harakat muvofaqiyatli bajarildi!",
                "result" => $response
            ]);
        } catch (\Throwable $throwable) {
            return response()->json([
                "error" => "Xatolik yuz berdi: " . $throwable->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        //
    }
}
