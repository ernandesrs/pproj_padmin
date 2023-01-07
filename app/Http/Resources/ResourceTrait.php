<?php

namespace App\Http\Resources;

use App\Helpers\Thumb;
use Illuminate\Support\Facades\Storage;

trait ResourceTrait
{
    /**
     * Return an array with the maked thumbnails, requested via flash session (on array field 'mk_thumb')
     *
     * @param string $fieldName the image field name on resource
     * @param null|array $arr
     * @param null|string $type
     * @return array
     */
    protected function thumbs(string $fieldName, ?array $arr = null, ?string $type = null)
    {
        $arrThumbs = [];
        $arrThumbs[$fieldName . "_url"] = Storage::url($this->$fieldName);
        $arrThumbs["location"] = Storage::url($this->$fieldName); // to tinymce response
        if ($thumbs = session()->get("mk_thumb")) {
            if (in_array("small", $thumbs))
                $arrThumbs["thumb_small"] = Thumb::thumb($this->$fieldName, ($type ?? "rectangle") . ".small");
            if (in_array("large", $thumbs))
                $arrThumbs["thumb_large"] = Thumb::thumb($this->$fieldName, ($type ?? "rectangle") . ".large");
            if (in_array("normal", $thumbs))
                $arrThumbs["thumb_normal"] = Thumb::thumb($this->$fieldName, ($type ?? "rectangle") . ".normal");
        }

        if (!$arr) return $arrThumbs;

        return array_merge($arr, $arrThumbs);
    }
}
