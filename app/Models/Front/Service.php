<?php

namespace App\Models\Front;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['title', 'icon', 'description'];

    /**
     * Undocumented function
     *
     * @param array $attr
     * @return Service
     */
    public static function create(array $attr)
    {
        $service = new Service();

        $service->title = $attr['title'];
        $service->icon = $attr['icon'];
        $service->description = $attr['description'];

        $service->save();

        return $service;
    }

    /**
     * Undocumented function
     *
     * @param array $attr
     * @param array $options
     * @return Service
     */
    public function update(array $attr = [], array $options = [])
    {
        return parent::update($attr, $options);
    }
}
