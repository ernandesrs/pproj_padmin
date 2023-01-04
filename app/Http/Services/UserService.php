<?php

namespace App\Http\Services;

use App\Events\UserRegistered;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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

        if ($role_id = $validated["role_id"] ?? null)
            $user->role_id = $role_id;

        if ($photo = $validated["photo"] ?? null)
            $user = $this->storePhoto($photo, $user);

        if ($pass = $validated["password"] ?? null)
            $user->password = Hash::make($pass);

        $user->save();

        return $user;
    }

    /**
     * Store user photo
     *
     * @param UploadedFile $photo
     * @param User $user
     * @return User
     */
    public function storePhoto(?UploadedFile $photo, User $user)
    {
        if (!$photo) return $user;

        $user = $this->deletePhoto($user);

        $user->photo = $photo->store("avatars", "public") ?? null;
        $user->save();

        return $user;
    }

    /**
     * Delete user photo
     *
     * @param User $user
     * @return User
     */
    public function deletePhoto(User $user)
    {
        if ($user->photo)
            Storage::delete("public/{$user->photo}");

        $user->photo = null;
        $user->save();

        return $user;
    }
}
