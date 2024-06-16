<?php

namespace App\Events;

use App\Models\Passenger;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SaveLocation implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public Passenger $passenger
    )
    {
    }

    public function broadcastOn(): array
    {
        return [
            new Channel('save-location'),
        ];
    }
}

