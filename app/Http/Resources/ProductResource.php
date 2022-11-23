<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            "title" => $this->title,
            "icon" => $this->icon,
            "image" => $this->image,
            "price" => $this->price,
            "old_price" => $this->old_price,
        ];

        // dd($arr);
        // $arr = $this->thumbs("image", $arr, "square");
        return $arr;
    }
}
