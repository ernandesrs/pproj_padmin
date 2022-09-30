<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * @return \Inertia\Response
     */
    public function login()
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * @param LoginRequest $request
     * @return void
     */
    public function authenticate(LoginRequest $request)
    {
        $validated = $request->validated();

        if (auth()->attempt($validated, $validated["remember_me"] ?? false)) {
            $user = auth()->user();
            $v = $user->gender == 2 ? "a" : "o";

            session()->flash("flash_alert", [
                "message" => $user->first_name . ", você está logad{$v}, bem vind{$v} de volta!",
                "variant" => "success"
            ]);

            return Inertia::location(route("admin.index"));
        }

        session()->flash("flash_alert", [
            "message" => "Email e/ou senha inválido(s).",
            "variant" => "danger"
        ]);
    }

    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    public function store(RegisterRequest $request)
    {
        var_dump($request->validated());
    }

    /**
     * @return void
     */
    public function logout()
    {
        if (auth()->user()) {
            auth()->logout();
        }

        return Inertia::location(route("auth.login"));
    }
}
