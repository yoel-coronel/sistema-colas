<?php

namespace App\Providers;


use App\Repository\AuthRepository;
use App\Repository\ConsultaExternaRepository;
use App\Repository\Impl\AuthRepositoryImpl;
use App\Repository\Impl\ConsultaExternaRepositoryImpl;
use App\Repository\Impl\SearchOracleRepositoryImpl;
use App\Repository\Impl\SequenceRepositoryImpl;
use App\Repository\Reportes\Impl\QueueListReportRepositoryImpl;
use App\Repository\Reportes\QueueListReportRepository;
use App\Repository\SearchOracleRepository;
use App\Repository\SequenceRepository;
use App\Repository\TicketRepository;
use App\Repository\Impl\TicketRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class UploadRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $toBinds = [
            // all repository map
            TicketRepository::class => TicketRepositoryImpl::class,
            SequenceRepository::class=>SequenceRepositoryImpl::class,
            AuthRepository::class => AuthRepositoryImpl::class,
            SearchOracleRepository::class => SearchOracleRepositoryImpl::class,
            ConsultaExternaRepository::class => ConsultaExternaRepositoryImpl::class,
            QueueListReportRepository::class => QueueListReportRepositoryImpl::class,
        ];
        foreach ($toBinds as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {


    }
}
