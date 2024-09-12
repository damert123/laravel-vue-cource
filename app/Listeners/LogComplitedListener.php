<?php

namespace App\Listeners;

use App\Events\LogComplitedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogComplitedListener
{


    public function handle(LogComplitedEvent $event): void
    {
       Log::info("LOG COMPLITED FOR EVENT {$event->event}, MODEL: " . get_class($event->model));
    }
}
