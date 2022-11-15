<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Media\Image;
use App\Models\Section\Section;
use Illuminate\Support\Facades\Storage;
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
            'sections' => Section::paginate(20),
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
            "tinyApiKey" => env("TINY_API_KEY", "no-api-key"),
            "images" => session()->get("images", null),
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
        $validated = $request->validated();

        $validated["buttons"] = json_encode($validated["buttons"] ?? []);

        $image = $validated["content"]["image"] ?? null;
        $content = $validated["content"]["content"] ?? null;
        if ($image) {
            $image = Image::where("id", $image)->first();
            if ($image) {
                $image = $image->path;
            }
        }

        $validated["content"] = json_encode([
            "image" => $image,
            "content" => $content,
        ]);

        $section = Section::create($validated);

        return redirect()->route("admin.sections.edit", ["section" => $section->id])->with("flash_alert", [
            "variant" => "success",
            "message" => "Nova seção criada com sucesso!",
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Section $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Section $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        if ($section->content->image ?? null) {
            $section->content->image_url = Storage::url($section->content->image);
        }

        return Inertia::render("Admin/Front/Sections/Form", [
            "section" => $section,
            "pageTitle" => "Editar seção",
            "tinyApiKey" => env("TINY_API_KEY", "no-api-key"),
            "images" => session()->get("images", null),
            "buttons" => [
                "back" => [
                    "url" => route("admin.sections.index"),
                ],
                "new" => [
                    "icon" => "plusLg",
                    "text" => "Nova seção",
                    "url" => route("admin.sections.create"),
                ],
            ],
        ]);
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
        $validated = $request->validated();

        if ($image = $validated["content"]["image"] ?? null) {
            $image = Image::where("id", $image)->first();
            if ($image) {
                $validated["content"]["image"] = $image->path;
            }
        }

        $section->update($validated);

        return redirect()->route("admin.sections.edit", ["section" => $section->id])->with("flash_alert", [
            "variant" => "success",
            "message" => "Os dados da seção foram atualizados com sucesso!",
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Section $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        $section->delete();

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "A seção foi excluída com sucesso!",
        ]);
    }
}
