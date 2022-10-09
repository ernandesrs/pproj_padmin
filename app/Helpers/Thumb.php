<?php

namespace App\Helpers;

use CoffeeCode\Cropper\Cropper;
use Illuminate\Support\Facades\Storage;

class Thumb
{
    public const allowedExtensions = ["jpg", "jpeg", "png"];

    public const presets = [
        "default" =>  "img/default-image.png",
        "notfound" =>  "img/notfound-image.png",

        "square" => [
            "default" => "img/default-user-light.png",
            "notfound" =>  "img/notfound-image.png",
            "sizes" => [
                "small" => [75, 75],
                "normal" => [250, 250],
                "large" => [500, 500],
            ]
        ],

        "rectangle" => [
            "sizes" => [
                "small" => [200, 100],
                "normal" => [800, 600],
                "large" => [1200, 800],
            ]
        ],
    ];

    private const path = "public/thumbs";

    /**
     * @param null|string $path
     * @param null|string $presetPath String contendo o caminho para o array de presets,
     * ex.: user.small ou user.normal ou user.large. When null return the origin image
     * 
     * @return string
     */
    public static function thumb(?string $path, ?string $presetPath = null): string
    {
        if (!$presetPath)
            return Storage::url($path);

        $sizeArr = self::getPreset($presetPath);

        $width = $sizeArr[0];
        $height = $sizeArr[1] ?? null;

        $imagePath = self::getPath($path, $presetPath);
        if (!in_array(pathinfo($imagePath)['extension'], self::allowedExtensions))
            return Storage::url($path);

        return Storage::url(self::make($imagePath, $width, $height));
    }

    /**
     * @param string $imagePath caminho completo até à imagem
     * @param integer $width
     * @param integer|null $height
     * @return string|null
     */
    public static function make(string $imagePath, int $width, ?int $height = null): ?string
    {
        $cropper = new \CoffeeCode\Cropper\Cropper(Storage::path(self::path));

        $thumbPath = $cropper->make($imagePath, $width, $height);
        if ($thumbPath)
            $pathPath = str_replace(Storage::path("public/"), "", $thumbPath);

        return $pathPath;
    }

    /**
     * @param string|null $imagePath
     * @return void
     */
    public static function clear(?string $imagePath = null): void
    {
        (new Cropper(Storage::path(self::path)))->flush($imagePath);
        return;
    }

    /**
     * @param string $preset
     * @return array
     */
    private static function getPreset(string $preset): array
    {
        $array = explode(".", $preset);
        return  self::presets[$array[0]]["sizes"][$array[1]];
    }

    /**
     * @param string|null $path
     * @param string $preset
     * @return string
     */
    private static function getPath(?string $path, $preset)
    {
        $fpath = "";
        $default = self::presets[explode(".", $preset)[0]]['default'] ?? self::presets["default"];
        $notfound = self::presets[explode(".", $preset)[0]]['notfound'] ?? self::presets["notfound"];

        if (!$path)
            $fpath = resource_path($default);
        elseif (!file_exists(Storage::path("public/{$path}")))
            $fpath = resource_path($notfound);
        else
            $fpath = Storage::path("public/{$path}");

        return $fpath;
    }
}
