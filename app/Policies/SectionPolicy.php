<?php

namespace App\Policies;

use App\Models\Section\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SectionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @param Section $section
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user, Section $section)
    {
        return $user->level >= User::LEVEL_8;
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Section $section
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Section $section)
    {
        return $user->level >= User::LEVEL_8;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Section $section
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Section $section)
    {
        return $user->level >= User::LEVEL_8;
    }
}
