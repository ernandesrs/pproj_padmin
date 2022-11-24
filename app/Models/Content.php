<?php

namespace App\Models;

use App\Models\Section\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = ["name", "is_json", "content"];

    protected static function booted()
    {
        static::retrieved(function ($content) {
            if (in_array($content->name, ["front_settings"])) {
                $content->content = json_decode($content->content);

                // get home sections
                foreach ($content->content->home as $key => $homeSection) {
                    if ($homeSection) {
                        $content->content->home->$key = Section::where("id", $homeSection)->first();
                    }
                }

                // get header menu
                if ($content->content->header->menu_main) {
                    $content->content->header->menu_main = Menu::where("id", $content->content->header->menu_main)->first();
                }

                // get footer menu
                if ($content->content->footer->menu_main) {
                    $content->content->footer->menu_main = Menu::where("id", $content->content->footer->menu_main)->first();
                }
            }
        });
    }
}
