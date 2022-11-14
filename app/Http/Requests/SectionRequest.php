<?php

namespace App\Http\Requests;

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
        return [
            "type" => ["required", Rule::in([0])],
            "name" => ["required", "max:25", 'unique:sections,name' . (($this->section->id ?? null) ? ',' . $this->section->id : '')],
            "title" => ["required", "max:50", 'unique:sections,title' . (($this->section->id ?? null) ? ',' . $this->section->id : '')],
            "subtitle" => ["nullable", "max:75"],

            "content.content" => ["nullable"],
            "content.image" => ["nullable", "numeric", "exists:images,id"],

            "buttons.*.text" => ["required", "max:30", "string"],
            "buttons.*.title" => ["nullable", "max:50", "string"],
            "buttons.*.target" => ["required", Rule::in(["_self", "_blank"])],
            "buttons.*.url" => ["required", "string", "max:255"],
            "buttons.*.icon" => ["nullable", "string", "max:50"],
            "buttons.*.style" => ["required", "string", Rule::in(["primary", "outline-primary", "secondary", "outline-secondary", "link"])],
        ];
    }
}
