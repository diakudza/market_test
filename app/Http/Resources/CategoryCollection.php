<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{
    private $pagination;

    public static $wrap = 'category';

    public function __construct($resource)
    {
        $this->pagination = [
            'page' => $resource->currentPage(),
            'perPage' => $resource->lastPage(),
            'total' => $resource->total()
        ];

        parent::__construct($resource);
    }

    public function toArray($request)
    {
        return [
            'category' => $this->collection,
            'pagination' => $this->pagination,
        ];
    }

    public function toResponse($request)
    {
        return JsonResource::toResponse($request);
    }
}
