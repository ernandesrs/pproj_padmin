<?php

namespace App\Http\Controllers\Admin\Front;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Models\Media\Image;
use App\Models\Section\Section;
use Illuminate\Support\Collection;
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
            'terms' => __('terms.section'),
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
            "section_types" => Section::TYPES,
            "terms" => __("terms.section"),
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
        $validated = $this->getImage($request->validated());

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
        } else if ($section->content->images ?? null) {
            $section->content->images = Collection::make($section->content->images)->map(function ($item) {
                return [
                    "id" => $item->id,
                    "path" => $item->path ?? null,
                    "url" => Thumb::thumb($item->path ?? null)
                ];
            });
        }

        return Inertia::render("Admin/Front/Sections/Form", [
            "section" => $section,
            "section_types" => Section::TYPES,
            "terms" => __("terms.section"),
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
        $validated = $this->getImage($request->validated(), $section);

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

    /**
     * Undocumented function
     *
     * @param array $validated
     * @param Section|null $section
     * @return array
     */
    private function getImage(array $validated, ?Section $section = null)
    {
        $type = $section ? $section->type : $validated["type"];

        if (in_array($type, [Section::TYPE_DEFAULT, Section::TYPE_BANNER])) {
            $image = $validated["content"]["image"] ?? null;
            if ($image) {
                $image = Image::where("id", $image)->first();
                if ($image) {
                    $image = $image->path;
                }
            }
            $validated["content"]["image"] = $image;
        } else {
            $images = $validated["content"]["images"] ?? [];
            foreach ($images as $key => $image) {
                $imageModel = Image::where("id", $image["id"] ?? 0)->first();
                if ($imageModel)
                    $images[$key]["path"] = $imageModel->path;
            }
            $validated["content"]["images"] = $images;
        }
        return $validated;
    }
}
