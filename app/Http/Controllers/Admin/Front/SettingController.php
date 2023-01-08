<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\Front\FrontSettingRequest;
use App\Http\Resources\MenuResource;
use App\Http\Resources\SettingResource;
use App\Models\Content;
use App\Models\Media\Image;
use App\Models\Menu;
use App\Models\Section\Section;
use App\Models\Setting;
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
        $settings = Setting::where("name", "front_settings")->first();

        $menus = MenuResource::collection(Menu::all());
        $sections = Section::where("visible", true)->get();

        return Inertia::render("Admin/Front/Settings", [
            "settings" => new SettingResource($settings),
            "terms" => __("terms"),
            "menus" => $menus,
            "sections" => $sections,
            "pageTitle" => "Configurações de: " . config("app.name"),
        ]);
    }

    /**
     * Undocumented function
     *
     * @param FrontSettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(FrontSettingRequest $request)
    {
        $validated = $request->validated();

        $this->updateSettings($validated);

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "As configurações do site foram atualizados com sucesso.",
        ]);
    }

    /**
     * @param array $validated
     * @return null|Setting
     */
    public function updateSettings(array $validated)
    {
        $settings = Setting::where("name", "front_settings")->first();

        if (!$settings) {
            return null;
        }

        $content = $settings->content;

        $content->socials = $validated["socials"] ?? null;
        $content->header->menu_main = $validated["header"]["menu_main"]["id"] ?? null;
        $content->footer->menu_footer = $validated["footer"]["menu_footer"]["id"] ?? null;
        $content->pages = $validated["pages"];
        if ($faviconId = $validated["header"]["favicon"]["id"] ?? null) {
            $favicon = Image::where("id", $faviconId)->first();
            if ($favicon) {
                $content->header->favicon = $favicon->id;
            }
        } else {
            $content->header->favicon = $content->header->favicon->id ?? null;
        }

        if ($logoId = $validated["header"]["logo"]["id"] ?? null) {
            $logo = Image::where("id", $logoId)->first();
            if ($logo) {
                $content->header->logo = $logo->id;
            }
        } else {
            $content->header->logo = $content->header->logo->id ?? null;
        }

        $settings->content = json_encode($content);

        $settings->save();

        return $settings;
    }
}
