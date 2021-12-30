<?php

namespace App\Events;

use App\Models\QueueList;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProcessingModelEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $data = null;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(QueueList $data)
    {
        $this->data = $data;
    }

}
