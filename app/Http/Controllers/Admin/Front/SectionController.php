<?php

namespace App\Http\Controllers\Admin\Front;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\SectionRequest;
use App\Http\Resources\SectionResource;
use App\Http\Services\FilterService;
use App\Http\Services\SectionService;
use App\Models\Media\Image;
use App\Models\Section\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $filter = (new FilterService(new Section()))->filter($request);

        return Inertia::render('Admin/Front/Sections/List', [
            'sections' => SectionResource::collection($filter->model),
            'filterAction' => route('admin.sections.index'),
            'isFiltering' => $filter->filtering,
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
            "bindables" => Section::BINDABLES,
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
        $this->authorize("create", new Section());

        $section = (new SectionService())->store($request->validated());

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
                    "url" => Thumb::thumb($item->path ?? null),
                    "interval" => ($item->interval ?? null) ? str_replace(",", ".", ($item->interval / 1000)) : null,
                ];
            });
        }

        return Inertia::render("Admin/Front/Sections/Form", [
            "section" => new SectionResource($section),
            "bindables" => Section::BINDABLES,
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
        $this->authorize("update", $section);

        $section = (new SectionService())->update($section, $request->validated());

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
        $this->authorize("delete", $section);

        $section->delete();

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "A seção foi excluída com sucesso!",
        ]);
    }
}
