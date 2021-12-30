<?php

namespace App\Http\Controllers\Reportes;

use App\Http\Controllers\Controller;
use App\Http\Resources\QueueListCollection;
use App\Repository\Reportes\QueueListReportRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

class QueueListReportController extends Controller
{
    private $queueListReportRepository;
    public function __construct(QueueListReportRepository $queueListReportRepository)
    {
        $this->queueListReportRepository = $queueListReportRepository;
    }

    public function getQueueList(Request $request){

        $fecha_ini =  $request->fecha1?Carbon::parse($request->fecha1)->format('Y/m/d'):now()->format('Y/m/d');
        $fecha_fin =  $request->fecha2?Carbon::parse($request->fecha2)->format('Y/m/d'):now()->format('Y/m/d');

        $search_val =  boolval($request->search_val);
        if($search_val){
            $data = $this->queueListReportRepository->listarQueueLisNoTPage($fecha_ini,$fecha_fin);
        }else{
            $data = $this->queueListReportRepository->listarQueueLis($fecha_ini,$fecha_fin);
        }
        return QueueListCollection::make($data);

    }
}
