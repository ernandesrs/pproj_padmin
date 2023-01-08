<?php

namespace App\Models;

use App\Models\Media\Image;
use App\Models\Section\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ["name", "title", "description", "content"];

    /**
     * Booted
     *
     * @return void
     */
    protected static function booted()
    {
        static::retrieved(function ($setting) {
            $setting->content = json_decode($setting->content);

            // get logo and favicon
            $setting->content->header->logo = Image::where("id", $setting->content->header->logo)->first();
            $setting->content->header->favicon = Image::where("id", $setting->content->header->favicon)->first();

            // get header menu
            $setting->content->header->menu_main = Menu::where("id", $setting->content->header->menu_main)->first();

            // get page sections
            foreach ($setting->content->pages as $keyPage => $page) {
                foreach ($page as $keySection => $section) {
                    $setting->content->pages->$keyPage->$keySection = Section::where("id", $section)->first();
                }
            }

            // get footer menu
            $setting->content->footer->menu_footer = Menu::where("id", $setting->content->footer->menu_footer)->first();
        });
    }
}
