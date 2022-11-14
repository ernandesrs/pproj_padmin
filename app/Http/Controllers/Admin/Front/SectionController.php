<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Section\Section;
use Inertia\Inertia;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Admin/Front/Sections/List', [
            'sections' => null,
            'pageTitle' => 'Seções',
            "buttons" => [
                "new" => [
                    "icon" => "plusLg",
                    "text" => "Nova seção",
                    "url" => route("admin.sections.create"),
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
        return Inertia::render("Admin/Front/Sections/Form", [
            "pageTitle" => "Nova seção",
            "buttons" => [
                "back" => [
                    "url" => route("admin.sections.index"),
                ],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SectionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Section $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Section $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SectionRequest $request
     * @param Section $section
     * @return \Illuminate\Http\Response
     */
    public function update(SectionRequest $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Section $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
}
