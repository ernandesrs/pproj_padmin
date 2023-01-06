<?php

namespace App\Http\Requests\Front;

use App\Models\Section\Section;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class FrontSettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows("update_settings");
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        return;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "socials.facebook" => ["nullable", "string"],
            "socials.instagram" => ["nullable", "string"],
            "socials.twitter" => ["nullable", "string"],
            "socials.github" => ["nullable", "string"],
            "socials.linkedin" => ["nullable", "string"],
            "socials.tiktok" => ["nullable", "string"],
            "socials.youtube" => ["nullable", "string"],

            "header.favicon" => ["nullable", "numeric", "exists:images,id"],
            "header.logo" => ["nullable", "numeric", "exists:images,id"],
            "header.menu_main.id" => ["nullable", "numeric", "exists:menus,id"],

            "home.section_1" => ["nullable", "numeric", "exists:sections,id", function ($attr, $val, $fail) {
                $allowed = [Section::TYPE_BANNER];
                $s = Section::where("id", $val)->first();

                if ($s && !in_array($s->type, $allowed))
                    $fail("Aceito apenas: " . implode(",", array_map(function ($item) {
                        return __("terms.section.type.type_" . $item);
                    }, $allowed)));
            }],
            "home.section_2" => ["nullable", "numeric", "exists:sections,id", function ($attr, $val, $fail) {
                $allowed = [Section::TYPE_DEFAULT];
                $s = Section::where("id", $val)->first();

                if ($s && !in_array($s->type, $allowed))
                    $fail("Aceito apenas: " . implode(",", array_map(function ($item) {
                        return __("terms.section.type.type_" . $item);
                    }, $allowed)));
            }],
            "home.section_3" => ["nullable", "numeric", "exists:sections,id", function ($attr, $val, $fail) {
                $allowed = [Section::TYPE_BINDABLE];
                $s = Section::where("id", $val)->first();

                if ($s && !in_array($s->type, $allowed))
                    $fail("Aceito apenas: " . implode(",", array_map(function ($item) {
                        return __("terms.section.type.type_" . $item);
                    }, $allowed)));
            }],
            "home.section_4" => ["nullable", "numeric", "exists:sections,id", function ($attr, $val, $fail) {
                $allowed = [Section::TYPE_DEFAULT];
                $s = Section::where("id", $val)->first();

                if ($s && !in_array($s->type, $allowed))
                    $fail("Aceito apenas: " . implode(",", array_map(function ($item) {
                        return __("terms.section.type.type_" . $item);
                    }, $allowed)));
            }],

            "footer.menu_footer.id" => ["nullable", "numeric", "exists:menus,id"],
        ];
    }
}
