<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandResource;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $brands = Brand::all();
        return BrandResource::collection($brands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Brand $brand
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Brand $brand)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:10|unique:brands,title',
            'display_on_home' => 'nullable|boolean',
            'banner_title' => 'nullable|string|min:10',
            'banner_description' => 'nullable|string|min:10',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return response(['error' => $error], 400);
        }

        $validated = $validator->validated();
        $validated['code'] = Str::uuid();
        $brand->fill($validated);
        $brand->save();

        return response(['message' => 'Brand was created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Brand $brand
     * @return BrandResource
     */
    public function show(Brand $brand)
    {
        return new BrandResource($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Brand $brand
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Brand $brand)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|min:10|unique:brands,title',
            'display_on_home' => 'nullable|boolean',
            'banner_title' => 'nullable|string|min:10',
            'banner_description' => 'nullable|string|min:10',
        ]);

        if ($validator->fails()) {
            $error = $validator->errors();
            return response(['error' => $error], 400);
        }
        $validated = $validator->validated();
        $brand->update($validated);
        $brand->save();
        return response(['message' => 'Brand was updated'], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand = Brand::find($id);

        if ($brand) {
            $brand->deleteOrFail();
            return response(['message' => 'brand was deleted'], 200);
        } else {
            return response(['message' => 'brand wasn\'t deleted'], 400);
        }
    }

    public function search(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string',
            'code' => 'nullable|string',
            'category' => 'nullable|string',
        ]);

        $validated = $validator->validated();

        $search = Brand::with('categories');

        if (isset($validated['title'])) {
            $search = $search->where('title', 'like', '%' . $validated['title'] . '%');
        }
        if (isset($validated['code'])) {
            $search = $search->where('code', '=', $validated['code']);
        }
        if (isset($validated['category'])) {
            $search = $search->whereRelation(
                'categories', 'title', 'LIKE', '%'. $validated['category'] .'%');
        }

        return BrandResource::collection($search->get());
    }
}
