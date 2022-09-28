<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function index()
    {
        Inertia::setRootView("panel");
        return Inertia::render("Admin/Index", [
            "pageTitle" => "Dashboard"
        ]);
    }
}
