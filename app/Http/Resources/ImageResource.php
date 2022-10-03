<?php

namespace App\Http\Resources;

use App\Helpers\Thumb;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ImageResource extends JsonResource
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
            "id"=>$this->id,
            "name" => $this->name,
            "path" => $this->path,
            "size" => $this->size,
            "tags" => $this->tags,
            "extension" => $this->extension,
            "url" => Storage::url($this->path),
            "thumb_small" => Thumb::thumb($this->path, "cover.small"),
            "thumb_normal" => Thumb::thumb($this->path, "cover.normal"),
            "thumb_large" => Thumb::thumb($this->path, "cover.large"),
        ];
    }
}
