<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MenuRequest extends FormRequest
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
        if (empty($this->items))
            $this->merge([
                "items" => []
            ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required", "max:25", "unique:menus,name" . ($this->menu ? "," . $this->menu->id : "")],
            "items.*.text" => ["required", "max:30", "string"],
            "items.*.title" => ["nullable", "max:50", "string"],
            "items.*.target" => ["required", Rule::in(["_self", "_blank"])],
            "items.*.url" => ["required", "string", "max:255"],

            "items.*.icon.source" => ["required", "string", Rule::in("local", "html")],
            "items.*.icon.name" => ["nullable", "required_if:items.*.icon.source,local", "string"],
            "items.*.icon.class" => ["nullable", "required_if:items.*.icon.class,html", "string"],
            "items.*.icon.position" => ["required", "string", Rule::in("start", "end", "center")]
        ];
    }

    /**
     * Messages
     *
     * @return array
     */
    public function messages()
    {
        return [
            "items.*.icon.source.required" => "Fonte do ícone obrigatório.",
            "items.*.icon.source.in" => "Fonte do ícone selecionada é inválida.",

            "items.*.icon.name.required_if" => "O ícone é obrigatório.",
            "items.*.icon.name.string" => "Ícone inválido.",

            "items.*.icon.class.required_if" => "Informe a classe do ícone.",
            "items.*.icon.class.string" => "Classe de ícone inválido.",

            "items.*.icon.position.required" => "Escolha uma posição: Início(start), Final(end) ou Centro(center).",
            "items.*.icon.position.string" => "Posição do ícone inválido."
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
