<?php

namespace App\Models;

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

    /**
     * Create page
     *
     * @param array $validatedData
     * @return Page
     */
    public static function create(array $validatedData)
    {
        $page = new Page;
        $slug = Slug::create($validatedData["lang"], $validatedData["slug"]);

        $page->slug_id = $slug->id;
        $page->user_id = auth()->user()->id;
        $page->title = $validatedData["title"];
        $page->description = $validatedData["description"];
        $page->lang = $validatedData["lang"];
        $page->cover = $validatedData["cover"];
        $page->follow = $validatedData["follow"];
        $page->status = $validatedData["status"];
        $page->content_type = $validatedData["content_type"];

        $page->content = self::makeContent($validatedData);

        switch ($page->status) {
            case self::STATUS_SCHEDULED:
                $page->schedule_to = $validatedData["schedule_to"];
                break;
            case self::STATUS_PUBLISHED:
                $page->published_at = now();
                break;
        }

        $page->save();

        return $page;
    }

    /**
     * Make the page content for view or text content type
     *
     * @param array $validatedData
     * @return string|null
     */
    public static function makeContent(array $validatedData)
    {
        $content = null;
        switch ($validatedData["content_type"]) {
            case self::CONTENT_TYPE_TEXT:
                $content = $validatedData["content"];
                break;
            case self::CONTENT_TYPE_VIEW:
                $content = $validatedData["view_path"];
                break;
        }
        return $content;
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
}
