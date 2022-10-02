<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Models\Media\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImageController extends Controller
{
    /**
     * @var boolean
     */
    private bool $filtering = false;

    /**
     * @var string
     */
    private string $imagesDir = "images";

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render("Admin/Medias/Images/List", [
            "users" => null,
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

        $image = new Image();
        $image->user_id = auth()->user()->id;
        $image->name = $validated["name"] ?? $validated["file"]->getClientOriginalName();
        $image->tags = $validated["tags"] ?? null;
        $image->extension = $validated["file"]->getClientOriginalExtension();
        $image->size = $validated["file"]->getSize();
        $image->path = $validated["file"]->store($this->imagesDir, "public");
        $image->save();

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Nova imagem salva com sucesso!"
        ]);

        return redirect()->route("admin.medias.images.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function show(Image $image)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Media\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function update(ImageRequest $request, Image $image)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media\Image  $image
     * @return \Illuminate\Http\Response
     */
    public function destroy(Image $image)
    {
        //
    }
}
