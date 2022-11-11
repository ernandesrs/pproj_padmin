<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Menu;
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
        $settings = Content::where("name", "front_settings")->first();
        $settings->content = json_decode($settings->content);

        $page = Page::findBySlug("inicio", config("app.locale"))->first();
        return view("front.index", [
            "pageTitle" => $page->title,
            "settings" => $settings,
            "menu_main" => Menu::where("id", $settings->content->menu_main ?? 0)->first(),
        ]);
    }
}
