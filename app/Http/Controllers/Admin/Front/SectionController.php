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
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $bannerData = [
        //     'type' => Section::TYPE_BANNER,
        //     'name' => 'Lorem banner',
        //     'title' => 'Lorem title',
        //     'content' => '<strong>Banner</strong> content',
        //     'bindable_class' => null,
        //     'buttons' => json_encode([
        //         [
        //             'text' => 'Banner button',
        //             'title' => 'Banner button',
        //             'url' => null,
        //             'target' => '_self',
        //             'style' => 'primary',
        //             'icon' => [
        //                 'source' => 'local',
        //                 'name' => 'app',
        //                 'class' => '',
        //                 'position' => 'start',
        //             ],
        //         ]
        //     ]),
        // ];
        // $defaultData = [
        //     'type' => Section::TYPE_DEFAULT,
        //     'name' => 'Lorem default',
        //     'title' => 'Lorem title',
        //     'subtitle' => 'Lorem default subtitle',
        //     'content' => '<strong>Banner</strong> content',
        //     'bindable_class' => null,
        //     'buttons' => json_encode([
        //         [
        //             'text' => 'Banner button',
        //             'title' => 'Banner button',
        //             'url' => null,
        //             'target' => '_self',
        //             'style' => 'primary',
        //             'icon' => [
        //                 'source' => 'local',
        //                 'name' => 'app',
        //                 'class' => '',
        //                 'position' => 'start',
        //             ],
        //         ]
        //     ]),
        // ];

        // /**
        //  * @var Section $banner
        //  * @var Section $default
        //  */

        // $banner = Section::create($bannerData);
        // $default = Section::create($defaultData);
        // $banner->images()->attach([1, 2]);
        // dd($banner, $default);
        $sections = (new FilterService(new Section()))->filter($request);

        return Inertia::render('Admin/Front/Sections/List', [
            'pageTitle' => 'Seções',
            'sections' => SectionResource::collection($sections->model),
            'terms' => __('terms.section'),
            'sectionTypes' => Section::TYPES,
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Front/Sections/Form', [
            'pageTitle' => 'Nova seção',
            'terms' => __('terms.section'),
            'sectionTypes' => Section::TYPES,
            'bindables' => Section::BINDABLES
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param SectionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionRequest $request)
    {
        $validated  = $request->validated();
        dd($validated);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        return Inertia::render('Admin/Front/Sections/Form', [
            'pageTitle' => 'Editar seção',
            'section' => new SectionResource($section),
            'terms' => __('terms.section'),
            'sectionTypes' => Section::TYPES,
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
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
}
