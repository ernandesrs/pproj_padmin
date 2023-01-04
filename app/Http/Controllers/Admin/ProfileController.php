<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use App\Http\Resources\UserResource;
use App\Http\Services\DemoAppService;
use App\Http\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ProfileController extends Controller
{
    /**
     * Render profile
     *
     * @return \Inertia\Response
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileRequest $request)
    {
        if ((new DemoAppService())->isDemo()) {
            return back()->with((new DemoAppService())->demoAlert());
        }

        (new UserService())->update($request->validated(), $request->user());

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "Seu perfil foi atualizado com sucesso!"
        ]);
    }

    /**
     * User photo delete
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function photoDelete()
    {
        if ((new DemoAppService())->isDemo()) {
            return back()->with((new DemoAppService())->demoAlert());
        }

        $profile = Auth::user();

        (new UserService())->deletePhoto($profile);

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "Sua foto foi excluída com sucesso!"
        ]);
    }
}
