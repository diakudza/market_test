<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'brand_title' => $this->title,
            'brand_code' => $this->code,
            'brand_category' =>  CategoryResource::collection($this->categories),
            'brand_images' =>  ImageResource::collection($this->images),
            'brand_banner_title' => $this->banner_title,
            'brand_banner_description' => $this->banner_description,
        ];
    }
}
