<?php

namespace App\Helpers;

use App\Models\Content;
use Illuminate\Support\Facades\Http;

class GRecaptcha
{
    private const GOOGLE_RECAPTCHA_URL_VERIFY = "https://www.google.com/recaptcha/api/siteverify";

    /**
     * Private key
     *
     * @var null|string
     */
    private $privateKey;

    /**
     * Public key
     *
     * @var null|string
     */
    private $publicKey;

    /**
     * Enabled or disabled
     *
     * @var bool
     */
    private $enabled;

    /**
     * Constructor
     */
    public function __construct()
    {
        $settings = Content::where("name", "front_settings")->first();
        if ($settings) {
            $content = json_decode($settings->content);
            $this->privateKey = $content->grecaptcha->private_key ?? null;
            $this->publicKey = $content->grecaptcha->public_key ?? null;
            $this->enabled = $content->grecaptcha->enabled ?? false;
        }
    }

    /**
     * Verifica o uso do Google Recapcha e retorna o html com a chave pública
     * 
     * @return string
     */
    public static function render(): string
    {
        if (self::active())
            return "<div class='g-recaptcha' data-sitekey='" . (new GRecaptcha())->publicKey . "'></div>";

        return "";
    }

    /**
     * Verifica o uso do Google Recapcha e retorna o html com script
     * 
     * @return string
     */
    public static function script(bool $url = true): string
    {
        $scriptUrl = 'https://www.google.com/recaptcha/api.js?hl=' . app()->getLocale();
        if (self::active()) {
            if ($url) return $scriptUrl;

            return "<script src='" . $scriptUrl . "'></script>";
        }

        return "";
    }

    /**
     * Valida o desafio
     * 
     * @param array|string $param
     * @return boolean
     */
    public static function verify($param): bool
    {
        $token = is_array($param) ? $param["g-recaptcha-response"] ?? null : $param;

        if (!$token) return false;

        $response = Http::get(self::GOOGLE_RECAPTCHA_URL_VERIFY, [
            'secret' => (new GRecaptcha())->privateKey,
            'response' => $token
        ]);

        return ($response ?? false) ? $response["success"] : false;
    }

    /**
     * Retorna true ou false se a aplicação está usando Google Recaptcha
     * 
     * @return boolean
     */
    public static function active(): bool
    {
        return (new GRecaptcha())->enabled;
    }

    /**
     * Undocumented function
     *
     * @return object
     */
    public static function toObject(): object
    {
        return (object) [
            'enabled' => GRecaptcha::active(),
            'public_key' => (new GRecaptcha())->publicKey,
            'script_element' => self::script(false),
            'script_url' => self::script(),
            'element' => self::render()
        ];
    }
}
