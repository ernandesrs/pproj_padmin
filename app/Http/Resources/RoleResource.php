<?php

namespace App\Http\Resources;

use App\Policies\Admin\RolePolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
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
            "view" => (new RolePolicy())->view(auth()->user(), $this->resource),
            "create" => (new RolePolicy())->create(auth()->user(), $this->resource),
            "update" => (new RolePolicy())->update(auth()->user(), $this->resource),
            "delete" => (new RolePolicy())->delete(auth()->user(), $this->resource)
        ];

        return $arr;
    }
}
