<?php

namespace App\Policies;

use App\Models\Media\Image;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ImagePolicy
{
    use HandlesAuthorization;

    /**
     * Undocumented function
     *
     * @param User $user
     * @param Image $image
     * @return bool
     */
    public function create(User $user, Image $image)
    {
        return $user->level >= User::LEVEL_8;
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
        if (!$image->user_id) return true;

        $author = $image->user();

        return $user->level >= User::LEVEL_8 && (($user->id == $author->id) || ($user->level > $author->level));
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
        if (!$image->user_id) return true;

        $author = $image->user();

        return $user->level >= User::LEVEL_8 && (($user->id == $author->id) || ($user->level > $author->level));
    }
}
