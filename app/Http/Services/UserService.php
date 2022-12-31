<?php

namespace App\Http\Services;

use App\Events\UserRegistered;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Store a user
     *
     * @param array $validated the validated user data
     * @return User
     */
    public function store(array $validated)
    {
        $validated["password"] = Hash::make($validated["password"]);

        /** User $user */
        $user = new User();
        $user->first_name = $validated["first_name"];
        $user->last_name = $validated["last_name"];
        $user->username = $validated["username"];
        $user->gender = $validated["gender"];
        $user->email = $validated["email"];
        $user->password = $validated["password"];
        $user->confirmation_token = Str::random(20);
        $user->save();

        event(new UserRegistered($user));

        return $user;
    }

    /**
     * Update a user 
     * 
     * @param array $validated the validated user data
     * @param User $user
     * @return User
     */
    public function update(array $validated, User $user)
    {
        $user->first_name = $validated["first_name"];
        $user->last_name = $validated["last_name"];
        $user->username = $validated["username"];
        $user->gender = $validated["gender"];
        $user->role_id = $validated["role_id"] ?? $user->role_id;

        if ($pass = $validated["password"] ?? null)
            $user->password = Hash::make($pass);

        $user->save();

        return $user;
    }
}
