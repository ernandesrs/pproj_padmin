<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ExampleController extends Controller
{
    public function example1()
    {
        Inertia::setRootView("panel");
        return Inertia::render("Admin/Examples/Example1");
    }

    public function example2()
    {
        Inertia::setRootView("panel");
        return Inertia::render("Admin/Examples/Example2");
    }

    public function example3()
    {
        Inertia::setRootView("panel");
        return Inertia::render("Admin/Examples/Example3");
    }
}
