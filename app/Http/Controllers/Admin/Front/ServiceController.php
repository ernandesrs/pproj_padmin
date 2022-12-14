<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\ServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Http\Services\FilterService;
use App\Models\Front\Service;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $filter = (new FilterService(new Service()))->filter($request);

        return Inertia::render('Admin/Front/Services/List', [
            'services' => ServiceResource::collection($filter->model),
            'filterAction' => route('admin.services.index'),
            'isFiltering' => $filter->filtering,
            'pageTitle' => 'Lista de serviços',
            "buttons" => [
                "new" => [
                    "icon" => "plusLg",
                    "text" => "Novo serviço",
                    "url" => route("admin.services.create")
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
        return Inertia::render('Admin/Front/Services/Form', [
            'pageTitle' => 'Novo serviço',
            "buttons" => [
                "back" => [
                    "url" => route("admin.services.index")
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(ServiceRequest $request)
    {
        $validated = $request->validated();

        $service = Service::create($validated);

        return redirect()->route("admin.services.edit", ["service" => $service->id])->with("flash_alert", [
            "variant" => "success",
            "message" => "Novo serviço cadastrado com sucesso!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Front\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(Service $service)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Front\Service  $service
     * @return \Inertia\Response
     */
    public function edit(Service $service)
    {
        return Inertia::render('Admin/Front/Services/Form', [
            'service' => new ServiceResource($service),
            'pageTitle' => 'Editar serviço',
            "buttons" => [
                "new" => [
                    "url" => route("admin.services.create")
                ],
                "back" => [
                    "url" => route("admin.services.index")
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ServiceRequest  $request
     * @param  \App\Models\Front\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ServiceRequest $request, Service $service)
    {
        $validated = $request->validated();

        $service->update($validated);

        return redirect()->route("admin.services.index")->with("flash_alert", [
            "variant" => "success",
            "message" => "O produto foi atualizado com sucesso!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Front\Service  $service
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Service $service)
    {
        $this->authorize("delete", new Service());

        $service->delete();

        return redirect()->route("admin.services.index")->with("flash_alert", [
            "variant" => "warning",
            "message" => "O serviço foi excluido com sucesso!"
        ]);
    }
}
