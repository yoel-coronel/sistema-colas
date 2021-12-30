<?php

namespace App\Repository\Impl;

use App\Repository\ConsultaExternaRepository;

class ConsultaExternaRepositoryImpl implements ConsultaExternaRepository
{
    public function consultaReniec(string $dni)
    {
        $url = config('app.url_consulta_reniec');
        $res = (array)json_decode(file_get_contents("{$url}/api/reniec/{$dni}"));
        if(intval($res['code']) === 0){
            $persona = (array)$res['persona'];
            return  ['id'=>null,'full_surname'=>$persona['paterno'].' '.$persona['materno'], 'full_name'=>$persona['nombres'],'document_number'=>$dni,];
        }else{
            return null;
        }
    }
}
