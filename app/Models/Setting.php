<?php

namespace App\Models;

use App\Models\Media\Image;
use App\Models\Section\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        "favicon",
        "logo",
        "menu_header",
        "menu_footer",
        "name",
        "title",
        "description",
        "sections"
    ];

    /**
     * Logo
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function logo()
    {
        return $this->hasOne(Image::class, "id", "logo");
    }

    /**
     * Favicon
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function favicon()
    {
        return $this->hasOne(Image::class, "id", "favicon");
    }

    /**
     * Booted
     *
     * @return void
     */
    protected static function booted()
    {
        static::retrieved(function ($setting) {
            // get sections
            $setting->sections = json_decode($setting->sections);

            // get socials
            $setting->socials = json_decode($setting->socials);

            // get logo and favicon
            $setting->logo = Image::where("id", $setting->logo)->first();
            $setting->favicon = Image::where("id", $setting->favicon)->first();

            // get header menu
            $setting->menu_header = Menu::where("id", $setting->menu_header)->first();

            // get page sections
            foreach ($setting->sections as $keyPage => $page) {
                foreach ($page as $keySection => $section) {
                    $setting->sections->$keyPage->$keySection = Section::where("id", $section)->first();
                }
            }

            // get footer menu
            $setting->menu_footer = Menu::where("id", $setting->menu_footer)->first();
        });
    }
}
