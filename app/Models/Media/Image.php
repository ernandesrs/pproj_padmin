<?php

namespace App\Models\Media;

use App\Models\Page;
use App\Models\Section\Section;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ["user_id", "name", "tags", "size", "extension", "path"];

    /**
     * Return the upload author
     *
     * @return User|null
     */
    public function user()
    {
        return $this->hasOne(User::class, "id", "user_id")->first();
    }

    /**
     * Sections
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function sections()
    {
        return $this->morphedByMany(Section::class, "imageable");
    }

    /**
     * Pages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pages()
    {
        return $this->hasMany(Page::class, "cover", "id");
    }

    /**
     * Booted
     *
     * @return void
     */
    protected static function booted()
    {
        static::retrieved(function ($image) {
            $image->url = Storage::url($image->path);
        });
    }
}
