<?php

namespace App\Http\Requests;

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
            "header.favicon" => ["nullable", "numeric", "exists:images,id"],
            "header.logo" => ["nullable", "numeric", "exists:images,id"],
            "header.menu_main" => ["nullable", "numeric", "exists:menus,id"],

            "sections.section_1" => ["nullable", "numeric", "exists:sections,id", function ($attr, $val, $fail) {
                $s = Section::where("id", $val)->first();

                if ($s && $s->type != Section::TYPE_BANNER)
                    $fail("Apenas seções do tipo " . __("terms.section.type.type_" . Section::TYPE_BANNER) . " é aceito aqui.");
            }],
            "sections.section_2" => ["nullable", "numeric", "exists:sections,id", function ($attr, $val, $fail) {
                $s = Section::where("id", $val)->first();

                if ($s && $s->type != Section::TYPE_DEFAULT)
                    $fail("Apenas seções do tipo " . __("terms.section.type.type_" . Section::TYPE_DEFAULT) . " é aceito aqui.");
            }],
            "sections.section_3" => ["nullable", "numeric", "exists:sections,id", function ($attr, $val, $fail) {
                $s = Section::where("id", $val)->first();

                if ($s && $s->type != Section::TYPE_DEFAULT)
                    $fail("Apenas seções do tipo " . __("terms.section.type.type_" . Section::TYPE_DEFAULT) . " é aceito aqui.");
            }],

            "footer.menu_main" => ["nullable", "numeric", "exists:menus,id"],
        ];
    }
}
