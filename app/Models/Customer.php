<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'full_surname',
        'full_name',
        'guest_fachada',
        'iden_pers_per',
        'document_number',
        'cip_number',
        'telephone',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'integer',
    ];



}
