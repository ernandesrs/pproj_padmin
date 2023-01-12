<?php

namespace App\Models;

use App\Models\Media\Image;
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
        "description"
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
            // get socials
            $setting->socials = json_decode($setting->socials ?? []);
        });
    }
}
