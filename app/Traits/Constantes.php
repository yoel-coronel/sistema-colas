<?php

namespace App\Traits;

use Illuminate\Support\Collection;

trait Constantes
{

    protected function processing_events_name(){
        return collect([
            ['id'=>1,'name'=>'CREA TICKET'],
            ['id'=>2,'name'=>'LLAMANDO AL CLIENTE'],
            ['id'=>3,'name'=>'ATENDIENDO AL CLIENTE'],
            ['id'=>4,'name'=>'TICKET LIBERADO'],
            ['id'=>5,'name'=>'NO SE PRESENTÓ'],
            ['id'=>6,'name'=>'TICKET FINALIZADO']
        ]);
    }
    public function findNameProcessing($id){
        return $this->processing_events_name()->where('id',$id)->first()['name'];
    }

}
