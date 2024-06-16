<?php

namespace App\Jobs;

use App\Models\Passenger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveLocation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        public $latitude,
        public $longitude,
        public $driver,
        public $user_id,
        public $destination
    )
    {
    }

    public function handle(): void
    {
        \Log::info('SaveLocation job started');
        $passenger = new Passenger();
        $passenger->latitude = $this->latitude;
        $passenger->longitude = $this->longitude;
        $passenger->driver_id = $this->driver;
        $passenger->user_id = $this->user_id;
        $passenger->destination = $this->destination;
        $passenger->save();

//        $passenger = Passenger::create([
//            'latitude' => $this->latitude,
//            'longitude' => $this->longitude,
//            'driver_id' => $this->driver,
//            'user_id' => $this->user_id,
//            'destination' => 2,
//        ]);


        //fire sve location event
        \App\Events\SaveLocation::dispatch($passenger);

    }
}
