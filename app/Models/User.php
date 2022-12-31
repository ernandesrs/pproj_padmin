<?php

namespace App\Models;

use App\Models\Admin\Role;
use App\Models\Media\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public const LEVEL_1 = 1;
    public const LEVEL_2 = 2;
    public const LEVEL_8 = 8;
    public const LEVEL_MASTER = 9;
    public const LEVELS = [
        self::LEVEL_1,
        self::LEVEL_2,
        self::LEVEL_8,
        self::LEVEL_MASTER,
    ];

    public const GENDER_NONE = 0;
    public const GENDER_MALE = 1;
    public const GENDER_FEMALE = 2;
    public const GENDERS = [
        self::GENDER_NONE,
        self::GENDER_MALE,
        self::GENDER_FEMALE,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'level',
        'gender',
        'photo',
        'email',
        'confirmation_token',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'confirmation_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User uploaded images
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(Image::class);
    }

    /**
     * User levels
     * @return array
     */
    public static function levels()
    {
        return self::LEVELS;
    }

    /**
     * User genders
     * @return array
     */
    public static function genders()
    {
        return self::GENDERS;
    }

    /**
     * @return null|int
     */
    public function nextLevel()
    {
        $level = null;

        switch ($this->level) {
            case self::LEVEL_1:
                $level = self::LEVEL_2;
                break;
            case self::LEVEL_2:
                $level = self::LEVEL_8;
                break;
        }

        return $level;
    }

    /**
     * @return null|int
     */
    public function previousLevel()
    {
        $level = null;

        switch ($this->level) {
            case self::LEVEL_8:
                $level = self::LEVEL_2;
                break;
            case self::LEVEL_2:
                $level = self::LEVEL_1;
                break;
        }

        return $level;
    }

    /**
     * Is superadmin
     *
     * @return boolean
     */
    public function isSuperadmin()
    {
        return $this->level === self::LEVEL_MASTER;
    }

    /**
     * User role
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Check if user has $ability to $modelClass
     *
     * @param string $ability
     * @param string|null $modelClass
     * @return boolean
     */
    public function hasPermission(string $ability, ?string $modelClass = null)
    {
        $role = $this->roles()->first();
        if (!$role) return false;

        return $role->has($ability, $modelClass);
    }
}
