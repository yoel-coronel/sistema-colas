<?php

namespace App\Http\Controllers\Mantenimientos;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = Carousel::orderBy('id')->paginate(12);
        return response()->json($data);
    }
    public function getCarousels(){
        $data = Carousel::where('is_active',1)->orderBy('id')->get();
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
            $data =$request->all();

            if($request->hasFile('path')){
                $file = $request->file('path');
                $nombrearchivo = 'file'.time().".".$file->getClientOriginalExtension();
                $ruta = "/videos/".$nombrearchivo;
                \Storage::disk('archivos')->put($ruta, \File::get($file));
                $data['path'] = $ruta;
            }
            $carousel = Carousel::create($data);
            return $this->successResponseCreate($this->show($carousel->id),trans('message.success'));

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
        return Carousel::find($id);
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

        $data =$request->all();
        $carousel = Carousel::find($id);
        if ($request->path!="null"){
            if($request->hasFile('path')){
                if(\Storage::disk('archivos')->exists($carousel->path)){
                    \Storage::disk('archivos')->delete($carousel->path);
                }
                $file = $request->file('path');
                $nombrearchivo = 'file'.time().".".$file->getClientOriginalExtension();
                $ruta = "/videos/".$nombrearchivo;
                \Storage::disk('archivos')->put($ruta, \File::get($file));
                $data['path'] = $ruta;
            }
        }else{
            $data['path'] = $carousel->path;
        }
        $carousel->update($data);
        return $this->successResponseCreate($this->show($carousel->id),trans('message.success'));
    }

    public function getFileContent($id){
        $content = Carousel::find($id);
        return \Storage::disk('archivos')->get($content->path);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Carousel::destroy($id);
    }
}
