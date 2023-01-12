<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Contracts\View\View;

class FrontController extends Controller
{
    /**
     * Render the home page
     *
     * @return View
     */
    public function index()
    {
        $settings = Setting::where("name", "front_settings")->first();
        if (!$settings) {
            return;
        }

        $page = Page::findBySlug("inicio", config("app.locale"))->first();
        return view("front.index", [
            "pageTitle" => $page->title,
            "settings" => $settings,
            "page" => $page,
        ]);
    }
}
