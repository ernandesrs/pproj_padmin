<?php

namespace App\Helpers;

class Icons
{
    /**
     * Render a icon element
     *
     * @param string $name
     * @param string $tag
     * @return void
     */
    public static function render(string $name, string $tag = "i")
    {
        echo self::elem($name, $tag);
        return;
    }

    /**
     * Get a element icon
     *
     * @param string $name
     * @param string $tag
     * @return string
     */
    public static function elem(?string $name, string $tag = "i")
    {
        return "<{$tag} class='icon " . (self::get($name) ?? self::get("app")) . "'></{$tag}>";
    }

    /**
     * Get icon on a icons list
     *
     * @param string $name
     * @return string|null
     */
    public static function get(string $name)
    {
        return config("app-icons." . $name);
    }

    /**
     * Get icons as array
     *
     * @return array
     */
    public static function toArray()
    {
        return config("app-icons");
    }

    /**
     * Get icons as array
     *
     * @return object
     */
    public static function toObject()
    {
        return (object) config("app-icons");
    }

    /**
     * Get icons as JSON
     *
     * @return string
     */
    public static function toJson()
    {
        return json_encode(config("app-icons"));
    }
}
