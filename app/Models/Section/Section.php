<?php

namespace App\Models\Section;

use App\Models\Front\Service;
use App\Models\Media\Image;
use App\Models\Page;
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
        "images_settings",
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
        $images = $validated["images"] ?? [];
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
        $images = $validated["images"] ?? [];
        $validated["buttons"] = json_encode($validated["buttons"] ?? []);

        unset($validated["images"]);

        if ($images) {
            $this->images()->sync($images);
            // $existingImagesId = $this->images->map(function ($image) {
            //     return $image->id;
            // })->toArray();
            // $imagesToDetach = array_diff($existingImagesId, $images);
            // $imagesToAttach = array_diff($images, $existingImagesId);

            // if ($imagesToDetach)
            //     $this->images()->detach($imagesToDetach);

            // if ($imagesToAttach)
            //     $this->images()->attach($imagesToAttach);
        }

        return parent::update($validated, $options);
    }

    /**
     * Delete section
     *
     * @return bool
     */
    public function delete()
    {
        $this->images()->detach();
        return parent::delete();
    }

    /**
     * Get images settings
     *
     * @param array $validated
     * @return array
     */
    public static function getImagesSettings(array $validated)
    {
        return array_map(function ($image) {
            return [
                "id" => $image["id"],
                "duration" => $image["duration"],
            ];
        }, $validated["images"] ?? []);
    }

    /**
     * Get images
     *
     * @param array $validated
     * @return array
     */
    public static function getImagesId(array $validated)
    {
        return array_map(function ($image) {
            if ($id = $image["id"] ?? null) {
                return $id;
            }
        }, $validated["images"] ?? []);
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
                $validated["images_settings"] = json_encode(self::getImagesSettings($validated));
                $validated["images"] = self::getImagesId($validated);
                unset($validated["bindable_class"]);
                break;
            case self::TYPE_BANNER:
                $validated["images_settings"] = json_encode(self::getImagesSettings($validated));
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
     * Undocumented function
     *
     * @return void
     */
    public function bindables()
    {
        if ($this->type !== self::TYPE_BINDABLE)
            return null;

        $bindableClass = self::BINDABLES[$this->bindable_class] ?? null;
        if (!$bindableClass)
            return null;

        return (new $bindableClass())->all();
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
     * Images merget with images settings
     *
     * @return 
     */
    public function imagesMergedWithImagesSettings()
    {
        $images = $this->images;
        return Collection::make($this->images_settings)->map(function ($image_setting) use ($images) {
            $finded = $images->where("id", $image_setting->id)->first();
            if ($finded) {
                $finded->duration = $image_setting->duration;
                return $finded;
            }
        });
    }

    /**
     * Pages
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pages()
    {
        return $this->belongsToMany(Page::class, "section_page", "section_id", "page_id");
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
            $section->images_settings = json_decode($section->images_settings);
        });
    }
}
