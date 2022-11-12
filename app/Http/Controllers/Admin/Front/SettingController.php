<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\MenuResource;
use App\Models\Content;
use App\Models\Media\Image;
use App\Models\Menu;
use App\Models\Slug;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use stdClass;

class SettingController extends Controller
{
    /**
     * Undocumented function
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        $settings = Content::where("name", "front_settings")->first();
        $settings->content = json_decode($settings->content);

        $menus = MenuResource::collection(Menu::all());

        if ($favicon = $settings->content->header->favicon)
            $settings->content->header->favicon_url = \Illuminate\Support\Facades\Storage::url($favicon);
        else
            $settings->content->header->favicon_url = null;

        if ($logo = $settings->content->header->logo)
            $settings->content->header->logo_url = \Illuminate\Support\Facades\Storage::url($logo);
        else
            $settings->content->header->logo_url = null;

        return Inertia::render("Admin/Front/Settings", [
            "settings" => $settings,
            "menus" => $menus,
            "images" => session()->get("images", null),
            "pageTitle" => "Configurações de: " . config("app.name")
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $validated = $this->validated($request);

        $this->updateSettings($validated);

        $slug = Slug::where(config("app.locale"), "inicio")->first();
        $page = $slug->pages()->where("lang", config("app.locale"))->first();
        $page->update([
            "title" => $validated["title"],
            "description" => $validated["description"],
            "follow" => $validated["follow"],
            "status" => $page->status,
            "cover" => null,
        ]);

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "As configurações do site foram atualizados com sucesso."
        ]);
    }

    /**
     * @param array $validated
     * @return null|Content
     */
    public function updateSettings(array $validated)
    {
        if (!Gate::allows("update_settings")) {
            abort(403);
        }

        $settings = Content::where("name", "front_settings")->first();
        if (!$settings) return null;

        $content = json_decode($settings->content);
        $content->title = $validated["title"];
        $content->description = $validated["description"];
        $content->follow = $validated["follow"];

        $content->header->menu_main = $validated["header"]["menu_main"] ?? null;
        $content->footer->menu_main = $validated["footer"]["menu_main"] ?? null;

        if ($faviconId = $validated["header"]["favicon"] ?? null) {
            $favicon = Image::where("id", $faviconId)->first();
            if ($favicon)
                $content->header->favicon = $favicon->path;
        }

        if ($logoId = $validated["header"]["logo"] ?? null) {
            $logo = Image::where("id", $logoId)->first();
            if ($logo)
                $content->header->logo = $logo->path;
        }

        $settings->content = json_encode($content);
        $settings->save();

        return $settings;
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return array
     */
    private function validated(Request $request)
    {
        return $request->validate([
            "title" => ["required", "string", "max:60"],
            "description" => ["required", "string", "max:160"],
            "follow" => ["required", "boolean"],

            "header.favicon" => ["nullable", "numeric", "exists:images,id"],
            "header.logo" => ["nullable", "numeric", "exists:images,id"],

            "header.menu_main" => ["nullable", "numeric", "exists:menus,id"],
            "footer.menu_main" => ["nullable", "numeric", "exists:menus,id"],
        ]);
    }
}
