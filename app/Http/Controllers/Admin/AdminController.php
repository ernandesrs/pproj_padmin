<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
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
            ],
            "pagebox" => [
                "total" => Page::all()->count(),
                "draft" => Page::where("status", Page::STATUS_DRAFT)->count(),
                "scheduled" => Page::where("status", Page::STATUS_SCHEDULED)->count(),
                "published" => Page::where("status", Page::STATUS_PUBLISHED)->count(),
            ]
        ]);
    }
}
