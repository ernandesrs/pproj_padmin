<?php

namespace App\Http\Requests\Admin;

use App\Models\Admin\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
            "name" => ["required", "unique:roles,name" . ($this->role ? "," . $this->role->id : "")],
            "admin_access" => ["required", "boolean"],
            "rulables" => ["required", "array", function ($attr, $rulables, $fail) {
                foreach ($rulables as $rulableName => $rulableValues) {
                    if (!in_array($rulableName, Role::RULABLES)) {
                        $fail("Regrável <{$rulableName}> não é aceito!");
                        return;
                    }
                }
            }],
            "rulables.*.*" => ["required", "boolean"],
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
