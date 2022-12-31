<?php

namespace App\Models\Admin;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'rulables'];

    public const RULES = ['view', 'viewAny', 'create', 'update', 'delete', 'forceDelete', 'restory'];
    public const RULABLES = [
        'role',
        'service',
        'image',
        'video',
        'section',
        'content',
        'menu',
        'page',
        'user'
    ];

    /**
     * Create role
     *
     * @param array $validated
     * @return Role
     */
    public function create(array $validated)
    {
        $this->name = $validated['name'];
        $this->rulables = json_encode($this->setRules($validated['rulables']));
        $this->save();

        return $this;
    }

    /**
     * Update role
     *
     * @param array $attributes
     * @param array $options
     * @return bool
     */
    public function update(array $attributes = [], array $options = [])
    {
        $attributes['rulables'] = json_encode($this->setRules($attributes['rulables']));
        return parent::update($attributes, $options);
    }

    /**
     * Users
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }

    /**
     * Define rule to rullables
     *
     * @param array $rulables
     * @return array
     */
    public function setRules(array $rulables)
    {
        $arr = array_fill_keys(self::RULABLES, array_fill_keys(self::RULES, false));

        foreach ($rulables as $rulable => $rules) {
            foreach ($rules as $ruleKey => $ruleValue) {
                $arr[$rulable][$ruleKey] = $ruleValue;
            }
        }

        return $arr;
    }

    /**
     * Booted
     *
     * @return void
     */
    protected static function booted()
    {
        static::retrieved(function ($role) {
            $role->rulables = json_decode($role->rulables);
        });
    }
}
