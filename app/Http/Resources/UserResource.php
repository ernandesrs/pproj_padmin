<?php

namespace App\Http\Resources;

use App\Policies\UserPolicy;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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

        $arr['full_name'] = (string) ($this->first_name . " " . $this->last_name);
        $arr['can'] = [
            'view' => (new UserPolicy())->view(auth()->user(), $this->resource),
            'create' => (new UserPolicy())->create(auth()->user(), $this->resource),
            'delete' => (new UserPolicy())->delete(auth()->user(), $this->resource),
            'update' => (new UserPolicy())->update(auth()->user(), $this->resource),
        ];

        return $this->thumbs("photo", $arr, "square");
    }
}
