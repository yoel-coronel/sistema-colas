<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'full_name',
        'password',
        'desk_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'is_active',
        'is_admin',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
         'is_active' => 'integer',

    ];
    public function tickets(){
        return $this->belongsToMany(Ticket::class);
    }
    public function roles(){
        return $this->belongsToMany(Role::class);
    }
    public function queueList(){
        return $this->hasMany(QueueList::class);
    }
    public function desk(){
        return $this->belongsTo(Desk::class);
    }
    public function hasRoles(array $roles)
    {
        return  $this->roles->pluck('key_name')->intersect($roles)->count();
    }

}
