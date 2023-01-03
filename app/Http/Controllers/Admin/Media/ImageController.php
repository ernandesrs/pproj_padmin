<?php

namespace App\Http\Controllers\Admin\Media;

use App\Http\Controllers\Controller;
use App\Http\Requests\Media\ImageRequest;
use App\Http\Resources\ImageResource;
use App\Http\Services\FilterService;
use App\Http\Services\ImageService;
use App\Models\Media\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * Request $request
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response
     */
    public function index(Request $request)
    {
        $onlyList = $request->get("onlyList", false);
        $filter = (new FilterService(new Image()))->filter($request);

        /**
         * flag to image resource(to make only the small thumbnail)
         */
        session()->flash("mk_thumb", ["small"]);

        if ($onlyList) {
            return back()->with("images", ImageResource::collection($filter->model));
        }

        return Inertia::render("Admin/Medias/Images/List", [
            "images" => ImageResource::collection($filter->model),
            "filterAction" => route("admin.medias.images.index"),
            "isFiltering" => $filter->filtering,
            "pageTitle" => "Imagens",
            "buttons" => [
                "new" => [
                    "text" => "Upload",
                    "icon" => "image",
                    "url" => route("admin.medias.images.create"),
                ],
            ],
        ]);
    }

    /**
     * Render the upload view
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        $this->authorize("create", new Image());

        return Inertia::render("Admin/Medias/Images/Form", [
            "pageTitle" => "Nova imagem",
            "buttons" => [
                "back" => [
                    "url" => route("admin.medias.images.index"),
                ],
            ],
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
        $this->authorize("create", new Image());

        $validated = $request->validated();
        $image = (new ImageService())->store($validated);

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Nova imagem '" . $image->name . "' salva com sucesso!",
        ]);

        return redirect()->route("admin.medias.images.index");
    }

    /**
     * Store new image and return a image resource
     *
     * @param ImageRequest $request
     * @return ImageResource|\Illuminate\Http\RedirectResponse
     */
    public function upload(ImageRequest $request)
    {
        $this->authorize("create", new Image());

        $validated = $request->validated();

        $image = (new ImageService())->store($validated);

        if ($request->header("x-inertia", false)) {
            return back()->with("flash_alert", [
                "variant" => "success",
                "message" => "Imagem enviada com sucesso!",
            ]);
        }

        return new ImageResource($image);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Media\Image  $image
     * @return \Illuminate\Http\RedirectResponse
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
        /**
         * flag to image resource(to make only the normal size thumbnail)
         */
        session()->flash("mk_thumb", ["small"]);

        return Inertia::render("Admin/Medias/Images/Form", [
            "pageTitle" => "Editar imagem",
            "image" => new ImageResource($image),
            "buttons" => [
                "back" => [
                    "url" => route("admin.medias.images.index"),
                ],
                "new" => [
                    "url" => route("admin.medias.images.create"),
                ],
            ],
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
            "message" => "Dados da imagem foram atualizados com sucesso!",
        ]);
        return redirect()->route("admin.medias.images.index");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Media\Image  $image
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Image $image)
    {
        $this->authorize("delete", $image);

        (new ImageService())->delete($image);

        session()->flash("flash_alert", [
            "variant" => "info",
            "message" => "Imagem exluída com sucesso!",
        ]);
        return back();
    }
}
