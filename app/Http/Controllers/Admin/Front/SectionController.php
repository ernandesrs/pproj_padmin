<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Front\SectionRequest;
use App\Http\Resources\Front\SectionResource;
use App\Http\Services\FilterService;
use App\Models\Section\Section;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Section::class);

        $sections = (new FilterService(new Section()))->filter($request);

        return Inertia::render('Admin/Front/Sections/List', [
            'pageTitle' => 'Seções',
            'sections' => SectionResource::collection($sections->model),
            'sectionTypes' => Section::TYPES,
            'terms' => __('terms.section'),
            'buttons' => [
                'new' => [
                    'icon' => 'plusLg',
                    'text' => 'Novo',
                    'url' => route('admin.sections.create')
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
        $this->authorize('create', Section::class);

        return Inertia::render('Admin/Front/Sections/Form', [
            'pageTitle' => 'Nova seção',
            'sectionTypes' => Section::TYPES,
            'bindables' => Section::BINDABLES,
            "images" => session()->get("images", null),
            'terms' => __('terms.section'),
            "tinyApiKey" => env("TINY_API_KEY", "no-api-key")
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SectionRequest $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function store(SectionRequest $request)
    {
        $this->authorize('store', Section::class);

        $validated  = $request->validated();

        Section::create($validated);

        return redirect()->route("admin.sections.index")->with("flash_alert", [
            "variant" => "success",
            "message" => "Nova seção criada e salva com sucesso!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section\Section  $section
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Section $section)
    {
        $this->authorize('view', $section);

        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section\Section  $section
     * @return \Inertia\Response
     */
    public function edit(Section $section)
    {
        $this->authorize('view', $section);

        return Inertia::render('Admin/Front/Sections/Form', [
            'pageTitle' => 'Editar seção',
            'section' => new SectionResource($section),
            'sectionTypes' => Section::TYPES,
            'bindables' => Section::BINDABLES,
            "images" => session()->get("images", null),
            'terms' => __('terms.section'),
            'buttons' => [
                'back' => [
                    'icon' => 'arrowLeft',
                    'text' => 'Voltar',
                    'url' => route('admin.sections.index')
                ],
                'new' => [
                    'icon' => 'plusLg',
                    'text' => 'Novo',
                    'url' => route('admin.sections.create')
                ]
            ],
            "tinyApiKey" => env("TINY_API_KEY", "no-api-key")
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SectionRequest  $request
     * @param  \App\Models\Section\Section  $section
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(SectionRequest $request, Section $section)
    {
        $this->authorize('update', $section);

        $validated  = $request->validated();

        $section->update($validated);

        return redirect()->route("admin.sections.index")->with("flash_alert", [
            "variant" => "success",
            "message" => "A seção {$section->name} foi atualizada com sucesso!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section\Section  $section
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function destroy(Section $section)
    {
        $this->authorize('delete', $section);

        $section->delete();

        return redirect()->route("admin.sections.index")->with("flash_alert", [
            "variant" => "success",
            "message" => "Seção excluída com sucesso!"
        ]);
    }
}
