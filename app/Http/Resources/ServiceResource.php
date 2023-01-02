<?php

namespace App\Http\Resources;

use App\Policies\Front\ServicePolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    use ResourceTrait;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $arr = parent::toArray($request);

        $arr["can"] = [
            "view" => (new ServicePolicy())->view(auth()->user(), $this->resource),
            "create" => (new ServicePolicy())->create(auth()->user(), $this->resource),
            "update" => (new ServicePolicy())->update(auth()->user(), $this->resource),
            "delete" => (new ServicePolicy())->delete(auth()->user(), $this->resource)
        ];

        return $arr;
    }
}
