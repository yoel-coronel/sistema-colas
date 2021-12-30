<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'tiempo',
        'path',
        'type_player',
        'class_default',
         'is_active'
    ];

    protected $casts = [
        'is_active' => 'integer',
    ];
}
