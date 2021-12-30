<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repository\AuthRepository;
use App\Repository\TicketRepository;
use Illuminate\Http\Request;

class getResourceController extends Controller
{
    private $authRepository = null;
    private $ticketRepository = null;
    public function __construct(AuthRepository $authRepository, TicketRepository $ticketRepository)
    {
        $this->authRepository = $authRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function getInfomacionUser(int $id): \Illuminate\Http\JsonResponse
    {
        $user = User::find($id);
        return $this->showAll($this->authRepository->findTicketUser($user));
    }
    public function getTicketsPorAtender(int $id): \Illuminate\Http\JsonResponse
    {
        $tickets = User::find($id)->tickets->pluck('id')->toArray();
        return response()->json($this->ticketRepository->getAllTocketsSerAtendidos($tickets));
    }
    public function misAtenciones(int $id): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->ticketRepository->getMisTicketsSerAtendidos($id));
    }
    public function getAlllDesks(Request $request){
        return response()->json($this->ticketRepository->getDesks());
    }

    public function getOneFullRelationQueueList(int $id): \Illuminate\Http\JsonResponse
    {
        return response()->json($this->ticketRepository->findFullRelationQueueList($id));
    }
}
