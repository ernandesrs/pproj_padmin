<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Render profile
     *
     * @return void
     */
    public function profile()
    {
        /**
         * flag to page resource(make only small normal)
         */
        session()->flash("mk_thumb", ["normal"]);

        return Inertia::render("Admin/Profile", [
            "pageTitle" => "Meu perfil",
            "me" => new UserResource(Auth::user())
        ]);
    }

    /**
     * Update profile
     *
     * @param ProfileRequest $request
     * @return void
     */
    public function update(ProfileRequest $request)
    {
        (new UserService())->update($request->validated(), $request->user());

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "Seu perfil foi atualizado com sucesso!"
        ]);
    }
}
