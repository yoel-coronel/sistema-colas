<?php

namespace App\Repository\Reportes;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface QueueListReportRepository
{
    public function listarQueueLis($fechaIni,$fechaFin):LengthAwarePaginator;
    public function listarQueueLisNoTPage($fechaIni,$fechaFin):Collection;
    public function clientAdmin($fechaIni, $fechaFin):array;

}
