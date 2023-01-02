<?php

namespace App\Http\Resources;

use App\Policies\Media\ImagePolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
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
            "view" => (new ImagePolicy())->view(auth()->user(), $this->resource),
            "create" => (new ImagePolicy())->create(auth()->user(), $this->resource),
            "delete" => (new ImagePolicy())->delete(auth()->user(), $this->resource),
            "update" => (new ImagePolicy())->update(auth()->user(), $this->resource),
        ];

        return $this->thumbs("path", $arr);
    }
}
