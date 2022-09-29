<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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

        Inertia::setRootView("panel");
        return Inertia::render("Admin/Users/List", [
            "users" => UserResource::collection($results),
            "filterAction" => route("admin.users.index"),
            "isFiltering" => $this->filtering,
            "pageTitle" => "Usuários",
            "buttons" => [
                "button_new" => route("admin.users.create")
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
        Inertia::setRootView("panel");
        return Inertia::render("Admin/Users/Form", [
            "pageTitle" => "Novo usuário",
            "buttons" => [
                "button_back" => route("admin.users.index"),
            ]
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserStoreUpdateRequest  $request
     * @return RedirectResponse
     */
    public function store(UserStoreUpdateRequest $request)
    {
        $validated = $request->validated();

        $validated["password"] = Hash::make($validated["password"]);

        /** User $user */
        $user = new User();
        $user->first_name = $validated["first_name"];
        $user->last_name = $validated["last_name"];
        $user->username = $validated["username"];
        $user->gender = $validated["gender"];
        $user->email = $validated["email"];
        $user->password = $validated["password"];
        $user->confirmation_token = Str::random(20);
        $user->save();

        return redirect()->route("admin.users.edit", ["user" => $user->id]);
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
        Inertia::setRootView("panel");
        return Inertia::render("Admin/Users/Form", [
            "user" => new UserResource($user),
            "pageTitle" => "Editar usuário",
            "buttons" => [
                "button_back" => route("admin.users.index"),
                "button_new" => route("admin.users.create")
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserStoreUpdateRequest  $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserStoreUpdateRequest $request, User $user)
    {
        $validated = $request->validated();

        if ($photo = $validated["photo"]) {
            if ($user->photo)
                Storage::delete("public/{$user->photo}");

            $user->photo = $photo->store("avatars", "public");
        }

        $user->first_name = $validated["first_name"];
        $user->last_name = $validated["last_name"];
        $user->username = $validated["username"];
        $user->gender = $validated["gender"];

        if ($pass = $validated["password"] ?? null)
            $user->password = Hash::make($pass);

        $user->save();

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
        if ($user->photo) {
            Thumb::clear($user->photo);
            Storage::delete("public/{$user->photo}");
        }

        $user->delete();

        return redirect()->route("admin.users.index");
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
