<?php

namespace App\Policies\Media;

use App\Models\Media\Video;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class VideoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission('viewAny', Video::class);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Media\Video  $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, Video $video)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission('view', Video::class);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission('create', Video::class);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Media\Video  $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Video $video)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission('update', Video::class);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Media\Video  $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Video $video)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission('delete', Video::class);
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Media\Video  $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, Video $video)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission('restore', Video::class);
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Media\Video  $video
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, Video $video)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission('forceDelete', Video::class);
    }
}
