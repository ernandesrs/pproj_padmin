<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Http\Resources\PageResource;
use App\Http\Services\ImageService;
use App\Models\Page;
use App\Models\Slug;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * @var boolean
     */
    private bool $filtering = false;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $results = Page::whereNotNull("id")->orderBy("protection", "DESC")->orderBy("created_at", "DESC")->paginate(18);

        return Inertia::render("Admin/Pages/List", [
            "pages" => PageResource::collection($results),
            "terms" => __("terms.page"),
            "filterAction" => route("admin.pages.index"),
            "isFiltering" => $this->filtering,
            "pageTitle" => "Páginas",
            "buttons" => [
                "new" => [
                    "icon" => "fileEarmarkPlus",
                    "text" => "Nova página",
                    "url" => route("admin.pages.create")
                ]
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Admin/Pages/Form", [
            "pageTitle" => "Nova página",
            "terms" => __("terms.page"),
            "buttons" => [
                "back" => [
                    "url" => route("admin.pages.index")
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PageRequest $request)
    {
        $validated = $request->validated();

        if ($cover = $validated["cover"] ?? null) {
            $image = (new ImageService())->store($cover, "covers");
            $validated["cover"] = $image->path;
        }

        $page = Page::create($validated);

        return redirect()->route("admin.pages.edit", ["page" => $page->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function show(Page $page)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function edit(Page $page)
    {
        return Inertia::render("Admin/Pages/Form", [
            "page" => new PageResource($page),
            "terms" => __("terms.page"),
            "pageTitle" => "Editar página",
            "buttons" => [
                "back" => [
                    "url" => route("admin.pages.index")
                ],
                "new" => [
                    "icon" => "fileEarmarkPlus",
                    "text" => "Nova página",
                    "url" => route("admin.pages.create")
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Page $page)
    {
        $this->authorize("update", $page);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\Response
     */
    public function destroy(Page $page)
    {
        $this->authorize("delete", $page);
        //
    }
}
