<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modulo extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = ['id','name','is_active'];

    protected $casts = [
        'is_active' => 'integer',
    ];

    public function ticketera(){

        return $this->hasOne(Ticketera::class,'modulo_id','id');

    }

}
