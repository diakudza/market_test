<?php

use App\Http\Controllers\API\BrandController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::delete('/image/destroy_by_brand',[ImageController::class,'destroyByTypeAndBrand']);
Route::Resource('image',ImageController::class);

Route::get('search',[BrandController::class,'search']);
Route::Resource('brand',BrandController::class);

Route::Resource('category',CategoryController::class);

