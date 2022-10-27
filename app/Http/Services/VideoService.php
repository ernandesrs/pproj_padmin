<?php

namespace App\Http\Services;

use App\Models\Media\Video;
use Illuminate\Support\Facades\Storage;

class VideoService
{
    /**
     * @var string
     */
    private $videosDir = "videos";

    /**
     * Store the uploaded video
     *
     * @param array $validated the validated uploaded file
     * @param string|null $subdir the subdirectory in videos dir
     * @return Video
     */
    public function store(array $validated, ?string $subdir = null)
    {
        $file = $validated["file"];
        $fileName = str_replace("." . $file->getClientOriginalExtension(), "", $file->getClientOriginalName());

        $video = Video::create([
            "user_id" => auth()->user()->id,
            "name" => $validated["name"] ?? $fileName,
            "tags" => $validated["tags"] ?? null,
            "extension" => $file->getClientOriginalExtension(),
            "size" => $file->getSize(),
            "path" => $file->store($subdir ? $this->videosDir . "/{$subdir}" : $this->videosDir, "public"),
        ]);

        return $video;
    }

    /**
     * Clear the generated thumbnails and delete video
     *
     * @param Video $video
     * @return void
     */
    public function delete(Video $video)
    {
        Storage::delete("public/{$video->path}");
        $video->delete();
        return;
    }
}
