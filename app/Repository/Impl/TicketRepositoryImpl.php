<?php
namespace  App\Repository\Impl;

use App\Events\CallQueueListEvent;
use App\Jobs\ProcesaSearchDniReniec;
use App\Models\Customer;
use App\Models\Desk;
use App\Models\ProcessingEvent;
use App\Models\QueueList;
use App\Models\Ticket;
use App\Impresiones\PrinterService;
use App\Models\User;
use App\Repository\SearchOracleRepository;
use App\Repository\SequenceRepository;
use App\Repository\TicketRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class TicketRepositoryImpl implements TicketRepository
{
    private $sequenceRepository = null;
    private $searchOracleRepository = null;
    public function __construct(SequenceRepository $sequenceRepository,SearchOracleRepository $searchOracleRepository)
    {
        $this->sequenceRepository = $sequenceRepository;
        $this->searchOracleRepository =$searchOracleRepository;
    }
    public function getAllLineTickets(int $id): Collection
    {
       return Ticket::where('is_active','<>',0)->where('level',$id)->get();
    }
    public function getAllTickes(): Collection
    {
        $data = new Collection();  $guests = null;
        $guests = QueueList::with('user','ticket','desk','customer','processing_events','query_type_customer') ->whereDate('created_at', now() )
                    ->whereIn('processing',[1,2])
                        ->orderBy('processing','desc')
                        ->orderBy('sequence','asc')
                        ->get();
        //$guests = $guests->groupBy('ticket_id');

        $data->put('guests',$guests);
        return $data;
    }
    public function getAllTocketsSerAtendidos(array $tickets): Collection
    {
        $data = new Collection();
        $guests = QueueList::with('user','ticket','desk','customer','processing_events','query_type_customer')
                            ->whereDate('created_at', now() )
                            ->whereIn('processing',[1])//[1,2,3]
                            ->whereIn('ticket_id',$tickets)
                            ->orderBy('sequence','asc')
                            ->get();
        $data->put('guests',$guests);
        return $data;
    }
    public function getMisTicketsSerAtendidos(int $user_id): Collection
    {
        $data = new Collection();
        $mis_atenciones = QueueList::with('user','ticket','desk','customer','processing_events','query_type_customer')->whereDate('created_at', now() )
            ->whereIn('processing',[1,2,3,4,5])
            ->where('user_id',$user_id)->orderByDesc('updated_at')
            ->orderBy('sequence','asc')
            ->get();
        $data->put('mis_atenciones',$mis_atenciones);
        return $data;
    }
    public function toPrint(QueueList $queueList,Ticket $ticket): void
    {
        $imprimir = new PrinterService();
        $imprimir->toPrint($queueList,$ticket);
    }
    public function generaTicket(Ticket $ticket,string $nro)
    {
        try {

            $customer = $this->searchCustomerForCipOrDni($nro);

            if (!$customer){
                $customer = $this->searchOracleRepository->findPersonaNroDNIOrCIP($nro);
                if($customer){
                    $cus = [
                            'id'=>null,
                            'full_surname'=>$customer->apel_pate_per.' '.$customer->apel_mate_per,
                            'full_name'=>$customer->nomb_pers_per,
                            'guest_fachada' => explode(" ",$customer->nomb_pers_per)[0]." ".$customer->apel_pate_per?$customer->apel_pate_per:'',
                            'iden_pers_per'=>$customer->iden_pers_per,
                            'document_number'=>$customer->nume_iden_per,
                            'cip_number'=>$customer->codi_ccip_soc
                        ];
                    $customer = $this->saveCustomer($cus);

                }else{
                    $customer = null;
                }

            }
            if($customer){
                $guest_fachada =  explode(" ",$customer->full_name)[0] ." ". explode(" ",$customer->full_surname)[0];
                $queueList = QueueList::create([
                                    'ticket_id'=>$ticket->id,
                                    'customer_id' => $customer->id,
                                    'guest_name' => $guest_fachada,
                                    'guest_code' => $customer->iden_pers_per,
                                    'sequence' => $this->sequenceRepository->nextSequence($ticket)]);
            }else{
                $queueList = QueueList::create([
                    'ticket_id'=>$ticket->id,
                    'sequence' => $this->sequenceRepository->nextSequence($ticket)]);
            }
            if(config('app.printer')){
                $this->toPrint($queueList,$ticket);
            }

            if (config('app.reniec_enable')){
                if(!$queueList->customer_id){
                    ProcesaSearchDniReniec::dispatch($queueList->id,$nro);
                }
            }

        }catch (\Exception $e){
            \Log::error("Error: ".$e->getMessage());
        }
    }
    public function findTicket(int $id): Model
    {
        return Ticket::find($id);
    }
    public function procesaLlamada(int $id): void
    {
            $queueList = $this->findQueueList($id);
            $user = User::find(Auth::id());
            $queueList->desk_id = $user->desk->id;
            $queueList->user_id = $user->id;
            $queueList->processing = 2;
            $queueList->read_at = now();
            $queueList->save();
            $data = $this->findFullRelationQueueList($id)->toArray();
            event(new CallQueueListEvent($data));

    }
    public function updateQueueList(array $data, int $id){
        $queueList = $this->findQueueList($id);
        $queueList->update($data);
        $queueList->save();
    }
    public function procesaStart(int $id): void
    {
        $queueList = $this->findQueueList($id);
        $queueList->processing = 3;
        $queueList->start_dated = now();
        $queueList->save();
    }
    public function procesaClienteAusente(int $id): void
    {
        $queueList = $this->findQueueList($id);
        $queueList->processing = 5;
        $queueList->save();
    }
    public function procesaSaveAll(array $data, $id): void
    {
        unset($data['customer']['is_active']);
        if($data['customer']['id']!==null){
            $customer =  $this->updateCustomer($data['customer'],$data['customer']['id']);
        }else{
            $customer = $this->firstCustomerNroAndDNIAndCIP($data['customer']['document_number'],$data['customer']['cip_number']);
            if($customer){
                $this->updateCustomer($data['customer'],$customer->id);
            }else{
                $customer = $this->saveCustomer($data['customer']);
            }
        }
        $queueList = QueueList::find($data['id']);
        $queueList->customer_id = $customer->id;
        $queueList->end_dated = now();
        $queueList->processing = 6;
        $queueList->description = $data['description'];
        $queueList->query_type_customer_id =  $data['query_type_customer_id'];
        $queueList->guest_name = $customer->guest_fachada;
        $queueList->guest_code = $customer->iden_pers_per;
        $queueList->save();

    }
    public function firstCustomerNroAndDNIAndCIP(string $dni,string $cip){
        return Customer::where('document_number',$dni)
            ->where('cip_number',$cip)->first();
    }
    public function searchCustomerForCipOrDni(string $rno){
        return Customer::where('document_number',$rno)
            ->orWhere('cip_number',$rno)->first();
    }
    public function saveCustomer(array $data):Model{
        $nuevoCustomer =  Customer::create($data);
        return $this->findCustomer($nuevoCustomer->id);
    }
    public function updateCustomer(array $data,$id):Model{
        $updateCustomer =  Customer::find($id);
        $updateCustomer->update($data);
        return $this->findCustomer($updateCustomer->id);
    }
    public function findCustomer($id):Model{
        return Customer::find($id);
    }
    public function findQueueList(int $id): Model
    {
        return QueueList::find($id);
    }
    public function findFullRelationQueueList(int $id): Model
    {
        return QueueList::with('user','ticket','desk','customer','processing_events')
            ->where('id',$id)->first();
    }
    public function procesaEvent(QueueList $data): void
    {
        $queueList = $this->findQueueList($data->id);
        $processing = ProcessingEvent::where('queue_list_id',$queueList->id)->where('processing',$queueList->processing)->first();
        if($processing){
            $processing->user_id = $queueList->user_id;
            $processing->desk_id = $queueList->desk_id;
            $processing->queue_list_id =$queueList->id;
            $processing->processing = $queueList->processing;
            $processing->save();
        }else{
            $processingNew = new ProcessingEvent();
            $processingNew->user_id = $queueList->user_id;
            $processingNew->desk_id = $queueList->desk_id;
            $processingNew->queue_list_id =$queueList->id;
            $processingNew->processing = $queueList->processing;
            $processingNew->save();
        }
    }
    public function getDesks(): Collection
    {
       return Desk::where('is_active',1)->get();
    }
}
