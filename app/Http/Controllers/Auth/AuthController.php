<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegistered;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Illuminate\Support\Str;

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

        session()->flash("flash_alert", [
            "message" => "Email e/ou senha inválido(s).",
            "variant" => "danger"
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function register()
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * @param RegisterRequest $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function store(RegisterRequest $request)
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

        event(new UserRegistered($user));

        auth()->loginUsingId($user->id);

        session()->flash("flash_alert", [
            "variant" => "success",
            "message" => $user->first_name . " bem vind" . ($user->gender == 2 ? 'a' : 'o') . ", um link de verificação foi enviado para o email informado."
        ]);

        return Inertia::location(route("auth.notify"));
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
