<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;




/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::apiResource('tickets',\App\Http\Controllers\TicketController::class);
Route::get('carousels',[\App\Http\Controllers\Mantenimientos\CarouselController::class,'getCarousels']);

Route::post('procesa',[\App\Http\Controllers\Api\ProcesaController::class,'store']);
Route::get('procesa',[\App\Http\Controllers\Api\ProcesaController::class,'index']);


