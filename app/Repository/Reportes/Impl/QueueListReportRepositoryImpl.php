<?php

namespace App\Repository\Reportes\Impl;

use App\Models\QueueList;
use App\Repository\Reportes\QueueListReportRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class QueueListReportRepositoryImpl implements QueueListReportRepository
{
    public function listarQueueLis($fechaIni, $fechaFin): LengthAwarePaginator
    {
        return QueueList::with('user','ticket','desk','customer','processing_events','query_type_customer')
            ->whereDate('created_at','>=',$fechaIni)
            ->whereDate('created_at','<=',$fechaFin)
            ->orderBy('created_at','asc')
            ->paginate(10);
    }

    public function clientAdmin($fechaIni, $fechaFin): array
    {

        $totalTickets = DB::table('queue_lists')
            ->select(DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', $fechaIni)
            ->whereDate('created_at', '<=', $fechaFin)
            ->get();

        $totalTotalPorAtender = DB::table('queue_lists')
            ->select(DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', $fechaIni)
            ->whereDate('created_at', '<=', $fechaFin)
            ->where('processing', 1)
            ->get();
        $totalTotalAtendidos = DB::table('queue_lists')
            ->select(DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', $fechaIni)
            ->whereDate('created_at', '<=', $fechaFin)
            ->where('processing', 6)
            ->get();
        $totalClientesAusentes = DB::table('queue_lists')
            ->select(DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', $fechaIni)
            ->whereDate('created_at', '<=', $fechaFin)
            ->where('processing', 5)
            ->get();

        $totalSiendoAtendidos = DB::table('queue_lists')
            ->select(DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', $fechaIni)
            ->whereDate('created_at', '<=', $fechaFin)
            ->where('processing', 3)
            ->get();

        $totalSiendoLlamados = DB::table('queue_lists')
            ->select(DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', $fechaIni)
            ->whereDate('created_at', '<=', $fechaFin)
            ->where('processing', 2)
            ->get();
        $totalLiberados = DB::table('queue_lists')
            ->select(DB::raw('count(*) as total'))
            ->whereDate('created_at', '>=', $fechaIni)
            ->whereDate('created_at', '<=', $fechaFin)
            ->where('processing', 2)
            ->get();

        return [
            'total_registros' => optional($totalTickets->first())->total,
            'total_por_atender' => optional($totalTotalPorAtender->first())->total,
            'total_atendidos' => optional($totalTotalAtendidos->first())->total,
            'total_siendo_atendidos' => optional($totalSiendoAtendidos->first())->total,
            'total_ausentes' => optional($totalClientesAusentes->first())->total,
            'total_siendo_llamados' => optional($totalSiendoLlamados->first())->total,
            'total_liberados' => optional($totalLiberados->first())->total
        ];
    }

    public function listarQueueLisNoTPage($fechaIni, $fechaFin): Collection
    {
        return QueueList::with('user','ticket','desk','customer','processing_events','query_type_customer')
            ->whereDate('created_at','>=',$fechaIni)
            ->whereDate('created_at','<=',$fechaFin)
            ->orderBy('created_at','asc')
            ->get();
    }
}
