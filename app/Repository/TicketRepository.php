<?php
namespace  App\Repository;

use App\Models\QueueList;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface TicketRepository
{
    public function getAllLineTickets(int $id):Collection;
    public function getAllTickes():Collection;
    public function getAllTocketsSerAtendidos(array $tickets):Collection;
    public function getMisTicketsSerAtendidos(int $user_id):Collection;
    public function findTicket(int $id):Model;
    public function findQueueList(int $id):Model;
    public function findFullRelationQueueList(int $id):Model;
    public function generaTicket(Ticket $ticket,string $nro);
    public function procesaLlamada(int $id):void;
    public function updateQueueList(array $data, int $id);
    public function procesaStart(int $id):void;
    public function procesaClienteAusente(int $id):void;
    public function procesaSaveAll(array $data,$id):void;
    public function procesaEvent(QueueList $data):void;
    public function saveCustomer(array $data):Model;
    public function firstCustomerNroAndDNIAndCIP(string $dni,string $cip);
    public function searchCustomerForCipOrDni(string $nro);
    public function updateCustomer(array $data,$ida):Model;
    public function findCustomer($ida):Model;
    public function toPrint(QueueList $queueList,Ticket $ticket):void;
    public function getDesks():Collection;

}
