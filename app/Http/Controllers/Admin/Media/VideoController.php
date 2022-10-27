<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Http\Resources\VideoResource;
use App\Http\Services\VideoService;
use App\Models\Media\Video;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VideoController extends Controller
{
    /**
     * @var boolean
     */
    private $filtering = false;

    /**
     * Filter and/or list videos
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $videos = $this->filter($request);

        return Inertia::render("Admin/Medias/Videos/List", [
            "videos" => VideoResource::collection($videos),
            "filterAction" => route("admin.medias.videos.index"),
            "isFiltering" => $this->filtering,
            "pageTitle" => "Vídeos",
            "buttons" => [
                "new" => [
                    "text" => "Upload",
                    "icon" => "video",
                    "url" => route("admin.medias.videos.create")
                ]
            ]
        ]);
    }

    /**
     * Show the form for saving a new video.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render("Admin/Medias/Videos/Form", [
            "pageTitle" => "Novo upload",
            "buttons" => [
                "back" => [
                    "url" => route("admin.medias.videos.index")
                ]
            ]
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
            "message" => "Nova vídeo '" . $video->name . "' salvo com sucesso!"
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
                    "url" => route("admin.medias.videos.index")
                ],
                "new" => [
                    "url" => route("admin.medias.videos.create")
                ]
            ]
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
            "message" => "Dados do vídeo foram atualizados com sucesso!"
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
            "message" => "Vídeo exluído com sucesso!"
        ]);
        return back();
    }

    /**
     * Get and/or filter videos
     * 
     * @param Request $request
     * @return
     */
    private function filter(Request $request)
    {
        $filters = $this->validate($request, [
            "filter" => ["nullable", "boolean"],
            "search" => ["nullable", "string"],
        ]);

        $videos = Video::whereNotNull("id")->orderBy("created_at", "DESC");

        if ($filters["filter"] ?? null) {
            if ($filters["search"] ?? null)
                $videos->whereRaw("MATCH(name,tags) AGAINST('{$filters['search']}')");

            $this->filtering = true;
        }

        return $videos->paginate(20);
    }
}
