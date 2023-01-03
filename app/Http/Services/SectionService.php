<?php

namespace App\Http\Services;

use App\Models\Media\Image;
use App\Models\Section\Section;

class SectionService
{
    /**
     * Store a new section
     *
     * @param array $validated
     * @return Section
     */
    public function store(array $validated)
    {
        return Section::create($this->getImage($validated));
    }

    /**
     * Update section
     *
     * @param Section $section
     * @param array $validated
     * @return Section
     */
    public function update(Section $section, array $validated)
    {
        return $section->update($this->getImage($validated, $section));
    }

    /**
     * Undocumented function
     *
     * @param array $validated
     * @param Section|null $section
     * @return array
     */
    private function getImage(array $validated, ?Section $section = null)
    {
        $type = $section ? $section->type : $validated["type"];

        if (in_array($type, [Section::TYPE_DEFAULT, Section::TYPE_BANNER])) {
            $image = $validated["content"]["image"] ?? null;
            if ($image) {
                $image = Image::where("id", $image)->first();
                if ($image) {
                    $image = $image->path;
                }
            }
            $validated["content"]["image"] = $image;
        } else {
            $images = $validated["content"]["images"] ?? [];
            foreach ($images as $key => $image) {
                $imageModel = Image::where("id", $image["id"] ?? 0)->first();
                if ($imageModel) {
                    $images[$key]["path"] = $imageModel->path;
                    $images[$key]["interval"] = ($image["interval"] ?? 2.5) * 1000;
                } else
                    unset($images[$key]);
            }
            $validated["content"]["images"] = $images;
        }
        return $validated;
    }
}
