<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repository\Reportes\QueueListReportRepository;
use Illuminate\Http\Request;

class DashboardAdminController extends Controller
{
    private $queueListReportRepository;
    public function __construct(QueueListReportRepository $queueListReportRepository)
    {
        $this->queueListReportRepository = $queueListReportRepository;
    }

    public function getDataGeneral(){
        return $this->queueListReportRepository->clientAdmin(now()->format('Y/m/d'),now()->format('Y/m/d'));
    }
}
