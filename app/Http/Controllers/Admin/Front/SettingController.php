<?php

namespace App\Http\Controllers\Admin\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Http\Resources\MenuResource;
use App\Http\Resources\SettingResource;
use App\Models\Media\Image;
use App\Models\Menu;
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

        $this->authorize("view", $settings);

        $menus = MenuResource::collection(Menu::all());

        return Inertia::render("Admin/Front/Settings", [
            "settings" => new SettingResource($settings),
            "terms" => __("terms"),
            "menus" => $menus,
            "pageTitle" => "Configurações de: " . config("app.name"),
        ]);
    }

    /**
     * Undocumented function
     *
     * @param SettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SettingRequest $request)
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

        $this->authorize("update", $settings);

        $settings->socials = json_encode($validated["socials"] ?? []);
        $settings->menu_header = $validated["menu_header"]["id"] ?? $settings->menu_header;
        $settings->menu_footer = $validated["menu_footer"]["id"] ?? $settings->menu_footer;

        if ($faviconId = $validated["favicon"] ?? null) {
            $favicon = Image::where("id", $faviconId)->first();
            if ($favicon) {
                $settings->favicon = $favicon->id;
            }
        } else {
            $settings->favicon = $settings->favicon->id ?? null;
        }

        if ($logoId = $validated["logo"] ?? null) {
            $logo = Image::where("id", $logoId)->first();
            if ($logo) {
                $settings->logo = $logo->id;
            }
        } else {
            $settings->logo = $settings->logo->id ?? null;
        }

        $settings->save();

        return $settings;
    }
}
