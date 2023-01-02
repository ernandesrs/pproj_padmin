<?php

namespace App\Http\Resources;

use App\Helpers\Thumb;
use App\Models\Page;
use App\Policies\PagePolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
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

        $author = $this->author()->first();
        $arr["author"] = $author ? new UserResource($author) : null;
        $arr["slugs"] = $this->slugs()->first();
        $arr["can"] = [
            "view" => (new PagePolicy())->view(auth()->user(), $this->resource),
            "create" => (new PagePolicy())->create(auth()->user(), $this->resource),
            "update" => (new PagePolicy())->update(auth()->user(), $this->resource),
            "delete" => (new PagePolicy())->delete(auth()->user(), $this->resource)
        ];

        if ($this->content_type == Page::CONTENT_TYPE_VIEW)
            $arr["view_path"] = $this->content;
        else
            $arr["content"] = $this->content;

        return $this->thumbs("cover", $arr);
    }
}
