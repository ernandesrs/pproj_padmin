<?php

namespace App\Policies\Media;

use App\Models\Media\Image;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    /**
     * View any
     *
     * @param User $user
     * @return boolean
     */
    public function viewAny(User $user)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission("viewAny", Image::class);
    }

    /**
     * View any
     *
     * @param User $user
     * @return boolean
     */
    public function view(User $user, Image $image)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission("view", Image::class);
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission("create", Image::class);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  Image  $image
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Image $image)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission("udpate", Image::class);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Image  $image
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Image $image)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission("delete", Image::class);
    }
}
