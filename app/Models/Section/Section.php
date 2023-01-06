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
     * Create Section
     *
     * @param array $validated
     * @return Section
     */
    public static function create(array $validated)
    {
        $images = null;

        $validated["buttons"] = json_encode($validated["buttons"] ?? []);
        switch ($validated["type"]) {
            case self::TYPE_DEFAULT:
                $images = self::getImages($validated);
                unset($validated["bindable_class"]);
                break;
            case self::TYPE_BANNER:
                $images = self::getImages($validated);
                unset($validated["bindable_class"]);
                break;
            case self::TYPE_BINDABLE:
                unset($validated["content"]);
                break;
        }

        unset($validated["images"]);

        $section = (new Section($validated));

        if (!$section->save())
            return null;

        if ($images)
            $section->images()->attach($images);

        return $section;
    }

    /**
     * Get images
     *
     * @param array $validated
     * @return array
     */
    public static function getImages(array $validated)
    {
        $images = $validated["images"] ?? [];
        return array_filter($images, function ($image) {
            if ($image) return $image;
        });
    }

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
