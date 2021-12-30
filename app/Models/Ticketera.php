<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticketera extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = ['modulo_id','name_host','password_host','name_user_host','name_ticket','ip_ticket','level'];
}

