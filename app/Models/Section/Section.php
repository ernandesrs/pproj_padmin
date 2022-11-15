<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    const TYPE_DEFAULT = 0;
    const TYPE_BANNER = 1;
    const TYPE_BANNER_IMAGES = 2;
    const TYPES = [
        self::TYPE_DEFAULT,
        self::TYPE_BANNER,
    ];

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
        $attributes["buttons"] = json_encode($attributes["buttons"]);
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
        if ($attributes["content"]["image"] == null) {
            $attributes["content"]["image"] = $this->content->image;
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
}
