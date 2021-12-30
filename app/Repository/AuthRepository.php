<?php

namespace App\Repository;

use App\Models\User;

interface AuthRepository
{

    public function findTicketUser(User $user);
    public function findOracleAdmUser(string $name);


}
