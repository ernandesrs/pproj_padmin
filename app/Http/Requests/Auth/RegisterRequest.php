<?php

namespace App\Http\Requests\Auth;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            "first_name" => ["required", "max:20"],
            "last_name" => ["required", "max:50"],
            "username" => ["required", "max:20"],
            "gender" => ["required", Rule::in(User::GENDERS)],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "confirmed"],
        ];
    }
}
