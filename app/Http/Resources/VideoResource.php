<?php

namespace App\Http\Resources;

use App\Policies\VideoPolicy;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class VideoResource extends JsonResource
{
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
            "url" => Storage::url($this->path),
            "can" => [
                "delete" => (new VideoPolicy())->delete(auth()->user(), $this->resource),
                "update" => (new VideoPolicy())->update(auth()->user(), $this->resource),
            ]
        ];

        return $arr;
    }
}
