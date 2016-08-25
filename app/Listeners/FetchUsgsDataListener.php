<?php

namespace App\Listeners;

use App\Events\FetchUsgsDataEvent;
use App\Jobs\FetchUsgsDataJob;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FetchUsgsDataListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  FetchUsgsDataEvent  $event
     * @return void
     */
    public function handle(FetchUsgsDataEvent $event)
    {
        $job = new FetchUsgsDataJob();
        dispatch($job);
    }
}
