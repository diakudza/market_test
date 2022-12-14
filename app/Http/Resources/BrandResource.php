<?php

namespace App\Http\Resources;

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
            'title' => $this->title,
            'code' => $this->code,
            'category' =>  CategoryOneResource::collection($this->categories),
            'images' =>  ImageOneResource::collection($this->images),
            'banner_title' => $this->banner_title,
            'banner_description' => $this->banner_description,
        ];
    }
}
