<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\QueryTypeCustomer;
use Illuminate\Http\Request;

class QueryTypeCustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = QueryTypeCustomer::orderBy('id')->paginate(12);
        return response()->json($data);
    }
    public function getQueryTypeCustomers(){
        $data = QueryTypeCustomer::where('is_active',1)->orderBy('id')->get();
        return response()->json($data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            $query = QueryTypeCustomer::create($request->all());
            return $this->successResponseCreate($this->show($query->id),trans('message.success'));

        }catch (\Exception $exception){
            return $this->errorResponse($exception->getMessage(),1);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return QueryTypeCustomer::find($id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $query = QueryTypeCustomer::find($id);
        $query->update($request->all());
        return $this->successResponseCreate($this->show($query->id),trans('message.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        QueryTypeCustomer::destroy($id);
    }
}
