<?php

namespace App\Policies;

use App\Models\Media\Video;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * Undocumented function
     *
     * @param User $user
     * @param Video $video
     * @return bool
     */
    public function create(User $user, Video $video)
    {
        return $user->level >= User::LEVEL_8;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  Video  $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Video $video)
    {
        if (!$video->user_id) return true;

        $author = $video->user();

        return $user->level >= User::LEVEL_8 && (($user->id == $author->id) || ($user->level > $author->level));
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  Video  $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Video $video)
    {
        if (!$video->user_id) return true;

        $author = $video->user();

        return $user->level >= User::LEVEL_8 && (($user->id == $author->id) || ($user->level > $author->level));
    }
}
