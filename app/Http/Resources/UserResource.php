<?php

namespace App\Http\Resources;

use App\Helpers\Thumb;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserResource extends JsonResource
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
            'id' => (int) $this->id,
            'full_name' => (string) ($this->first_name . " " . $this->last_name),
            'first_name' => (string) $this->first_name,
            'last_name' => (string) $this->last_name,
            'username' => (string) $this->username,
            'email' => (string) $this->email,
            'gender' => (int) $this->gender,
            'email_verified_at' => (string) $this->email_verified_at,
            'created_at' => (string) $this->created_at,
            'level' => (int) $this->level,
        ];

        // make thumb
        $arr['photo'] = $this->photo ? Storage::url($this->photo) : Thumb::thumb(null, "user.large");
        $arr['thumb_small'] = Thumb::thumb($this->photo, "user.small");
        $arr['thumb_normal'] = Thumb::thumb($this->photo, "user.normal");
        $arr['thumb_large'] = Thumb::thumb($this->photo, "user.large");

        return $arr;
    }
}
