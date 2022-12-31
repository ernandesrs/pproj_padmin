<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\VideoRequest;
use App\Http\Resources\VideoResource;
use App\Http\Services\FilterService;
use App\Http\Services\VideoService;
use App\Models\Media\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoController extends Controller
{
    /**
     * Filter and/or list videos
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $filter = (new FilterService(new Video()))->filter($request);

        return Inertia::render("Admin/Medias/Videos/List", [
            "videos" => VideoResource::collection($filter->model),
            "filterAction" => route("admin.medias.videos.index"),
            "isFiltering" => $filter->filtering,
            "pageTitle" => "Vídeos",
            "buttons" => [
                "new" => [
                    "text" => "Upload",
                    "icon" => "video",
                    "url" => route("admin.medias.videos.create"),
                ],
            ],
        ]);
    }

    /**
     * Show the form for saving a new video.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize("create", new Video());

        return Inertia::render("Admin/Medias/Videos/Form", [
            "pageTitle" => "Novo vídeo",
            "buttons" => [
                "back" => [
                    "url" => route("admin.medias.videos.index"),
                ],
            ],
        ]);
    }

    /**
     * Store a newly uploaded video in storage.
     *
     * @param VideoRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(VideoRequest $request)
    {
        $this->authorize("create", new Video());

        $validated = $request->validated();

        $video = (new VideoService())->store($validated);

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Nova vídeo '" . $video->name . "' salvo com sucesso!",
        ]);

        return redirect()->route("admin.medias.videos.index");
    }

    /**
     * Get the specified video.
     *
     * @param Video $video
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Video $video)
    {
        return back()->with("video", new VideoResource($video));
    }

    /**
     * Show the form for editing the specified video.
     *
     * @param Video $video
     * @return \Inertia\Response
     */
    public function edit(Video $video)
    {
        return Inertia::render("Admin/Medias/Videos/Form", [
            "pageTitle" => "Editar vídeo",
            "video" => new VideoResource($video),
            "buttons" => [
                "back" => [
                    "url" => route("admin.medias.videos.index"),
                ],
                "new" => [
                    "url" => route("admin.medias.videos.create"),
                ],
            ],
        ]);
    }

    /**
     * Update the specified video in storage.
     *
     * @param VideoRequest $request
     * @param Video $video
     * @return \Illuminate\Http\Response
     */
    public function update(VideoRequest $request, Video $video)
    {
        $this->authorize("update", $video);

        $validated = $request->validated();
        $video->name = $validated["name"];
        $video->tags = $validated["tags"];
        $video->save();

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Dados do vídeo foram atualizados com sucesso!",
        ]);
        return redirect()->route("admin.medias.videos.index");
    }

    /**
     * Remove the specified video from storage.
     *
     * @param Video $video
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Video $video)
    {
        $this->authorize("delete", $video);

        (new VideoService())->delete($video);

        session()->flash("flash_alert", [
            "variant" => "info",
            "message" => "Vídeo exluído com sucesso!",
        ]);
        return back();
    }
}
