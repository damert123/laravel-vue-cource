<?php

namespace App\Services;

use App\Models\User;

class UserService
{



    public static function create(array $data): User
    {
        return User::create($data);
    }

    public static function update(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    public static function delete(User $user): void
    {
        $user->delete();

    }



}
