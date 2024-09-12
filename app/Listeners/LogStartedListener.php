<?php

namespace App\Listeners;

use App\Events\LogStartedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class LogStartedListener
{


    public function handle(LogStartedEvent $event): void
    {
        Log::info("LOG STARTED FOR EVENT: {$event->event}, Model: " . get_class($event->model));
    }
}
