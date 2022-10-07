<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Media\Image;
use Illuminate\Http\Request;
use Inertia\Inertia;

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

        if ($favicon = $settings->content->favicon)
            $settings->favicon_url =  \Illuminate\Support\Facades\Storage::url($favicon);
        else $settings->favicon_url = null;

        if ($logo = $settings->content->logo)
            $settings->logo_url =  \Illuminate\Support\Facades\Storage::url($logo);
        else $settings->logo_url = null;

        return Inertia::render("Admin/Front/Settings", [
            "settings" => $settings,
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

        $settings = Content::where("name", "front_settings")->first();

        $content = json_decode($settings->content);
        $content->title = $validated["title"];
        $content->description = $validated["description"];
        $content->follow = $validated["follow"];

        if ($faviconId = $validated["favicon"]) {
            $favicon = Image::where("id", $faviconId)->first();
            if ($favicon)
                $content->favicon = $favicon->path;
        }

        if ($logoId = $validated["logo"]) {
            $logo = Image::where("id", $logoId)->first();
            if ($logo)
                $content->logo = $logo->path;
        }

        $settings->content = json_encode($content);
        $settings->save();

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "As configurações do site foram atualizados com sucesso."
        ]);
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
            "favicon" => ["nullable", "numeric"],
            "logo" => ["nullable", "numeric"],
        ]);
    }
}
