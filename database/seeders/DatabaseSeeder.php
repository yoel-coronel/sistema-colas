<?php

namespace Database\Seeders;

use http\Client\Curl\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       // \App\Models\Desk::factory(5)->create();
         \App\Models\User::factory(1)->create();
       // \App\Models\Ticket::factory(4)->create();
        \App\Models\Modulo::factory(1)->create();
        \App\Models\Ticketera::factory(1)->create();
        \App\Models\Role::factory(1)->create();
     //   \App\Models\Carousel::factory(1)->create();

        $user = \App\Models\User::first();
        $user->tickets()->attach(\App\Models\Ticket::all());
       $user->roles()->attach(\App\Models\Role::all());
    }
}
