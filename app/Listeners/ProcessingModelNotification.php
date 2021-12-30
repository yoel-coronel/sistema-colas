<?php

namespace App\Listeners;

use App\Events\ProcessingModelEvent;
use App\Repository\TicketRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ProcessingModelNotification
{
    protected $ticketRepository = null;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;
    }

    /**
     * Handle the event.
     *
     * @param  ProcessingModelEvent  $event
     * @return void
     */
    public function handle(ProcessingModelEvent $event)
    {
        $this->ticketRepository->procesaEvent($event->data);
    }
}
