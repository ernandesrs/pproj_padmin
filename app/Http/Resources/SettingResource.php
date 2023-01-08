<?php

namespace App\Http\Resources;

use App\Http\Resources\Front\SectionResource;
use App\Policies\SettingPolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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

        if ($favicon = $arr["content"]->header->favicon)
            $arr["content"]->header->favicon = new ImageResource($favicon);

        if ($logo = $arr["content"]->header->logo)
            $arr["content"]->header->logo = new ImageResource($logo);

        if ($menu_main = $arr["content"]->header->menu_main)
            $arr["content"]->header->menu_main = new MenuResource($menu_main);

        foreach ($arr["content"]->pages as $keyPage => $page) {
            foreach ($page as $keySection => $section) {
                if ($section)
                    $arr["content"]->pages->$keyPage->$keySection = new SectionResource($section);
            }
        }

        if ($menu_footer = $arr["content"]->footer->menu_footer)
            $arr["content"]->footer->menu_footer = new MenuResource($menu_footer);

        $arr["can"] = [
            "view" => (new SettingPolicy())->view(auth()->user(), $this->resource),
            "create" => (new SettingPolicy())->create(auth()->user(), $this->resource),
            "update" => (new SettingPolicy())->update(auth()->user(), $this->resource),
            "delete" => (new SettingPolicy())->delete(auth()->user(), $this->resource)
        ];

        return $arr;
    }
}
