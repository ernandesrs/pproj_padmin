<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    const TYPE_DEFAULT = 0;
    const TYPE_DEFAULT_IMAGES = 1;
    const TYPE_BANNER = 2;
    const TYPE_BANNER_IMAGES = 3;
    const TYPE_BOUND = 4;
    const TYPES = [
        self::TYPE_DEFAULT,
        self::TYPE_DEFAULT_IMAGES,
        self::TYPE_BANNER,
        self::TYPE_BANNER_IMAGES,
        self::TYPE_BOUND
    ];

    const BINDABLES = [
        "service" => \App\Models\Front\Service::class
    ];

    /**
     * Bindable models
     *
     * @var array
     */
    public $bindables = self::BINDABLES;

    /**
     * @var array
     */
    protected $fillable = ["type", "name", "title", "subtitle", "content", "buttons", "visible"];

    /**
     * Undocumented function
     *
     * @param array $attributes
     * @return
     */
    public static function create(array $attributes)
    {
        $attributes["buttons"] = json_encode($attributes["buttons"] ?? []);
        $attributes["content"] = json_encode($attributes["content"]);

        $section = new Section($attributes);
        $section->save();

        return $section;
    }

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        if (in_array($this->type, [self::TYPE_DEFAULT, self::TYPE_BANNER]) && $attributes["content"]["image"] == null) {
            $attributes["content"]["image"] = $this->content->image;
        }

        if (in_array($this->type, [self::TYPE_DEFAULT_IMAGES, self::TYPE_BANNER_IMAGES]) && $attributes["content"]["images"] == null) {
            $attributes["content"]["images"] = [];
        }

        return parent::update($attributes, $options);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::retrieved(function ($section) {
            $section->content = json_decode($section->content);
            $section->buttons = json_decode($section->buttons);
            return $section;
        });
    }

    /**
     * Undocumented function
     *
     * @return null||\Illuminate\Database\Eloquent\Collection
     */
    public function bindables()
    {
        $collection = null;
        if ($this->type == self::TYPE_BOUND) {
            $bindable = self::BINDABLES[$this->content->bindable] ?? null;
            if ($bindable) {
                $collection = (new $bindable())->all();
            }
        }
        return $collection;
    }
}
