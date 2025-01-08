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

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
