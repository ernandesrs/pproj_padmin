<?php

namespace App\Models\Section;

use App\Models\Front\Service;
use App\Models\Media\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    const TYPE_DEFAULT = "default";
    const TYPE_BANNER = "banner";
    const TYPE_BINDABLE = "bindable";
    const TYPES = [
        self::TYPE_DEFAULT,
        self::TYPE_BANNER,
        self::TYPE_BINDABLE
    ];

    const BINDABLES = [
        "service" => Service::class
    ];

    protected $fillable = [
        "type",
        "name",
        "title",
        "subtitle",
        "content",
        "buttons",
        "bindable_class",
        "visible"
    ];

    /**
     * Section images
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function images()
    {
        return $this->morphToMany(Image::class, "imageable");
    }

    /**
     * Booted
     *
     * @return void
     */
    protected static function booted()
    {
        static::retrieved(function ($section) {
            $section->buttons = json_decode($section->buttons);
        });
    }
}
