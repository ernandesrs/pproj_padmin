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
        $this->frontSettings($favicon, $logo, $banner, $defaultImages, $bindable);
    }

    /**
     * @return void
     */
    private function frontSettings($favicon, $logo, $section1, $section2, $section3)
    {
        $settingsName = "front_settings";
        if (Setting::where("name", $settingsName)->first()) {
            echo "front settings exists\n";
            return;
        }

        $menu = Menu::all()->first();

        $content = [
            "locale" => config("app.locale"),
            "header" => [
                "favicon" => $favicon->id,
                "logo" => $logo->id,
                "menu_main" => $menu ? $menu->id : null
            ],
            "pages" => [
                "home" => [
                    "section_1" => $section1->id,
                    "section_2" => $section2->id,
                    "section_3" => $section3->id,
                ]
            ],
            "footer" => [
                "menu_footer" => null,
            ],
        ];

        $settings = Setting::create([
            "name" => $settingsName,
            "title" => "Configurações do site",
            "description" => "Configurações do site",
            "content" => json_encode($content),
        ]);

        if (!$settings) {
            echo "default front settings create fail\n";
        } else {
            echo "default front settings created\n";
        }

        return $settings;
    }
}
