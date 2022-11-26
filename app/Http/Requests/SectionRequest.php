<?php

namespace App\Http\Requests;

use App\Models\Section\Section;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SectionRequest extends FormRequest
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
        $rules = [
            "name" => ["required", "max:25", 'unique:sections,name' . (($this->section->id ?? null) ? ',' . $this->section->id : '')],
            "title" => ["required", "max:50"],
            "visible" => ["required", "boolean"],

            "buttons.*.text" => ["required", "max:30", "string"],
            "buttons.*.title" => ["nullable", "max:50", "string"],
            "buttons.*.target" => ["required", Rule::in(["_self", "_blank"])],
            "buttons.*.url" => ["required", "string", "max:255"],

            "buttons.*.icon.source" => ["nullable", "string", Rule::in("local", "html")],
            "buttons.*.icon.name" => ["nullable", "required_if:buttons.*.icon.source,local", "string"],
            "buttons.*.icon.class" => ["nullable", "required_if:buttons.*.icon.class,html", "string"],
            "buttons.*.icon.position" => ["nullable", "string", Rule::in("start", "end", "center")],

            "buttons.*.style" => ["required", "string", Rule::in(["primary", "outline-primary", "secondary", "outline-secondary", "link"])],
        ];

        if (empty($this->section)) {
            $rules["type"] = ["required", Rule::in(Section::TYPES)];
        }

        $type = empty($this->section) ? $this->type : $this->section->type;

        // image/images
        if (in_array($type, [Section::TYPE_DEFAULT, Section::TYPE_BANNER])) {
            $rules["content.image"] = ["nullable", "numeric", "exists:images,id"];
        } elseif (in_array($type, [Section::TYPE_DEFAULT_IMAGES, Section::TYPE_BANNER_IMAGES])) {
            $rules["content.images.*.id"] = ["nullable", "numeric", "exists:images,id"];
        }

        // subtitle/content/description
        if (in_array($type, [Section::TYPE_DEFAULT, Section::TYPE_DEFAULT_IMAGES])) {
            $rules["subtitle"] = ["required", "max:75"];
            $rules["content.content"] = ["required"];
        } elseif (in_array($type, [Section::TYPE_BANNER, Section::TYPE_BANNER_IMAGES])) {
            $rules["content.description"] = ["required", "max:750"];
        } elseif (in_array($type, [Section::TYPE_BOUND])) {
            $rules["subtitle"] = ["required", "max:75"];
            $rules["content.bindable"] = ["required", function ($attr, $val, $fail) {
                if (!key_exists($val, Section::BINDABLES)) {
                    $fail("Escolha um vinculável válido.");
                    return false;
                }
            }];
        }

        return $rules;
    }
}
