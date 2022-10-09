<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Undocumented function
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->level >= User::LEVEL_8;
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
        return $user->level >= User::LEVEL_8 && ($user->id == $model->id || $user->level > $model->level);
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
        return $user->level >= User::LEVEL_8 && ($user->level > $model->level && $user->id !== $model->id);
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function promote(User $user, User $model)
    {
        if ($this->isMe($user, $model) || !$user->level >= USER::LEVEL_8)
            return false;
        return $model->nextLevel() ? $model->nextLevel() < $user->level : false;
    }

    /**
     * Undocumented function
     *
     * @param User $user
     * @param User $model
     * @return bool
     */
    public function demote(User $user, User $model)
    {
        if ($this->isMe($user, $model) || !$user->level >= USER::LEVEL_8)
            return false;
        return $model->level < $user->level;
    }

    /**
     * @param User $user
     * @param User $model
     * @return bool
     */
    private function isMe(User $user, User $model)
    {
        return $user->id == $model->id;
    }
}
