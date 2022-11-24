<?php

namespace App\Http\Requests;

use App\Models\Front\Service;
use App\Policies\ServicePolicy;
use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->service)
            return (new ServicePolicy())->update(auth()->user(), $this->service);

        return (new ServicePolicy())->create(auth()->user(), new Service());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "title" => ["required", "max:50", "unique:services,title" . ($this->service ? "," . $this->service->id : "")],
            "icon" => ["required", "string"],
            "description" => ["required", "string", "max:500"],
        ];
    }
}
