<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Services\DemoAppService;
use App\Http\Services\UserService;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * Render the login view
     * 
     * @return \Inertia\Response
     */
    public function login()
    {
        return Inertia::render('Auth/Login', [
            "pageTitle" => "Login",
            "guest" => config("app.demo", false) ? [
                "email" => "guest@guest.mail",
                "password" => "guestpassword",
            ] : null
        ]);
    }

    /**
     * Authenticate user
     * 
     * @param LoginRequest $request
     * @return \Symfony\Component\HttpFoundation\Response|\Illuminate\Http\RedirectResponse
     */
    public function authenticate(LoginRequest $request)
    {
        $validated = $request->validated();
        $remember = $validated["remember_me"] ?? false;

        unset($validated["remember_me"]);

        if (auth()->attempt($validated, $remember)) {
            $user = auth()->user();
            $v = $user->gender == 2 ? "a" : "o";

            session()->flash("flash_alert", [
                "message" => $user->first_name . ", você está logad{$v}, bem vind{$v} de volta!",
                "variant" => "success"
            ]);

            return Inertia::location(route("admin.index"));
        }

        return back()->with("flash_alert", [
            "message" => "Email e/ou senha inválido(s).",
            "variant" => "danger"
        ]);
    }

    /**
     * Render user register view
     * 
     * @return \Inertia\Response
     */
    public function register()
    {
        return Inertia::render('Auth/Register', [
            "pageTitle" => "Cadastrar conta"
        ]);
    }

    /**
     * Store user
     * 
     * @param RegisterRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(RegisterRequest $request)
    {
        if ($demo = (new DemoAppService())->isDemo()) return back()->with($demo->demoAlert());

        $validated = $request->validated();

        $user = (new UserService())->store($validated);

        auth()->loginUsingId($user->id);

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => $user->first_name . " bem vind" . ($user->gender == 2 ? 'a' : 'o') . ", um link de verificação foi enviado para o email informado."
        ]);

        return Inertia::location(route("auth.notify"));
    }

    /**
     * Logout
     * 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function logout()
    {
        if (auth()->user()) {
            auth()->logout();
        }

        return Inertia::location(route("auth.login"));
    }
}
