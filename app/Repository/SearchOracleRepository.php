<?php

namespace App\Repository;

interface SearchOracleRepository
{

    public function findPersonaNroDNIOrCIP(string $nro);

}
