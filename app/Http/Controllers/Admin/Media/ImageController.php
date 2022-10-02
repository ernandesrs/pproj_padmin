<?php

namespace App\Http\Controllers\Admin\Media;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Http\Resources\ImageResource;
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
            "images" => ImageResource::collection(Image::whereNotNull("id")->orderBy("created_at", "DESC")->paginate(18)),
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

        $file = $validated["file"];
        Image::create([
            "user_id" => auth()->user()->id,
            "name" => $validated["name"] ?? $file->getClientOriginalName(),
            "tags" => $validated["tags"] ?? null,
            "extension" => $file->getClientOriginalExtension(),
            "size" => $file->getSize(),
            "path" => $file->store($this->imagesDir, "public"),
        ]);

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
}
