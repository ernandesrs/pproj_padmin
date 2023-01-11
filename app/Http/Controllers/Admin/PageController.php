<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Http\Resources\Front\SectionResource;
use App\Http\Resources\PageResource;
use App\Http\Services\FilterService;
use App\Models\Media\Image;
use App\Models\Page;
use App\Models\Section\Section;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * List pages.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $filter = (new FilterService(new Page()))->filter($request);

        return Inertia::render("Admin/Pages/List", [
            "pages" => PageResource::collection($filter->model),
            "terms" => __("terms.page"),
            "filterAction" => route("admin.pages.index"),
            "isFiltering" => $filter->filtering,
            "pageTitle" => "Páginas",
            "buttons" => [
                "new" => [
                    "icon" => "fileEarmarkPlus",
                    "text" => "Nova página",
                    "url" => route("admin.pages.create"),
                ],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render("Admin/Pages/Form", [
            "pageTitle" => "Nova página",
            "sections" => SectionResource::collection(Section::all()),
            "terms" => __("terms.page"),
            "tinyApiKey" => env("TINY_API_KEY", "no-api-key"),
            "buttons" => [
                "back" => [
                    "url" => route("admin.pages.index"),
                ],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PageRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PageRequest $request)
    {
        $this->authorize("create", new Page());

        $validated = $request->validated();

        $validated["sections"] = array_map(function($item){
            return $item["id"];
        }, $validated["sections"]);

        if ($coverId = $validated["cover"] ?? null) {
            $image = Image::where("id", $coverId)->first();
            if ($image) {
                $validated["cover"] = $image->id;
            }
        }

        $page = Page::create($validated);

        return redirect()->route("admin.pages.edit", ["page" => $page->id])->with("flash_alert", [
            "variant" => "success",
            "message" => "Uma nova página foi criada com sucesso!",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Page $page)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Page  $page
     * @return \Inertia\Response
     */
    public function edit(Page $page)
    {
        return Inertia::render("Admin/Pages/Form", [
            "page" => new PageResource($page),
            "sections" => SectionResource::collection(Section::all()),
            "terms" => __("terms.page"),
            "pageTitle" => "Editar página",
            "tinyApiKey" => env("TINY_API_KEY", "no-api-key"),
            "buttons" => [
                "back" => [
                    "url" => route("admin.pages.index"),
                ],
                "new" => [
                    "icon" => "fileEarmarkPlus",
                    "text" => "Nova página",
                    "url" => route("admin.pages.create"),
                ],
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param PageRequest $request
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(PageRequest $request, Page $page)
    {
        $this->authorize("update", $page);

        $validated = $request->validated();

        if ($coverId = $validated["cover"] ?? null) {
            $image = Image::where("id", $coverId)->first();
            if ($image) {
                $validated["cover"] = $image->id;
            }
        } else {
            // refatora isso
            $page->cover = $page->cover->id;
        }

        $page->update($validated);

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "Os dados da página foram atualizados com sucesso!",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Page  $page
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Page $page)
    {
        $this->authorize("delete", $page);

        if ($page->protection == Page::PROTECTION_SYSTEM) {
            return back()->with("flash_alert", [
                "variant" => "warning",
                "message" => "Página protegida pelo sistema não pode ser excluída!",
            ]);
        }

        $slugs = $page->slugs()->first();
        $page->delete();
        if ($slugs->pages()->count() == 0) {
            $slugs->delete();
        }

        return back()->with("flash_alert", [
            "variant" => "warning",
            "message" => "A página foi excluída definitivamente com sucesso!",
        ]);
    }
}
