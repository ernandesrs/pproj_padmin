<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoRequest extends FormRequest
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
            "file" => ["required", "max:10000", "mimes:mp4,mpeg"],
        ];

        if ($this->video) {
            $rules["name"] = ["required", "max:100"];
            unset($rules["file"]);
        }

        return $rules;
    }
}
