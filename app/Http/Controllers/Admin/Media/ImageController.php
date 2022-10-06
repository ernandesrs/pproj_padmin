<?php

namespace App\Http\Controllers\Admin\Media;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Http\Services\ImageService;
use App\Models\Media\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ImageController extends Controller
{
    /**
     * @var boolean
     */
    private bool $filtering = false;

    /**
     * Display a listing of the resource.
     *
     * Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $images = $this->filter($request);
        return Inertia::render("Admin/Medias/Images/List", [
            "images" => ImageResource::collection($images),
            "filterAction" => route("admin.medias.images.index"),
            "isFiltering" => $this->filtering,
            "pageTitle" => "Imagens",
            "buttons" => [
                "new" => [
                    "text" => "Upload",
                    "icon" => "image",
                    "url" => route("admin.medias.images.create")
                ]
            ]
        ]);
    }

    /**
     * Render the upload view
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render("Admin/Medias/Images/Form", [
            "pageTitle" => "Novo upload",
            "buttons" => [
                "back" => [
                    "url" => route("admin.medias.images.index")
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ImageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageRequest $request)
    {
        $validated = $request->validated();

        $image = (new ImageService())->store($validated["file"]);

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Nova imagem '" . $image->name . "' salva com sucesso!"
        ]);

        return redirect()->route("admin.medias.images.index");
    }

    /**
     * @param ImageRequest $request
     * @return void
     */
    public function upload(ImageRequest $request)
    {
        $validated = $request->validated();

        $image = (new ImageService())->store($validated["file"]);

        return new ImageResource($image);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        return back()->with("image", new ImageResource($image));
    }

    /**
     * Render the upload view
     *
     * @param  \App\Models\Media\Image  $image
     * @return \Inertia\Response
     */
    public function edit(Image $image)
    {
        return Inertia::render("Admin/Medias/Images/Form", [
            "pageTitle" => "Editar imagem",
            "image" => new ImageResource($image),
            "buttons" => [
                "back" => [
                    "url" => route("admin.medias.images.index")
                ],
                "new" => [
                    "url" => route("admin.medias.images.create")
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ImageRequest  $request
     * @param  \App\Models\Media\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(ImageRequest $request, Image $image)
    {
        $this->authorize("update", $image);

        $validated = $request->validated();
        $image->name = $validated["name"];
        $image->tags = $validated["tags"];
        $image->save();

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Dados da imagem foram atualizados com sucesso!"
        ]);
        return redirect()->route("admin.medias.images.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        $this->authorize("delete", $image);

        Thumb::clear($image->path);
        Storage::delete("public/{$image->path}");
        $image->delete();

        session()->flash("flash_alert", [
            "variant" => "info",
            "message" => "Imagem exluída com sucesso!"
        ]);
        return back();
    }

    /**
     * @param Request $request
     * @return void
     */
    private function filter(Request $request)
    {
        $filters = $this->validate($request, [
            "filter" => ["nullable", "boolean"],
            "search" => ["nullable", "string"],
        ]);

        $images = Image::whereNotNull("id")->orderBy("created_at", "DESC");

        if ($filters["filter"] ?? null) {
            if ($filters["search"] ?? null)
                $images->whereRaw("MATCH(name,tags) AGAINST('{$filters['search']}')");

            $this->filtering = true;
        }

        return $images->paginate(20);
    }
}
