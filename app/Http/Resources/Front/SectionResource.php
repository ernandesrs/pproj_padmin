<?php

namespace App\Http\Resources\Front;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->resource->images;

        $arr = parent::toArray($request);

        $arr['can'] = [
            'view' => true,
            'create' => true,
            'update' => true,
            'delete' => true,
        ];

        return $arr;
    }
}
