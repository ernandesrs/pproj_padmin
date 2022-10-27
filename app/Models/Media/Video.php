<?php

namespace App\Models\Media;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
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
}
