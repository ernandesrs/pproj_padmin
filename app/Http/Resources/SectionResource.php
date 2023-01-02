<?php

namespace App\Http\Resources;

use App\Policies\SectionPolicy;
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
        $arr =  parent::toArray($request);

        $arr['can'] = [
            'view' => (new SectionPolicy())->view($request->user(), $this->resource),
            'create' => (new SectionPolicy())->create($request->user(), $this->resource),
            'update' => (new SectionPolicy())->update($request->user(), $this->resource),
            'delete' => (new SectionPolicy())->delete($request->user(), $this->resource),
        ];

        return $arr;
    }
}
