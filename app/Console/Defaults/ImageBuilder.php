<?php

namespace App\Console\Defaults;

use App\Http\Services\ImageService;
use App\Models\Media\Image;
use App\Models\User;
use Illuminate\Http\File;
use Illuminate\Http\UploadedFile;

class ImageBuilder
{
    /**
     * Save the default page cover
     *
     * @param User $author
     * @return Image
     */
    public function pageCover(User $author)
    {
        $image = $this->save($author, resource_path("img/default-cover.jpg"), "pages/cover");
        echo "default page cover saved\n";
        return $image;
    }

    /**
     * Default favicon upload
     *
     * @param User $author
     * @return Image
     */
    public function favicon(User $author)
    {
        $image = $this->save($author, resource_path("img/favicon.svg"));
        echo "default favicon saved\n";
        return $image;
    }

    /**
     * Default logo upload
     *
     * @param User $author
     * @return Image
     */
    public function logo(User $author)
    {
        $image = $this->save($author, resource_path("img/logo.svg"));
        echo "default logo saved\n";
        return $image;
    }

    /**
     * Save image
     *
     * @param User $author
     * @param string $fullPath
     * @param string $subdir
     * @return Image
     */
    public function save(User $author, string $fullPath, ?string $subdir = null)
    {
        $file = new File($fullPath);
        $upload = new UploadedFile($file->getPathname(), $file->getBasename());

        return (new ImageService())->store([
            "file" => $upload,
        ], $subdir, $author);
    }
}
