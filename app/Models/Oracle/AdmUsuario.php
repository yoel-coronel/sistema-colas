<?php

namespace App\Models\Oracle;

use Yajra\Oci8\Eloquent\OracleEloquent as Eloquent;

class AdmUsuario extends Eloquent
{
    protected $table = 'SIFO.ADM_USUARIO';

    protected $connection = 'oracle';

    protected $primaryKey = 'iden_pers_per';

    public function persona(){
        return $this->belongsTo(MaePersona::class,'iden_pers_per','iden_pers_per');
    }
}
