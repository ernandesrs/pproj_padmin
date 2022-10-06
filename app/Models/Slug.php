<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    use HasFactory;

    /**
     * Create and save the slug
     * 
     * @param string $lang the validated language
     * @param string $slug_str the validated slug
     * @return Slug
     */
    public static function create(string $lang, string $slug_str)
    {
        $slug = new Slug();

        $slug->$lang = $slug_str;
        $slug->save();

        return $slug;
    }
}
