<?php

namespace App\Http\Requests\Media;

use Illuminate\Foundation\Http\FormRequest;

class ImageRequest extends FormRequest
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
        $this->merge([
            "user_id" => auth()->user()->id
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
            "name" => ["nullable", "max:100"],
            "tags" => ["nullable", "max:100"],
            "file" => ["required", "max:5000", "mimes:png,jpg,webp,svg"],
        ];

        if ($this->image) {
            $rules["name"] = ["required", "max:100"];
            unset($rules["file"]);
        }

        return $rules;
    }
}
