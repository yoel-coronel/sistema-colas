<?php

namespace App\Repository\Impl;

use App\Models\Oracle\MaePersona;
use App\Repository\SearchOracleRepository;

class SearchOracleRepositoryImpl implements SearchOracleRepository
{

    public function findPersonaNroDNIOrCIP(string $nro)
    {
       return MaePersona::select('SIFO.MAE_PERSONA.IDEN_PERS_PER','SIFO.MAE_PERSONA.APEL_PATE_PER','SIFO.MAE_PERSONA.APEL_MATE_PER','SIFO.MAE_PERSONA.NOMB_PERS_PER','SIFO.MAE_PERSONA.NUME_IDEN_PER','SIFO.MAE_SOCIO.CODI_CCIP_SOC')
                                ->join('SIFO.MAE_SOCIO','SIFO.MAE_PERSONA.IDEN_PERS_PER','=','SIFO.MAE_SOCIO.IDEN_PERS_PER')
                                ->where('SIFO.MAE_SOCIO.CODI_CCIP_SOC','=',$nro)
                                ->orWhere('SIFO.MAE_PERSONA.NUME_IDEN_PER','=',$nro)
                                ->where('SIFO.MAE_PERSONA.FLAG_ESTA_PER','<>',0)
                                ->where('SIFO.MAE_PERSONA.HABI_MAES_PER','<>',0)->first();

    }
}
