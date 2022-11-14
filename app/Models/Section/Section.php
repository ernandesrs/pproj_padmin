<?php

namespace App\Models\Section;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ["name", "title", "subtitle", "content", "buttons", "visible"];

    /**
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        if ($attributes["content"]["image"] == null) {
            $this->content = json_decode($this->content);
            $attributes["content"]["image"] = $this->content->image;
        }

        return parent::update($attributes, $options);
    }
}
