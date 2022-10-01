<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        Inertia::setRootView("panel");
        return Inertia::render("Admin/Index", [
            "pageTitle" => "Dashboard",
            "userbox" => [
                "total" => User::all()->count(),
                "verified" => User::whereNotNull("email_verified_at")->count(),
                "unverified" => User::whereNull("email_verified_at")->count()
            ]
        ]);
    }
}
