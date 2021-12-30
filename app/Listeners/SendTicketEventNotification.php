<?php

namespace App\Listeners;

use App\Events\TicketEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendTicketEventNotification
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
     * @param  TicketEvent  $event
     * @return void
     */
    public function handle(TicketEvent $event)
    {
        //hacer algo
    }
}
