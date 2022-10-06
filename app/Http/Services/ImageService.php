<?php

namespace App\Http\Services;

use App\Models\Media\Image;

class ImageService
{
    /**
     * @var strign
     */
    private $imagesDir = "images";

    /**
     * Store the uploaded image
     *
     * @param \Illuminate\Http\UploadedFile $file the uploaded file
     * @param string|null $subdir the subdirectory in images dir
     * @return Image
     */
    public function store(\Illuminate\Http\UploadedFile $file, ?string $subdir = null)
    {
        $image = Image::create([
            "user_id" => auth()->user()->id,
            "name" => $validated["name"] ?? $file->getClientOriginalName(),
            "tags" => $validated["tags"] ?? null,
            "extension" => $file->getClientOriginalExtension(),
            "size" => $file->getSize(),
            "path" => $file->store($subdir ? $this->imagesDir . "/{$subdir}" : $this->imagesDir, "public"),
        ]);

        return $image;
    }
}
