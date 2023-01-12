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

        // default sections
        $banner = (new SectionBuilder())->sectionBannerImages($master);
        $defaultImages = (new SectionBuilder())->sectionDefaultImages($master);
        $bindable = (new SectionBuilder())->sectionBindable($master);

        // default pages
        (new PageBuilder())->homePage($master, $cover, $banner, $defaultImages, $bindable);
        (new PageBuilder())->privacyTermsPage($master, $cover);
        (new PageBuilder())->useTermsPage($master, $cover);

        // default favicon and logo
        $favicon = (new ImageBuilder())->favicon($master);
        $logo = (new ImageBuilder())->logo($master);

        // default settings
        $this->settings($favicon, $logo);
    }

    /**
     * @return void
     */
    private function settings($favicon, $logo)
    {
        $frontSettingsName = "front_settings";
        $adminSettingsName = "admin_settings";
        if (Setting::where("name", $frontSettingsName)->first() || Setting::where("name", $adminSettingsName)->first()) {
            echo "Settings exists\n";
            return;
        }

        $frontMenu = Menu::all()->first();

        $frontSettings = Setting::create([
            "locale" => config("app.locale"),
            "name" => $frontSettingsName,
            "title" => "Configurações do site",
            "description" => "Configurações do site",

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
