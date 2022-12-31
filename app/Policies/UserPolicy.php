<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
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

        return $user->hasPermission('viewAny', User::class);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  User $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, User $model)
    {
        if ($user->isSuperadmin()) return true;

        return $user->hasPermission('view', User::class);
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

        return $user->hasPermission('create', User::class);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, User $model)
    {
        if ($user->id === $model->id) return false;

        if ($user->isSuperadmin()) return true;

        return $user->hasPermission('update', User::class) && $user->level > $model->level;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\User  $model
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, User $model)
    {
        if ($user->id === $model->id) return false;

        if ($user->isSuperadmin()) return true;

        return $user->hasPermission('delete', User::class) && $user->level > $model->level;
    }
}
