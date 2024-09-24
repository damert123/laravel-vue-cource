<?php

namespace App\Services;

use App\Models\User;

class UserService
{



    public static function create(array $data): User
    {
        $user = User::create([
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'name' => $data['name'],
        ]);

        $user->profile()->create([
            'login' => $data['login'],
        ]);

        if (isset($data['role_id'])) {
            $user->roles()->attach($data['role_id']);
        }



        return $user;
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
