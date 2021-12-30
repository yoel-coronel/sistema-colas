<?php

namespace App\Http\Controllers\Search;

use App\Http\Controllers\Controller;
use App\Repository\SearchOracleRepository;
use Illuminate\Http\Request;

class SearchOracleController extends Controller
{
    private $searchOracleRepository = null;

    public function __construct(SearchOracleRepository $searchOracleRepository)
    {
        $this->searchOracleRepository = $searchOracleRepository;
    }
    public function findPersonaNroDNIOrCIP(string $nro){
       return response()->json($this->searchOracleRepository->findPersonaNroDNIOrCIP($nro));
    }
}
