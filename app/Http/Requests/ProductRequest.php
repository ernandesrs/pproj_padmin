<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            "price" => $this->price ? str_replace(",", ".", $this->price) : $this->price,
            "old_price" => $this->old_price ? str_replace(",", ".", $this->old_price) : $this->old_price
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
            "title" => ["required", "max:50", "unique:products,title" . ($this->product ? "," . $this->product->id : "")],
            "image.id" => ["required", "exists:images,id"],
            "icon" => ["required", "string"],
            "price" => ["required", "numeric"],
            "old_price" => ["nullable", "numeric"]
        ];
    }
}
