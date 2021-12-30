<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessingEvent extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','desk_id','queue_list_id','processing'];

    protected $casts = [
        'processing'=>'integer',
    ];

}
