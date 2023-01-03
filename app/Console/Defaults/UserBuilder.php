<?php

namespace App\Console\Defaults;

use App\Models\Admin\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserBuilder
{
    /**
     * Create an master user
     *
     * @param string $email
     * @param string $password
     * @return User
     */
    public function master(string $email, string $password)
    {
        if ($user = User::where("email", $email)->first()) {
            echo "master user exists\n";
            return $user;
        }

        $user = User::create([
            "first_name" => "Master",
            "last_name" => "Last Name",
            "username" => "Master",
            "email" => $email,
            "password" => Hash::make($password),
            "is_superadmin" => true,
            "email_verified_at" => now(),
        ]);

        if (!$user) {
            echo "fail on create the master user\n";
        } else {
            echo "the master user has been created\n";
        }

        return $user;
    }

    /**
     * Create an visitor user
     *
     * @param Role $role
     * @return User
     */
    public function visitor(Role $role)
    {
        $mail = "visitor@visitor.mail";
        if ($user = User::where("email", $mail)->first()) {
            echo "visitor user exists\n";
            return $user;
        }

        $user = User::create([
            "first_name" => "Visitor",
            "last_name" => "Last Name",
            "username" => "visitor",
            "email" => $mail,
            "password" => Hash::make("visitorpassword"),
            "email_verified_at" => now(),
            "role_id" => $role->id,
        ]);

        if (!$user) {
            echo "fail on create the visitor user\n";
        } else {
            echo "the visitor user has been created\n";
        }

        return $user;
    }
}
