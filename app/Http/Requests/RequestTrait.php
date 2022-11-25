<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

trait RequestTrait
{
    /**
     * Get array with icon rules validation
     *
     * @return array
     */
    protected function iconRules()
    {
        return [
            "icon.source" => ["nullable", "string", Rule::in(["local", "html"])],
            "icon.name" => ["nullable", "string"],
            "icon.class" => ["nullable", "string"],
            "icon.position" => ["nullable", "string", Rule::in(["start", "end"])]
        ];
    }
}
