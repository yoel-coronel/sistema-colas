<?php

namespace App\Models;

use App\Events\ProcessingModelEvent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Event;

class QueueList extends Model
{
    use HasFactory,SoftDeletes;

    public static function boot()
    {
        parent::boot();

        static::created(function($queue){
            Event::dispatch(new ProcessingModelEvent($queue));
        });
        static::updated(function ($queueList){
            Event::dispatch(new ProcessingModelEvent($queueList));
        });
    }

    protected $fillable = [
        'ticket_id',
        'user_id',
        'desk_id',
        'customer_id',
        'query_type_customer_id',
        'description',
        'guest_name',
        'guest_code',
        'address_ip',
        'sequence',
        'processing',
        'start_dated',
        'end_dated',
        'read_at'
    ];
    protected $casts = [
        'processing'=>'integer',
        'created_at' =>'datetime',
        'updated_at' =>'datetime',
        'start_dated'=>'datetime',
        'end_dated'=>'datetime',
        'read_at'=>'datetime'
    ];

    public function query_type_customer(){
        return $this->belongsTo(QueryTypeCustomer::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
    public function desk(){
        return $this->belongsTo(Desk::class);
    }
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function processing_events(){
        return $this->hasMany(ProcessingEvent::class);
    }

}
