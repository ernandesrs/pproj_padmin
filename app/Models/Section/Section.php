<?php

namespace App\Models\Section;

use App\Models\Front\Service;
use App\Models\Media\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

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
        $validated = self::organizeData($validated);
        $images = $validated["images"] ?? null;
        $validated["buttons"] = json_encode($validated["buttons"] ?? []);

        unset($validated["images"]);

        $section = (new Section($validated));

        if (!$section->save())
            return null;

        if ($images)
            $section->images()->attach($images);

        return $section;
    }

    /**
     * Update section
     *
     * @param array $attributes
     * @param array $options
     * @return Section
     */
    public function update(array $attributes = [], array $options = [])
    {
        $validated = self::organizeData($attributes);
        $images = $validated["images"] ?? null;
        $validated["buttons"] = json_encode($validated["buttons"] ?? []);

        unset($validated["images"]);

        if ($images) {
            $existingImagesId = $this->images->map(function ($image) {
                return $image->id;
            })->toArray();
            $imagesToDetach = array_diff($existingImagesId, $images);
            $imagesToAttach = array_diff($images, $existingImagesId);

            if ($imagesToDetach)
                $this->images()->detach($imagesToDetach);

            if ($imagesToAttach)
                $this->images()->attach($imagesToAttach);
        }

        return parent::update($validated, $options);
    }

    /**
     * Organize data, get images id, remove not required field on specific section types
     *
     * @param array $validated
     * @return array
     */
    private static function organizeData(array $validated)
    {
        switch ($validated["type"]) {
            case self::TYPE_DEFAULT:
                $validated["images"] = self::getImagesId($validated);
                unset($validated["bindable_class"]);
                break;
            case self::TYPE_BANNER:
                $validated["images"] = self::getImagesId($validated);
                unset($validated["bindable_class"]);
                break;
            case self::TYPE_BINDABLE:
                unset($validated["images"], $validated["content"]);
                break;
        }
        return $validated;
    }

    /**
     * Get images
     *
     * @param array $validated
     * @return null|array
     */
    public static function getImagesId(array $validated)
    {
        if (empty($validated["images"]))
            return null;

        $images = $validated["images"];
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
