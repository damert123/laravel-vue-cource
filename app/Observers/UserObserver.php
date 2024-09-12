<?php

namespace App\Observers;

use App\Events\UserRegistered;
use App\Models\User;

class UserObserver
{
    public function created(User $user)
    {
//        event(new UserRegistered($user));

        $user->profile()->create([
            'birthed_at' => fake()->dateTimeBetween('-50 years', '-18 years')->format('d-m-Y'),
            'role' => fake()->word(),
            'status' => fake()->numberBetween(1, 3),
            'city' => fake()->city(),
            'about' => fake()->text(50),
            'avatar_path' => fake()->imageUrl(),
            'login' => fake()->unique()->userName(),
        ]);

    }

}
