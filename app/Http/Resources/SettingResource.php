<?php

namespace App\Http\Resources;

use App\Http\Resources\Front\SectionResource;
use App\Models\Menu;
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

        if ($favicon = $this->favicon()->first()) {
            $arr["favicon"] = new ImageResource($favicon);
        }

        if ($logo = $this->logo()->first())
            $arr["logo"] = new ImageResource($logo);

        if ($menu_header = $arr["menu_header"])
            $arr["menu_header"] = new MenuResource(Menu::where("id", $menu_header)->first());

        if ($menu_footer = $arr["menu_footer"])
            $arr["menu_header"] = new MenuResource(Menu::where("id", $menu_footer)->first());

        $arr["can"] = [
            "view" => (new SettingPolicy())->view(auth()->user(), $this->resource),
            "create" => (new SettingPolicy())->create(auth()->user(), $this->resource),
            "update" => (new SettingPolicy())->update(auth()->user(), $this->resource),
            "delete" => (new SettingPolicy())->delete(auth()->user(), $this->resource)
        ];

        return $arr;
    }
}
