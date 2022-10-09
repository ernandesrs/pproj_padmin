<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use App\Models\Media\Image;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * @var boolean
     */
    private bool $filtering = false;

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     */
    public function index(Request $request)
    {
        $results = $this->filter($request);

        /**
         * flag to user resource(make only small thumbnail)
         */
        session()->flash("mk_thumb", ["small"]);

        return Inertia::render("Admin/Users/List", [
            "users" => UserResource::collection($results),
            "terms" => __("terms.user"),
            "filterAction" => route("admin.users.index"),
            "isFiltering" => $this->filtering,
            "pageTitle" => "Usuários",
            "buttons" => [
                "new" => [
                    "url" => route("admin.users.create")
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
        return Inertia::render("Admin/Users/Form", [
            "pageTitle" => "Novo usuário",
            "buttons" => [
                "back" => [
                    "url" => route("admin.users.index")
                ]
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserRequest  $request
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $this->authorize("create");

        $validated = $request->validated();

        $user = (new UserService())->store($validated);

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => "Novo usuário cadastrado com sucesso, um link de verificação foi enviado para o email informado."
        ]);

        return Inertia::location(route("admin.users.edit", ["user" => $user->id]));
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
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
            "terms" => __("terms.user"),
            "pageTitle" => "Editar usuário",
            "buttons" => [
                "back" => [
                    "url" => route("admin.users.index")
                ],
                "new" => [
                    "url" => route("admin.users.create")
                ]
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserRequest  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $this->authorize("update", $user);

        $validated = $request->validated();

        (new UserService())->update($validated, $user);

        Session::flash("flash_alert", [
            "message" => "Os dados de " . $user->first_name . " foram atualizados com sucesso!",
            "variant" => "success"
        ]);
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
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function promote(User $user)
    {
        $this->authorize("promote", $user);

        if ($level = $user->nextLevel()) {
            $user->level = $level;
            $user->save();

            session()->flash("flash_alert", [
                "variant" => "success",
                "message" => "{$user->first_name} foi promovido(a) de nível com sucesso!",
            ]);
        } else {
            session()->flash("flash_alert", [
                "variant" => "warning",
                "message" => "{$user->first_name} já possui o nível máximo de usuário!",
            ]);
        }

        return redirect()->back();
    }

    /**
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function demote(User $user)
    {
        $this->authorize("demote", $user);

        if ($level = $user->previousLevel()) {
            $user->level = $level;
            $user->save();

            session()->flash("flash_alert", [
                "variant" => "success",
                "message" => "{$user->first_name} foi rebaixado(a) de nível com sucesso!",
            ]);
        } else {
            session()->flash("flash_alert", [
                "variant" => "warning",
                "message" => "{$user->first_name} já possui o nível mínimo de usuário!",
            ]);
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return void
     */
    public function filter(Request $request)
    {
        $filters = $this->validate($request, [
            "filter" => ["nullable", "boolean"],
            "search" => ["nullable", "string"],
        ]);

        $users = User::whereNotNull("id")->orderBy("level", "DESC")->orderBy("created_at", "DESC");

        if ($filters["filter"] ?? null) {
            if ($filters["search"] ?? null)
                $users->whereRaw("MATCH(first_name,last_name,username,email) AGAINST('{$filters['search']}')");

            $this->filtering = true;
        }

        return $users->paginate(18);
    }
}
