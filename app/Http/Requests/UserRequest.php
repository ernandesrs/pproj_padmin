<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            "first_name" => ["required", "max:20"],
            "last_name" => ["required", "max:50"],
            "username" => ["required", "max:20", "unique:users,username" . ($this->user ? ',' . $this->user->id : '')],
            "gender" => ["required", Rule::in(User::GENDERS)],
            "email" => ["required", "email", "unique:users,email" . ($this->user ? ',' . $this->user->id : '')],
            "photo" => ["nullable", "max:5000", "mimes:png,jpg,webp"],
            "password" => [($this->user ? 'nullable' : 'required'), "confirmed"],
        ];

        return $rules;
    }
}
