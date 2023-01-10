<?php

namespace App\Console\Defaults;

use App\Models\Menu;
use App\Models\Setting;

class AppBuilder
{
    /**
     * The builder
     */
    public function build(string $mail, string $pass)
    {
        if (config("app.env") == "production") {
            echo "fail: project in production\n";
            return;
        }

        // default roles
        $visitorRole = (new RoleBuilder())->visitor();
        (new RoleBuilder())->administrator();

        // default users
        $master = (new UserBuilder())->master($mail, $pass);
        (new UserBuilder())->visitor($visitorRole);

        // default page cover
        $cover = (new ImageBuilder())->pageCover($master);

        // default pages
        (new PageBuilder())->homePage($master, $cover);
        (new PageBuilder())->privacyTermsPage($master, $cover);
        (new PageBuilder())->useTermsPage($master, $cover);

        // default sections
        $banner = (new SectionBuilder())->sectionBannerImages($master);
        $defaultImages = (new SectionBuilder())->sectionDefaultImages($master);
        $bindable = (new SectionBuilder())->sectionBindable($master);

        // default favicon and logo
        $favicon = (new ImageBuilder())->favicon($master);
        $logo = (new ImageBuilder())->logo($master);

        // default settings
        $this->settings($favicon, $logo, $banner, $defaultImages, $bindable);
    }

    /**
     * @return void
     */
    private function settings($favicon, $logo, $section1, $section2, $section3)
    {
        $frontSettingsName = "front_settings";
        $adminSettingsName = "admin_settings";
        if (Setting::where("name", $frontSettingsName)->first() || Setting::where("name", $adminSettingsName)->first()) {
            echo "Settings exists\n";
            return;
        }

        $frontMenu = Menu::all()->first();

        $frontSections = [
            "home" => [
                "section_1" => $section1->id,
                "section_2" => $section2->id,
                "section_3" => $section3->id,
            ]
        ];

        $frontSettings = Setting::create([
            "locale" => config("app.locale"),
            "name" => $frontSettingsName,
            "title" => "Configurações do site",
            "description" => "Configurações do site",
            "sections" => json_encode($frontSections),

            "favicon" => $favicon->id,
            "logo" => $logo->id,
            "menu_header" => $frontMenu->id,
            "menu_footer" => null,
        ]);

        $adminSettings = Setting::create([
            "locale" => config("app.locale"),
            "name" => $adminSettingsName,
            "title" => "Configurações do painel",
            "description" => "Configurações do painel",
            "sections" => json_encode([]),

            "favicon" => $favicon->id,
            "logo" => $logo->id,
            "menu_header" => null,
            "menu_footer" => null,
        ]);

        if (!$frontSettings) {
            echo "default front settings create fail\n";
        } else {
            echo "default front settings created\n";
        }

        if (!$adminSettings) {
            echo "default admin settings create fail\n";
        } else {
            echo "default admin settings created\n";
        }

        return;
    }
}
