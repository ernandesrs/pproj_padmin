<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleRequest;
use App\Http\Services\FilterService;
use App\Models\Admin\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = (new FilterService(new Role(), 18))->filter($request);

        return Inertia::render("Admin/Roles/List", [
            "pageTitle" => "Funções",
            "roles" => $filter->model,
            "filterAction" => route("admin.roles.index"),
            "isFiltering" => $filter->filtering,
            "buttons" => [
                "new" => [
                    "url" => route("admin.roles.create"),
                ],
            ],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render("Admin/Roles/Form", [
            "pageTitle" => "Nova função",
            "rulables" => Role::RULABLES,
            "rules" => Role::RULES,
            "buttons" => [
                "back" => [
                    "url" => route("admin.roles.index"),
                ],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        (new Role())->create($request->validated());

        return redirect()->route("admin.roles.index")->with("flash_alert", [
            "variant" => "success",
            "message" => "Nova função criada com sucesso!"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return Inertia::render("Admin/Roles/Form", [
            "pageTitle" => "Editar função",
            "role" => $role,
            "rulables" => Role::RULABLES,
            "rules" => Role::RULES,
            "buttons" => [
                "back" => [
                    "url" => route("admin.roles.index"),
                ],
                "new" => [
                    "url" => route("admin.roles.create"),
                ],
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @param  \App\Models\Admin\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, Role $role)
    {
        $role->update($request->validated());
        
        return redirect()->route("admin.roles.index")->with("flash_alert", [
            "variant" => "success",
            "message" => "Função {$role->name} foi atualizada com sucesso!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
    }
}
