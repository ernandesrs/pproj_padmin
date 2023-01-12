<?php

namespace App\Http\Resources;

use App\Http\Resources\Front\SectionResource;
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

        if ($this->content_type == Page::CONTENT_TYPE_VIEW) {
            $arr["sections"] = SectionResource::collection($this->sections);
        } else
            $arr["content"] = $this->content;

        if ($cover = $this->cover()->first()) {
            /**
             * flag to page resource(make only small thumbnail)
             */
            session()->flash("mk_thumb", ["small", "normal"]);

            $arr["cover"] = new ImageResource($cover);
        }

        return $arr;
    }
}
