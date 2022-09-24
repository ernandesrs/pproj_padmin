<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login()
    {
        return Inertia::render("Auth/Login");
    }

    public function register()
    {
        return Inertia::render("Auth/Register");
    }
}
