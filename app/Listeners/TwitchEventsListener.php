<?php

namespace App\Listeners;

use App\Events\TwitchEvents;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TwitchEventsListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TwitchEvents  $event
     * @return mixed
     */
    public function handle(TwitchEvents $event)
    {
        // here we have events data of our favourite streamer
//        $eventsData = $event->eventsData;

    }
}
