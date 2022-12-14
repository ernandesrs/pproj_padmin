<?php

namespace App\Http\Requests;

use App\Models\Page;
use App\Models\Section\Section;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PageRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        if (empty($this->lang))
            $this->merge([
                "lang" => config("app.locale"),
                "slug" => \Illuminate\Support\Str::slug($this->title)
            ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "title" => ["required", "unique:pages,title", "max:100"],
            "description" => ["required", "max:160"],
            "cover" => ["nullable", "numeric"],
            "lang" => [Rule::in(config("app.locales"))],
            "follow" => ["required", "boolean"],
            "status" => ["required", Rule::in(Page::STATUS)],
            "schedule_to" => ["required_if:status," . Page::STATUS_SCHEDULED],
            "slug" => ["required", "unique:slugs," . $this->lang],

            "content_type" => ["required", Rule::in(Page::CONTENT_TYPES)],
            "content" => ["nullable"],

            "sections.*.id" => ["required_if:content_type," . Page::CONTENT_TYPE_VIEW, "exists:sections,id"],

            "sections_settings.*.id" => ["required_if:content_type," . Page::CONTENT_TYPE_VIEW, "exists:sections,id"],
            "sections_settings.*.order" => ["required_if:content_type," . Page::CONTENT_TYPE_VIEW, "numeric"],
            "sections_settings.*.alignment" => ["required_if:content_type," . Page::CONTENT_TYPE_VIEW, function ($attr, $val, $fail) {
                $sectionId = json_decode($this->content)->sections[explode(".", $attr)[1]]->id;
                $section = Section::find($sectionId);

                if ($section->type == Section::TYPE_BINDABLE) {
                    if (!in_array($val, ["center"])) {
                        $fail("Alinhamento n??o aceito para se????o escolhida.");
                        return;
                    }
                } else {
                    if (!in_array($val, ["left", "center", "right"])) {
                        $fail("Alinhamento do conte??do da se????o n??o aceito.");
                        return;
                    }
                }
            }],
        ];

        if ($this->page) {
            $slug = $this->page->slugs()->first();

            $rules["title"] = ["required", "unique:pages,title," . $this->page->id, "max:100"];
            $rules["slug"] = ["required", "unique:slugs,"  . $this->lang . ","  . $slug->id];
        }

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
            if ($validator->failed()["slug"] ?? null)
                $validator->errors()->add('title', 'N??o foi poss??vel criar um slug para o t??tulo informado.');

            if ($validator->errors()->count())
                session()->flash("flash_alert", [
                    "message" => "Erro na valida????o dos dados, verifique os dados e tente de novo.",
                    "variant" => "danger"
                ]);
        });
    }
}
