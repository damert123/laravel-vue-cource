<?php

namespace App\Providers;

use App\Events\LogComplitedEvent;
use App\Events\LogStartedEvent;
use App\Events\UserRegistered;
use App\Listeners\CreateProfile;
use App\Listeners\LogComplitedListener;
use App\Listeners\LogStartedListener;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use App\Observers\PostObserver;
use App\Observers\ProfileObserver;
use App\Observers\UserObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//
        User::observe(UserObserver::class);
//        Post::observe(PostObserver::class);
//        Profile::observe(ProfileObserver::class);

        Model::unguard();



        Event::listen(
            LogComplitedEvent::class,
            LogComplitedListener::class
        );

        Event::listen(
            LogStartedEvent::class,
            LogStartedListener::class
        );




    }
}
