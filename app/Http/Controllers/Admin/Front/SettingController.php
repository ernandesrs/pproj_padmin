<?php

namespace App\Http\Controllers\Admin\Front;

use App\Helpers\Thumb;
use App\Http\Controllers\Controller;
use App\Http\Requests\FrontSettingRequest;
use App\Http\Resources\MenuResource;
use App\Models\Content;
use App\Models\Media\Image;
use App\Models\Menu;
use App\Models\Section\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

        $menus = MenuResource::collection(Menu::all());
        $sections = Section::where("visible", true)->get();

        if ($favicon = $settings->content->header->favicon) {
            $settings->content->header->favicon_url = Thumb::thumb($favicon);
        } else {
            $settings->content->header->favicon_url = null;
        }

        if ($logo = $settings->content->header->logo) {
            $settings->content->header->logo_url = Thumb::thumb($logo);
        } else {
            $settings->content->header->logo_url = null;
        }

        return Inertia::render("Admin/Front/Settings", [
            "settings" => $settings,
            "menus" => $menus,
            "sections" => $sections,
            "images" => session()->get("images", null),
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
        $validated = $this->validated($request);

        $this->updateSettings($validated);

        return back()->with("flash_alert", [
            "variant" => "success",
            "message" => "As configurações do site foram atualizados com sucesso.",
        ]);
    }

    /**
     * @param array $validated
     * @return null|Content
     */
    public function updateSettings(array $validated)
    {
        $settings = Content::where("name", "front_settings")->first();
        if (!$settings) {
            return null;
        }

        $content = json_decode($settings->content);

        $content->header->menu_main = $validated["header"]["menu_main"] ?? null;
        $content->footer->menu_main = $validated["footer"]["menu_main"] ?? null;
        $content->sections = $validated["sections"];

        if ($faviconId = $validated["header"]["favicon"] ?? null) {
            $favicon = Image::where("id", $faviconId)->first();
            if ($favicon) {
                $content->header->favicon = $favicon->path;
            }
        }

        if ($logoId = $validated["header"]["logo"] ?? null) {
            $logo = Image::where("id", $logoId)->first();
            if ($logo) {
                $content->header->logo = $logo->path;
            }
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
        $data = $request->only([
            "header.favicon",
            "header.logo",
            "header.menu_main",

            "sections.section_1",
            "sections.section_2",
            "sections.section_3",

            "footer.menu_main",
        ]);
        $validator = Validator::make($data,[
            "header.favicon" => ["nullable", "numeric", "exists:images,id"],
            "header.logo" => ["nullable", "numeric", "exists:images,id"],
            "header.menu_main" => ["nullable", "numeric", "exists:menus,id"],

            "sections.section_1" => ["nullable", "numeric", "exists:sections,id"],
            "sections.section_2" => ["nullable", "numeric", "exists:sections,id"],
            "sections.section_3" => ["nullable", "numeric", "exists:sections,id"],

            "footer.menu_main" => ["nullable", "numeric", "exists:menus,id"],
        ]);

        $section_1 = Section::where("id", $data["sections"]["section_1"] ?? 0)->first();
        $section_2 = Section::where("id", $data["sections"]["section_2"] ?? 0)->first();
        $section_3 = Section::where("id", $data["sections"]["section_3"] ?? 0)->first();
        if($section_1 && !in_array($section_1->type, [Section::TYPE_BANNER])){
            $validator->errors()->add("sections.section_1", "Tipo de seção não aceito");
        }

        if($section_2 && !in_array($section_2->type, [Section::TYPE_DEFAULT])){
            $validator->errors()->add("sections.section_2", "Tipo de seção não aceito");
        }
        
        if($section_3 && !in_array($section_3->type, [Section::TYPE_DEFAULT])){
            $validator->errors()->add("sections.section_3", "Tipo de seção não aceito");
        }
        
        return $validator->validate();
    }
}
