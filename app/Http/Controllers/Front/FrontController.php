<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    /**
     * Render the home page
     *
     * @return View
     */
    public function index()
    {
        $page = Page::findBySlug("inicio", config("app.locale"))->first();
        return view("front.index", [
            "pageTitle" => $page->title
        ]);
    }
}
