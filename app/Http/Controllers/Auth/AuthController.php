<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render("Auth/Login");
    }

    public function authenticate(LoginRequest $request)
    {
        var_dump($request->validated());
    }

    public function register()
    {
        return Inertia::render("Auth/Register");
    }

    public function store(RegisterRequest $request)
    {
        var_dump($request->validated());
    }
}
