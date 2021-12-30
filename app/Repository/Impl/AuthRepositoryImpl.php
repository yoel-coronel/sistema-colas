<?php

namespace App\Repository\Impl;

use App\Models\Oracle\AdmUsuario;
use App\Models\User;
use App\Repository\AuthRepository;
use Illuminate\Support\Collection;

class AuthRepositoryImpl implements AuthRepository
{

    public function findTicketUser(User $user)
    {
        $data = new Collection();
        $data->put('user',$user);
        $data->put('tickets',$user->tickets()->select('id','name','serial')->where('is_active',1)->get());
        $data->put('desk',$user->desk()->select('id','name','serial')->where('is_active',1)->first());
        $data->put('roles',$user->roles()->select('id','name')->where('is_active',1)->get());
        return $data;
    }

    public function findOracleAdmUser(string $name)
    {
        $user = AdmUsuario::with('persona')->where('codi_usua_usr',$name)->where('flag_esta_usr','<>',0)->first();
        if($user){
            return $user;
        }
        return null;
    }
}
