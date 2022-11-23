<?php

namespace App\Models\Front;

use App\Http\Resources\ImageResource;
use App\Models\Media\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'image', 'icon', 'price', 'old_price'];

    protected static function booted()
    {
        static::retrieved(function ($product) {
            $image = (Image::where('id', $product->image)->first());
            if ($image) {
                $product->image = new ImageResource($image);
            }
        });
    }
}
