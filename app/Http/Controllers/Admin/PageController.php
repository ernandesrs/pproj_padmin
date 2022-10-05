<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
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
        $results = null;

        return Inertia::render("Admin/Pages/List", [
            "pages" => $results,
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
            "page" => null,
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
        //
    }
}
