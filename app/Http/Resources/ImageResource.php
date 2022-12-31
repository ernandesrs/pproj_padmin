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
        $arr = [
            "id" => $this->id,
            "name" => $this->name,
            "path" => $this->path,
            "size" => $this->size,
            "tags" => $this->tags,
            "extension" => $this->extension,
            "can" => [
                "delete" => (new ImagePolicy())->delete(auth()->user(), $this->resource),
                "update" => (new ImagePolicy())->update(auth()->user(), $this->resource),
            ]
        ];

        $arr = $this->thumbs("path", $arr);

        return $arr;
    }
}
