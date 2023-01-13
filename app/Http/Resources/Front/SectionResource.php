<?php

namespace App\Http\Resources\Front;

use App\Policies\Section\SectionPolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->resource->images;

        $arr = parent::toArray($request);

        $images = $arr['images'];
        $arr['images'] = array_map(function ($image_setting) use ($images) {
            $findedKey = array_search($image_setting->id, array_column($images, 'id'));
            if ($findedKey === false)
                return [];

            $image = $images[$findedKey];

            return array_merge($image, [
                'duration' => $image_setting->duration
            ]);
        }, $arr['images_settings']);

        $arr['references'] = $this->pages()->count();
        $arr['can'] = [
            'view' => (new SectionPolicy())->view($request->user(), $this->resource),
            'create' => (new SectionPolicy())->create($request->user(), $this->resource),
            'update' => (new SectionPolicy())->update($request->user(), $this->resource),
            'delete' => (new SectionPolicy())->delete($request->user(), $this->resource),
        ];

        return $arr;
    }
}
