<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Front\SettingController;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Http\Resources\PageResource;
use App\Models\Media\Image;
use App\Models\Page;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    /**
     * @var boolean
     */
    private $filtering = false;

    /**
     * List pages.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $results = $this->filter($request);

        /**
         * flag to page resource(make only small thumbnail)
         */
        session()->flash("mk_thumb", ["small"]);

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
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render("Admin/Pages/Form", [
            "pageTitle" => "Nova página",
            "terms" => __("terms.page"),
            "images" => session()->get("images", null),
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PageRequest $request)
    {
        $this->authorize("create", new Page());

        $validated = $request->validated();

        if ($coverId = $validated["cover"] ?? null) {
            $image = Image::where("id", $coverId)->first();
            if ($image)
                $validated["cover"] = $image->path;
        }

        $page = Page::create($validated);

        return redirect()->route("admin.pages.edit", ["page" => $page->id])->with("flash_alert", [
            "variant" => "success",
            "message" => "Uma nova página foi criada com sucesso!"
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
        /**
         * flag to page resource(make only small thumbnail)
         */
        session()->flash("mk_thumb", ["small"]);

        return Inertia::render("Admin/Pages/Form", [
            "page" => new PageResource($page),
            "terms" => __("terms.page"),
            "pageTitle" => "Editar página",
            "images" => session()->get("images", null),
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
            if ($image)
                $validated["cover"] = $image->path;
        }

        $page->update($validated);
        $slugs = $page->slugs()->first();
        if ($slugs) {
            $lang = config("app.locale");
            if (in_array($slugs->$lang, ["inicio", "home"])) {
                (new SettingController())->updateSettings([
                    "title" => $page->title,
                    "description" => $page->description,
                    "follow" => $page->follow,
                ]);
            }
        }

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "Os dados da página foram atualizados com sucesso!",
        ]);
    }

    /**
     * @param Request $request
     * @return
     */
    public function filter(Request $request)
    {
        $filters = $this->validate($request, [
            "filter" => ["nullable", "boolean"],
            "search" => ["nullable", "string"],
        ]);

        $users = Page::whereNotNull("id")->orderBy("protection", "DESC")->orderBy("created_at", "DESC");

        if ($filters["filter"] ?? null) {
            if ($filters["search"] ?? null)
                $users->whereRaw("MATCH(title,description) AGAINST('{$filters['search']}')");

            $this->filtering = true;
        }

        return $users->paginate(20);
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

        if ($page->protection == Page::PROTECTION_SYSTEM)
            return back()->with("flash_alert", [
                "variant" => "warning",
                "message" => "Página protegida pelo sistema não pode ser excluída!"
            ]);

        $slugs = $page->slugs()->first();
        $page->delete();
        if ($slugs->pages()->count() == 0)
            $slugs->delete();

        return back()->with("flash_alert", [
            "variant" => "warning",
            "message" => "A página foi excluída definitivamente com sucesso!"
        ]);
    }
}
