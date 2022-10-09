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
        $author = $this->author()->first();

        $arr["id"] = $this->id;
        $arr["author"] = $author ? new UserResource($author) : null;
        $arr["slugs"] = $this->slugs()->first();
        $arr["title"] = $this->title;
        $arr["description"] = $this->description;
        $arr["follow"] = $this->follow;
        $arr["lang"] = $this->lang;
        $arr["content_type"] = $this->content_type;
        $arr["protection"] = $this->protection;
        $arr["status"] = $this->status;
        $arr["published_at"] = $this->published_at;
        $arr["schedule_to"] = $this->schedule_to;
        $arr["created_at"] = $this->created_at;
        $arr["updated_at"] = $this->updated_at;

        if ($this->content_type == Page::CONTENT_TYPE_VIEW) $arr["view_path"] = $this->content;
        else $arr["content"] = $this->content;

        $arr["can"] = [
            "update" => (new PagePolicy())->update(auth()->user(), $this->resource),
            "delete" => (new PagePolicy())->delete(auth()->user(), $this->resource)
        ];

        $arr = $this->thumbs("cover", $arr);

        return $arr;
    }
}
