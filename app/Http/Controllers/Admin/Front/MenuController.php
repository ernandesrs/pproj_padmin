<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Http\Resources\MenuResource;
use App\Http\Services\FilterService;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $filter = (new FilterService(new Menu()))->filter($request);

        return Inertia::render("Admin/Front/Menus/List", [
            "menus" => MenuResource::collection($filter->model),
            "filterAction" => route("admin.menus.index"),
            "isFiltering" => $filter->filtering,
            "terms" => __("terms.menu"),
            "pageTitle" => "Menus",
            "buttons" => [
                "new" => [
                    "icon" => "plusLg",
                    "text" => "Novo menu",
                    "url" => route("admin.menus.create")
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
        return Inertia::render("Admin/Front/Menus/Form", [
            "pageTitle" => "Novo menu",
            "buttons" => [
                "back" => [
                    "url" => route("admin.menus.index")
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param MenuRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(MenuRequest $request)
    {
        $this->authorize("create", (new Menu()));

        $validated = $request->validated();

        $menu = new Menu();
        $menu->name = $validated["name"];
        $menu->items = json_encode($validated["items"] ?? []);
        $menu->save();

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Novo menu criado com sucesso!"
        ]);

        return redirect()->route("admin.menus.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        return Inertia::render("Admin/Front/Menus/Form", [
            "pageTitle" => "Editar menu",
            "menu" => new MenuResource($menu),
            "buttons" => [
                "back" => [
                    "url" => route("admin.menus.index")
                ],
                "new" => [
                    "url" => route("admin.menus.create")
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param MenuRequest $request
     * @param \App\Models\Menu $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(MenuRequest $request, Menu $menu)
    {
        $this->authorize("update", $menu);

        $validated = $request->validated();

        $menu->name = $validated["name"];
        $menu->items = json_encode($validated["items"] ?? []);
        $menu->save();

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Menu foi atualizado com sucesso!"
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Menu $menu)
    {
        $this->authorize("delete", $menu);

        $menu->delete();

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "O menu foi excluído com sucesso!"
        ]);
    }
}
