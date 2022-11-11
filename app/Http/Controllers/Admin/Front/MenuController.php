<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    /**
     * @var boolean
     */
    private $filtering = false;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $results = [];

        return Inertia::render("Admin/Front/Menus/List", [
            "menus" => $results,
            "terms" => __("terms.menu"),
            "filterAction" => route("admin.menus.index"),
            "isFiltering" => $this->filtering,
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
        $validated = $request->validated();

        $menu = new Menu();
        $menu->name = $validated["name"];
        $menu->items = json_encode($validated["items"]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        //
    }
}
