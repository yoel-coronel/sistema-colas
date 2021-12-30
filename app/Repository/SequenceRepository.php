<?php

namespace  App\Repository;

use App\Models\Ticket;

interface SequenceRepository
{
    public function nextSequence(Ticket $ticket):int;
}
