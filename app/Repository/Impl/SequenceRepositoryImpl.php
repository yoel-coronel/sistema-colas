<?php

namespace App\Repository\Impl;

use App\Models\Sequence;
use App\Models\Ticket;

class SequenceRepositoryImpl implements \App\Repository\SequenceRepository
{

    public function nextSequence(Ticket $ticket): int
    {
        $secuencia = Sequence::whereDate('day_sequence',now())->where('ticket_id',$ticket->id)->first();
        $sec = 0;
        if($secuencia){
            $sec = $secuencia->sequence + 1;
            $secuencia->sequence = $sec;
            $secuencia->save();
        }else{
            $sec = 1;
            Sequence::create(['sequence'=>$sec,'day_sequence'=>now(),'ticket_id'=>$ticket->id]);

        }
        return $sec;
    }
}
