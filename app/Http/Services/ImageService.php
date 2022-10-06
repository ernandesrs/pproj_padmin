<?php

namespace App\Http\Services;

use App\Helpers\Thumb;
use App\Models\Media\Image;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Clear the generated thumbnails and delete image
     *
     * @param Image $image
     * @return void
     */
    public function delete(Image $image)
    {
        Thumb::clear($image->path);
        Storage::delete("public/{$image->path}");
        $image->delete();
        return;
    }
}
