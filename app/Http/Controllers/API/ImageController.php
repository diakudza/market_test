<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Http\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Image;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();
        return ImageResource::collection($images);
    }

    /**
     * GET /api/image/{scope}
     * возвращает изображение по скоупу
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     *
     */
    public function show(string $scope)
    {
        return ImageResource::collection(
            (new Image())->image($scope)->get()
        ); //скоуп image(), не знал куда его применить. Сделал сюда
    }


    /**
     * Сохраняет изображение
     * POST /api/image
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:1024',
            'imageable_id' => 'required|integer|min:0',
            'imageable_type' => 'required|string',
            'path' => 'nullable|string',
            'from_url' => 'nullable|string',
            'disk' => 'nullable|in:(["disk","local","s3"])',
            'alt' => 'nullable|string',
            'title' => 'nullable|string',
            'scope' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return response(['error' => $error], 400);
        }

        $validated = $validator->validated();
        if ($request->hasFile('file')) {
            (new FileService)->upload($request->file('file'), $validated);
        }
        return response(['message' => 'Image was saved'], 201);
    }

    public function destroy($id)
    {

    }

    /**
     * Удаляет изображение по переданным параметрам
     * DELETE api/image/destroy_by_brand?imageable_id=6&imageable_type=mobile
     * @param Request $request
     * @param Image $image
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response|void
     * @throws \Illuminate\Validation\ValidationException
     */
    public function destroyByTypeAndBrand(Request $request, Image $image): Response
    {
        $validator = Validator::make($request->all(), [
            'imageable_id' => 'required|integer|min:0',
            'imageable_type' => 'required|string',
        ]);
        if ($validator->fails()) {
            $error = $validator->errors();
            return response(['error' => $error], 400);
        }
        $validated = $validator->validated();
        (new FileService)->delete($validated);

        return response(['message' => 'Image was deleted'], 201);
    }

}
