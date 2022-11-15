<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ["name", "title", "subtitle", "content", "buttons", "visible"];

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
