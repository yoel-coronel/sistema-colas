<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 *
 */
trait ApiResponser
{

	private function successResponse($data,$code)
	{
		return response()->json($data,$code);
	}
	protected function successResponseStatus($message,$status=0,$code=200){
		return response()->json(['success'=>$message,'status'=>$status,'code'=>$code],$code);
	}

	protected function errorResponse($message,$status=1,$code=500)
	{
		return response()->json(['error'=>$message,'status'=>$status,'code'=>$code],$code);
	}
	protected function showAll(Collection $collection, $status = 0,$code = 200)
	{
		return $this->successResponse(['data'=>$collection,'status'=>$status,'code'=>$code], $code);
	}
	protected function showOne(Model $instance, $status = 0, $code=200)
	{
		return $this->successResponse(['data'=>$instance,'status'=>$status,'code'=>$code], $code);
	}
    protected function successResponseCreate($data,$message="",$code=200)
    {
        return response()->json(['data'=>$data,'message'=>$message,'code'=>$code],$code);
    }

}
