<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MaePersona extends Eloquent
{
    protected $table = 'SIFO.MAE_PERSONA';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_pers_per';
}
