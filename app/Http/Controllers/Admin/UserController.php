<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Http\Services\FilterService;
use App\Http\Services\UserService;
use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $filter = (new FilterService(new User(), 18))->filter($request);

        /**
         * flag to user resource(make only small thumbnail)
         */
        session()->flash("mk_thumb", ["small"]);

        return Inertia::render("Admin/Users/List", [
            "users" => UserResource::collection($filter->model),
            "terms" => __("terms.user"),
            "filterAction" => route("admin.users.index"),
            "isFiltering" => $filter->filtering,
            "pageTitle" => "Usuários",
            "buttons" => [
                "new" => [
                    "url" => route("admin.users.create"),
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
        return Inertia::render("Admin/Users/Form", [
            "pageTitle" => "Novo usuário",
            "buttons" => [
                "back" => [
                    "url" => route("admin.users.index"),
                ],
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return
     */
    public function store(UserRequest $request)
    {
        $this->authorize("create", new User());

        $validated = $request->validated();

        $user = (new UserService())->store($validated);

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Novo usuário cadastrado com sucesso, um link de verificação foi enviado para o email informado.",
        ]);

        return Inertia::location(route("admin.users.edit", ["user" => $user->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show(User $user)
    {
        return back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        /**
         * flag to page resource(make only small normal)
         */
        session()->flash("mk_thumb", ["normal"]);

        return Inertia::render("Admin/Users/Form", [
            "user" => new UserResource($user),
            "roles" => RoleResource::collection(Role::all()),
            "terms" => __("terms.user"),
            "pageTitle" => "Editar usuário",
            "buttons" => [
                "back" => [
                    "url" => route("admin.users.index"),
                ],
                "new" => [
                    "url" => route("admin.users.create"),
                ],
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest  $request
     * @param  User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize("update", $user);

        $validated = $request->validated();

        (new UserService())->update($validated, $user);

        Session::flash("flash_alert", [
            "message" => "Os dados de " . $user->first_name . " foram atualizados com sucesso!",
            "variant" => "success",
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize("delete", $user);

        if ($user->photo) {
            Thumb::clear($user->photo);
            Storage::delete("public/{$user->photo}");
        }

        $user->delete();

        return redirect()->route("admin.users.index");
    }

    /**
     * User photo upload
     *
     * @param Request $request
     * @param User $user
     * @return void
     */
    public function uploadPhoto(Request $request, User $user)
    {
        $this->authorize("update", $user);

        $validated = $request->validate([
            "photo" => ["required", "max:5000", "mimes:png,jpg,webp"],
        ]);

        (new UserService())->storePhoto($validated["photo"], $user);

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "A foto do usuário foi atualizada com sucesso!"
        ]);
    }

    /**
     * User photo delete
     *
     * @param User $user
     * @return void
     */
    public function deletePhoto(User $user)
    {
        $this->authorize("update", $user);

        (new UserService())->deletePhoto($user);

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "A foto do usuário foi excluída com sucesso!"
        ]);
    }
}
