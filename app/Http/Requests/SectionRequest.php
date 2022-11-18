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
            "subtitle" => ["nullable", "max:75"],
            "visible" => ["required", "boolean"],

            "buttons.*.text" => ["required", "max:30", "string"],
            "buttons.*.title" => ["nullable", "max:50", "string"],
            "buttons.*.target" => ["required", Rule::in(["_self", "_blank"])],
            "buttons.*.url" => ["required", "string", "max:255"],
            "buttons.*.icon" => ["nullable", "string", "max:50"],
            "buttons.*.style" => ["required", "string", Rule::in(["primary", "outline-primary", "secondary", "outline-secondary", "link"])],
            "buttons.*.position" => ["required", "string", Rule::in(["start", "end"])],
        ];

        if (empty($this->section)) {
            $rules["type"] = ["required", Rule::in(Section::TYPES)];
        }

        if ($this->type == Section::TYPE_DEFAULT) {
            $rules["content.content"] = ["required"];
            $rules["content.image"] = ["nullable", "numeric", "exists:images,id"];
        } else if (in_array($this->type, [Section::TYPE_BANNER, Section::TYPE_BANNER_IMAGES])) {
            $rules["content.description"] = ["required", "max:750"];

            if ($this->type == Section::TYPE_BANNER_IMAGES) {
                $rules["content.images.*.id"] = ["nullable", "numeric", "exists:images,id"];
            }
        }

        return $rules;
    }
}
