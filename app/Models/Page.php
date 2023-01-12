<?php

namespace App\Models;

use App\Models\Media\Image;
use App\Models\Section\Section;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;

    public const CONTENT_TYPE_TEXT = 1;
    public const CONTENT_TYPE_VIEW = 2;

    public const STATUS_DRAFT = 1;
    public const STATUS_SCHEDULED = 2;
    public const STATUS_PUBLISHED = 3;

    public const PROTECTION_NONE = 1;
    public const PROTECTION_AUTHOR = 2;
    public const PROTECTION_SYSTEM = 9;

    /**
     * Allowed content types
     * @param array<string>
     */
    public const CONTENT_TYPES = [self::CONTENT_TYPE_TEXT, self::CONTENT_TYPE_VIEW];

    /**
     * Allowed status
     * @param array<string>
     */
    public const STATUS = [self::STATUS_DRAFT, self::STATUS_SCHEDULED, self::STATUS_PUBLISHED];

    public const PROTECTIONS = [self::PROTECTION_NONE, self::PROTECTION_AUTHOR, self::PROTECTION_SYSTEM];

    protected $fillable = ["title", "description", "cover", "lang", "content_type", "content", "sections_settings", "status", "published_at", "schedule_to", "follow"];

    /**
     * Create page
     *
     * @param array $validatedData
     * @return Page
     */
    public static function create(array $validatedData, ?User $author = null)
    {
        $page = new Page;
        $slug = Slug::create($validatedData["lang"], $validatedData["slug"]);

        $page->slug_id = $slug->id;
        $page->user_id = $author ? $author->id : auth()->user()->id;
        $page->title = $validatedData["title"];
        $page->description = $validatedData["description"];
        $page->lang = $validatedData["lang"];
        $page->cover = $validatedData["cover"];
        $page->follow = $validatedData["follow"];
        $page->status = $validatedData["status"];
        $page->content_type = $validatedData["content_type"];

        if ($page->content_type == self::CONTENT_TYPE_VIEW) {
            $page->sections_settings = json_encode($validatedData["sections_settings"] ?? []);
        } else if ($page->content == self::CONTENT_TYPE_TEXT) {
            $page->content = $validatedData["content"];
        }

        switch ($page->status) {
            case self::STATUS_SCHEDULED:
                $page->schedule_to = $validatedData["schedule_to"];
                break;
            case self::STATUS_PUBLISHED:
                $page->published_at = now();
                break;
        }

        if ($validatedData["protection"] ?? null)
            $page->protection = $validatedData["protection"];

        $page->save();

        if ($page->content_type == self::CONTENT_TYPE_VIEW) {
            $page->sections()->attach(self::onlySectionsIds($validatedData));
        }

        return $page;
    }

    /**
     * The page update
     * 
     * @param array $attributes the validated data
     * @param array $options
     * @return boolean
     */
    public function update(array $attributes = [], array $options = [])
    {
        switch ($attributes["status"]) {
            case self::STATUS_SCHEDULED:
                $attributes["published_at"] = null;
                break;
            case self::STATUS_PUBLISHED:
                $attributes["schedule_to"] = null;

                if ($this->status != self::STATUS_PUBLISHED)
                    $attributes["published_at"] = now();
                break;
            case $this::STATUS_DRAFT:
                $attributes["schedule_to"] = null;
                $attributes["published_at"] = null;
                break;
        }

        $attributes["sections_settings"] = json_encode($attributes["sections_settings"] ?? []);
        if (($attributes["content_type"] ?? $this->content_type) == self::CONTENT_TYPE_VIEW) {
            $this->sections()->sync(self::onlySectionsIds($attributes));
        }

        return parent::update($this->safeAttributes($attributes), $options);
    }

    /**
     * Delete section
     *
     * @return bool
     */
    public function delete()
    {
        $this->sections()->detach();
        return parent::delete();
    }

    /**
     * Only sections ids
     *
     * @param array $validated
     * @return array
     */
    private static function onlySectionsIds(array $validated)
    {
        return array_map(function ($item) {
            return $item["id"];
        }, $validated["sections"] ?? []);
    }

    /**
     * Remove fields not needed on attributes array
     * 
     * @param array $attributes
     * @return array
     */
    private function safeAttributes(array $attributes)
    {
        if ($this->protection == Page::PROTECTION_SYSTEM) {
            // not needed for system pages
            unset($attributes["content_type"]);
            unset($attributes["status"]);
        }

        if (!$attributes["cover"])
            unset($attributes["cover"]);

        // no longer needed for the update
        unset($attributes["slug"]);
        unset($attributes["sections"]);

        return $attributes;
    }

    /**
     * Find page by slug
     *
     * @param string $slug the page slug
     * @param string|null $lang the page language
     * @return null|\Illuminate\Database\Eloquent\Builder
     */
    public static function findBySlug(string $slug, ?string $lang = null)
    {
        $slug = Slug::where($lang ?? config("app.name"), $slug)->first();
        return $slug ? $slug->pages() : null;
    }

    /**
     * Booted
     *
     * @return void
     */
    protected static function booted()
    {
        static::retrieved(function ($page) {
            $page->sections_settings = json_decode($page->sections_settings);
        });
    }

    /**
     * Page cover
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function cover()
    {
        return $this->hasOne(Image::class, "id", "cover");
    }

    /**
     * Return the page slugs
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function slugs()
    {
        return $this->hasOne(Slug::class, "id", "slug_id");
    }

    /**
     * Return the page author
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function author()
    {
        return $this->hasOne(User::class, "id", "user_id");
    }

    /**
     * Sections
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class, "section_page", "page_id", "section_id");
    }
}
