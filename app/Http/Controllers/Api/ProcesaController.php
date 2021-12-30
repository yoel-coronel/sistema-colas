<?php

namespace App\Http\Controllers\Api;

use App\Events\TicketEvent;
use App\Http\Controllers\Controller;
use App\Repository\TicketRepository;
use Illuminate\Http\Request;

class ProcesaController extends Controller
{
    private $ticketRepository = null;

    public function __construct(TicketRepository $ticketRepository)
    {
        $this->ticketRepository = $ticketRepository;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Support\Collection
     */
    public function index()
    {
        return $this->ticketRepository->getAllTickes();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $data = $request->data;
            $nro = $request->nro;
            $ticket = $this->ticketRepository->findTicket($data['id']);
            $this->ticketRepository->generaTicket($ticket,$nro);
            event(new TicketEvent($request->all()));
            return $this->successResponseStatus(trans('message.success'),0);

        }catch (\Exception $exception){

            return $this->errorResponse($exception->getMessage(),1);

         }
    }
    public function procesaCall(Request $request,$id): \Illuminate\Database\Eloquent\Model
    {
        $this->ticketRepository->procesaLlamada($id);
        $data = $this->ticketRepository->findFullRelationQueueList($id);
        event(new TicketEvent($data->toArray()));
        return $data;
    }
    public function procesaStart(Request $request,$id): \Illuminate\Database\Eloquent\Model
    {
        $this->ticketRepository->procesaStart($id);
        $data = $this->ticketRepository->findFullRelationQueueList($id);
        event(new TicketEvent($data->toArray()));
        return $data;
    }
    public function procesaClienteAusente(Request $request,$id): \Illuminate\Database\Eloquent\Model
    {
        $this->ticketRepository->procesaClienteAusente($id);
        $data = $this->ticketRepository->findFullRelationQueueList($id);
        event(new TicketEvent($data->toArray()));
        return $data;
    }
    public function procesaAtencionAll(Request $request,$id): \Illuminate\Http\JsonResponse
    {
        $data = $request->all();
        $this->ticketRepository->procesaSaveAll($data, $id);
        $data = $this->ticketRepository->findFullRelationQueueList($id);
        event(new TicketEvent($data->toArray()));
        return $this->successResponseStatus(trans('message.success'),0);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
