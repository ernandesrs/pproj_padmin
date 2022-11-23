<?php

namespace App\Models\Front;

use App\Http\Resources\ImageResource;
use App\Models\Media\Image;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = ['title', 'image', 'icon', 'price', 'old_price'];

    /**
     * Undocumented function
     *
     * @param array $attr
     * @return Product
     */
    public static function create(array $attr)
    {
        $product = new Product();

        $product->title = $attr['title'];
        $product->image = $attr['image']['id'];
        $product->icon = $attr['icon'];
        $product->price = $attr['price'];
        $product->old_price = $attr['old_price'];

        $product->save();

        return $product;
    }

    /**
     * Undocumented function
     *
     * @param array $attr
     * @param array $options
     * @return Product
     */
    public function update(array $attr = [], array $options = [])
    {
        $attr['image'] = $attr['image']['id'];

        return parent::update($attr, $options);
    }

    /**
     * Undocumented function
     *
     * @return void
     */
    protected static function booted()
    {
        static::retrieved(function ($product) {
            $product->image = json_decode($product->image);

            $image = (Image::where('id', $product->image)->first());

            if ($image) {
                $product->image = new ImageResource($image);
            }
        });
    }
}
