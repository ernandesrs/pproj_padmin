<?php

namespace App\Policies;

use App\Models\Front\Service;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServicePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @param Service $service
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Service $service)
    {
        return $user->level >= User::LEVEL_8;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Service $service
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Service $service)
    {
        return $user->level >= User::LEVEL_8;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Service $service
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Service $service)
    {
        return $user->level >= User::LEVEL_8;
    }
}
