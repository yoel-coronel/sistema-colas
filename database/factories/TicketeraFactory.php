<?php

namespace Database\Factories;

use App\Models\Modulo;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketeraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'modulo_id'=>Modulo::first()->id,
            'name_host'=>'P00021043',
            'password_host'=>null,
            'name_user_host'=>'ycoronel',
            'name_ticket'=>'ticket',
            'ip_ticket'=>null,
            'level'=>2,
        ];
    }
}
