<?php

namespace App\Http\Resources;

use App\Traits\Constantes;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class QueueListResource extends JsonResource
{
    use Constantes;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
                'id'=>$this->resource->id,
                'ticket_name'=> $this->resource->ticket?$this->resource->ticket->name:null,
                'desk_name' => $this->resource->desk?$this->resource->desk->name:null,
                'customer_cip' => $this->resource->customer?$this->resource->customer->cip_number:null,
                'customer_dni' => $this->resource->customer?$this->resource->customer->document_number:null,
                'customer_tel' => $this->resource->customer?$this->resource->customer->telephone:null,
                'user_full_name' =>$this->resource->user?$this->resource->user->full_name:null,
                'customer_full_name' => $this->resource->customer?$this->resource->customer->full_name." ".$this->resource->customer->full_surname:null,
                'query_type_customer' =>$this->resource->query_type_customer?$this->resource->query_type_customer->name:null,
                'description' => $this->resource->description,
                'created_date' => $this->fechaFormat($this->resource->created_at),
                'created_time' => $this->horaFormat($this->resource->created_at),
                'processing_name'=>$this->findNameProcessing($this->resource->processing),
                'read_at' => $this->horaFormat($this->resource->read_at),
                'start_dated_at' => $this->horaFormat($this->resource->start_dated),
                'end_dated_at' => $this->horaFormat($this->resource->end_dated),
                'total_attention_time' => $this->calculaTiempoAtencion($this->resource->start_dated,$this->resource->end_dated),
                'waiting_time_has_to_be_attended' =>$this->tiempoEsperaParaSerAtendido($this->resource->created_at,$this->resource->read_at),
                'updated_at' => $this->fechaFormat($this->resource->created_at),
                'processing_events' => $this->resource->processing_events->map(function ($item){
                    return  [
                            'name'=>$this->findNameProcessing($item->processing),
                            'created_at'=>$this->horaFormat($item->created_at)
                    ];}
                ),
               // 'data'=>$this->resource
        ];
    }

    protected function fechaFormat($fecha){

        return Carbon::parse($fecha)->format('d/m/Y');

    }
    protected function horaFormat($fecha){
        if($fecha){
            return Carbon::parse($fecha)->format('H:m:s');
        }else{
            return null;
        }
    }
    protected function calculaTiempoAtencion($inicio, $fin){
        if ($fin && $fin){
            return $this->responseTimeAtencion(Carbon::parse($inicio)->diff(Carbon::parse($fin)));
        }
    }
    protected function tiempoEsperaParaSerAtendido($created_at,$read_at){
        if ($created_at && $read_at){
            return $this->responseTimeAtencion(Carbon::parse($created_at)->diff(Carbon::parse($read_at)));
        }else{
            return $this->responseTimeAtencion(Carbon::parse($created_at)->diff(now()));
        }
    }
    protected function responseTimeAtencion($data){
        return $data->h.":".$data->i.":".$data->s;
    }

}
