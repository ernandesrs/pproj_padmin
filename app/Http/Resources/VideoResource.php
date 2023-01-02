<?php

namespace App\Http\Resources;

use App\Policies\Media\VideoPolicy;
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
        $arr = parent::toArray($request);

        $arr["url"] = Storage::url($this->path);
        $arr["can"] = [
            "view" => (new VideoPolicy())->view(auth()->user(), $this->resource),
            "create" => (new VideoPolicy())->create(auth()->user(), $this->resource),
            "update" => (new VideoPolicy())->update(auth()->user(), $this->resource),
            "delete" => (new VideoPolicy())->delete(auth()->user(), $this->resource),
        ];

        return $arr;
    }
}
