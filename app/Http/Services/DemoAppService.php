<?php

namespace App\Http\Services;

class DemoAppService
{
    /**
     * Verify if this application is a demo application
     *
     * @return DemoAppService|null
     */
    public function isDemo()
    {
        return config("app.demo") ? $this : null;
    }

    /**
     * Return array with demo alert
     *
     * @return array
     */
    public function demoAlert()
    {
        return [
            "flash_alert" => [
                "variant" => "warning",
                "message" => "Este recurso não está habilitado, pois esta é uma aplicação de demonstração."
            ]
        ];
    }
}
