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

            "buttons.*.text" => ["required", "string"],
            "buttons.*.title" => ["required", "string"],
            "buttons.*.url" => ["required", "string"],
            "buttons.*.target" => ["required", "string", Rule::in(["_blank", "_self"])],
            "buttons.*.style" => ["required", "string", Rule::in(["primary", "outline-primary", "secondary", "secondary-primary", "link"])],
            "buttons.*.icon.source" => ["required", "string", Rule::in(["html", "local"])],
            "buttons.*.icon.class" => ["nullable", "required_if:buttons.*.icon.source,html", "string"],
            "buttons.*.icon.name" => ["nullable", "required_if:buttons.*.icon.source,name", "string"],
            "buttons.*.icon.position" => ["required", "string", Rule::in(["start", "end"])],

            "images.*.id" => ["nullable", "numeric", "exists:images,id"],
            "images.*.duration" => ["nullable", "numeric", "min:1000", "max:20000"],
        ];

        return $rules;
    }

    /**
     * Messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            "buttons.*.text.required" => "Obrigatório.",
            "buttons.*.text.string" => "Texto inválido.",

            "buttons.*.title.required" => "Obrigatório.",
            "buttons.*.title.string" => "Título inválido.",

            "buttons.*.url.required" => "Obrigatório.",
            "buttons.*.url.string" => "Url inválida.",

            "buttons.*.target.required" => "Obrigatório.",
            "buttons.*.target.in" => "Opção selecionada é inválida.",

            "buttons.*.style.required" => "Obrigatório.",
            "buttons.*.style.in" => "Estilo selecionada é inválido.",

            "buttons.*.icon.source.required" => "Fonte do ícone obrigatório.",
            "buttons.*.icon.source.in" => "Fonte do ícone selecionada é inválida.",

            "buttons.*.icon.name.required_if" => "O ícone é obrigatório.",
            "buttons.*.icon.name.string" => "Ícone inválido.",

            "buttons.*.icon.class.required_if" => "Informe a classe do ícone.",
            "buttons.*.icon.class.string" => "Classe de ícone inválido.",

            "buttons.*.icon.position.required" => "Escolha uma posição: Início(start), Final(end) ou Centro(center).",
            "buttons.*.icon.position.string" => "Posição do ícone inválido.",

            "images.*.id.numeric" => ["nullable", "numeric", "exists:images,id"],
            "images.*.id.exists" => ["nullable", "numeric", "exists:images,id"],

            "images.*.duration.numeric" => "A duração precisa ser numérico.",
            "images.*.duration.min" => "A duração mínima é de 1000 milisegundos.",
            "images.*.duration.max" => "A duração mínima é de 20000 milisegundos."
        ];
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
