<?php

namespace App\Http\Requests\Admin\Front;

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
            "type" => ["required", Rule::in(Section::TYPES)],
            "name" => ["required", "max:25", "unique:sections,name" . ($this->section ? "," . $this->section->id : "")],
            "title" => ["required", "max:50"],
            "subtitle" => ["required_unless:type," . Section::TYPE_BANNER, "max:75"],
            "content" => ["required_unless:type," . Section::TYPE_BINDABLE],
            "bindable_class" => ["required_if:type," . Section::TYPE_BINDABLE],
            "visible" => ["required", "boolean"],

            "buttons" => ["nullable"],
            "buttons.*.text" => ["nullable", "string"],
            "buttons.*.title" => ["nullable", "string"],
            "buttons.*.url" => ["nullable", "string"],
            "buttons.*.target" => ["nullable", "string", Rule::in(["_blank", "_self"])],
            "buttons.*.style" => ["nullable", "string", Rule::in(["primary", "outline-primary", "secondary", "secondary-primary", "link"])],

            "images" => ["nullable"],
            "images.*" => ["nullable", "numeric", "exists:images,id"]
        ];

        return $rules;
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->count())
                session()->flash("flash_alert", [
                    "message" => "Erro na validação dos dados, verifique os dados e tente de novo.",
                    "variant" => "danger"
                ]);
        });
    }
}
