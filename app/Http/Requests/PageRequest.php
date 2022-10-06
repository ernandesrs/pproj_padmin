<?php

namespace App\Http\Requests;

use App\Models\Page;
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
            "cover" => ["nullable", "mimes:png,jpg,webp", "max:2500"],
            "lang" => [Rule::in(config("app.locales"))],
            "content_type" => ["required", Rule::in(Page::CONTENT_TYPES)],
            "content" => ["nullable"],
            "follow" => ["required", "boolean"],
            "status" => ["required", Rule::in(Page::STATUS)],
            "schedule_to" => ["required_if:status," . Page::STATUS_SCHEDULED],
            "view_path" => ["required_if:content_type," . Page::CONTENT_TYPE_VIEW],
            "slug" => ["required", "unique:slugs," . $this->lang]
        ];

        if ($this->page) {
            $slug = $this->page->slugs()->first();

            $rules["title"] = ["required", "unique:pages,title," . $this->page->id, "max:100"];
            $rules["slug"] = ["required", "unique:slugs,"  . $this->lang . ","  . $slug->id];

            if ($this->page->protection == Page::PROTECTION_SYSTEM) {
                unset($rules["content_type"]);
                unset($rules["status"]);
            }
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
                $validator->errors()->add('title', 'Não foi possível criar um slug para o título informado.');

            if ($validator->errors()->count())
                session()->flash("flash_alert", [
                    "message" => "Erro na validação dos dados, verifique os dados e tente de novo.",
                    "variant" => "danger"
                ]);
        });
    }
}
