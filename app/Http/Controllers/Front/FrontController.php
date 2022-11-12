<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Menu;
use App\Models\Page;
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
        $settings = Content::where("name", "front_settings")->first();
        $settings->content = json_decode($settings->content);

        if ($settings->content->header->menu_main ?? null) {
            $menu_main = Menu::where("id", $settings->content->header->menu_main ?? 0)->first();
            if ($menu_main)
                $menu_main->items = json_decode($menu_main->items);
        }

        $page = Page::findBySlug("inicio", config("app.locale"))->first();
        return view("front.index", [
            "pageTitle" => $page->title,
            "settings" => $settings,
            "menu_main" => $menu_main ?? null,
        ]);
    }
}
