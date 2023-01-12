<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        dd(json_decode($this->content));
        return [
            "socials.facebook" => ["nullable", "string"],
            "socials.instagram" => ["nullable", "string"],
            "socials.twitter" => ["nullable", "string"],
            "socials.github" => ["nullable", "string"],
            "socials.linkedin" => ["nullable", "string"],
            "socials.tiktok" => ["nullable", "string"],
            "socials.youtube" => ["nullable", "string"],

            "favicon" => ["nullable", "numeric", "exists:images,id"],
            "logo" => ["nullable", "numeric", "exists:images,id"],
            "menu_header.id" => ["nullable", "numeric", "exists:menus,id"],

            "menu_footer.id" => ["nullable", "numeric", "exists:menus,id"],
        ];
    }
}
