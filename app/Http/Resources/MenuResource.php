<?php

namespace App\Http\Resources;

use App\Policies\MenuPolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
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
            "view" => (new MenuPolicy())->view(auth()->user(), $this->resource),
            "create" => (new MenuPolicy())->create(auth()->user(), $this->resource),
            "update" => (new MenuPolicy())->update(auth()->user(), $this->resource),
            "delete" => (new MenuPolicy())->delete(auth()->user(), $this->resource),
        ];

        return $arr;
    }
}
