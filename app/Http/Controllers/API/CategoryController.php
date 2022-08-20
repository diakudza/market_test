<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BrandCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryOneResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Category $category)
    {
        return new CategoryCollection($category->paginate(5));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param Category $category
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:10|unique:categories,title'
        ]);

        if($validator->fails()){
            $error = $validator->errors();
            return response(['error' => $error], 400);
        }

        $validated = $validator->validated();
        $validated['slug'] = Str::slug($validated['title'], '-');
        $category->fill($validated);
        $category->save();

        return response(['message' => 'Category was created'], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Category $category)
    {
        return new CategoryOneResource($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param \App\Models\Category $category
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:10|unique:categories,title'
        ]);

        if($validator->fails()){
            $error = $validator->errors();
            return response(['error' => $error], 400);
        }
        $validated = $validator->validated();
        $validated['slug'] = Str::slug($validated['title'], '-');
        $category->update($validated);
        $category->save();
        return response(['message' => 'Category was updated'], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if ($category) {
            $category->deleteOrFail();
            return response(['message' => 'Category was deleted'], 200);
        } else {
            return response(['message' => 'Category wasn\'t deleted'], 400);
        }
    }
}
