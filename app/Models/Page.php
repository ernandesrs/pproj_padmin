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
}
