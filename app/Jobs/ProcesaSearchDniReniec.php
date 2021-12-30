<?php

namespace App\Jobs;

use App\Events\TicketEvent;
use App\Repository\ConsultaExternaRepository;
use App\Repository\TicketRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcesaSearchDniReniec implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $nro;
    protected $queueList_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $queueList_id, string $nro)
    {
        $this->queueList_id = $queueList_id;
        $this->nro = $nro;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(TicketRepository $ticketRepository,ConsultaExternaRepository $consultaExternaRepository)
    {
      $data =  $consultaExternaRepository->consultaReniec($this->nro);
      if ($data){
          $data['guest_fachada'] = explode(" ",$data['full_name'])[0]." ". explode(" ",$data['full_surname'])[0];
          $res =  $ticketRepository->saveCustomer($data);
           $queueList = [
               'customer_id' => $res->id,
               'guest_name' => $res->guest_fachada,
           ];
           $ticketRepository->updateQueueList($queueList,$this->queueList_id);
          $data = $ticketRepository->findFullRelationQueueList($this->queueList_id);
          event(new TicketEvent($data->toArray()));
      }
    }
}
