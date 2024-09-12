<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogComplitedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $model;
    public $event;

    public function __construct($model, $event)
    {
        $this->model = $model;
        $this->event = $event;
    }

}
