<?php

namespace App\Jobs;

use App\Events\ConfirmRoute;
use App\Models\Passenger;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeletePassenger implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Passenger $passenger
    )
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->passenger->delete();
        ConfirmRoute::dispatch();
    }
}
