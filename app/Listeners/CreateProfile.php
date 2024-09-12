<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Models\Profile;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CreateProfile
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle($event): void
    {

        Profile::create([
            'birthed_at' => fake()->dateTimeBetween('-50 years', '-18 years')->format('d-m-Y'),
            'role' => fake()->word(),
            'status' => fake()->numberBetween(1, 3),
            'city' => fake()->city(),
            'about' => fake()->text(50),
            'avatar_path' => fake()->imageUrl(),
            'login' => fake()->unique()->userName(),


            'user_id' => $event->user->id,
        ]);
    }
}
