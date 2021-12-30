<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class MaeSocio extends Eloquent
{
    protected $table = 'SIFO.MAE_SOCIO';

    protected $connection = 'oracle';

    public function findSocio($cip, $codofi) {
        return $this->where('codi_ccip_soc', $cip)
            ->where('codi_cdfi_soc', $codofi);
    }
protected $primaryKey= false;
}
