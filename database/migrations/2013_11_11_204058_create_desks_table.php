<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDesksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('desks', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('serial')->nullable();
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        \Illuminate\Support\Facades\DB::table('desks')->insert(array('name'=>'ESCRITORIO 1', 'serial'=>'ES01'));
        \Illuminate\Support\Facades\DB::table('desks')->insert(array('name'=>'ESCRITORIO 2', 'serial'=>'ES02'));
        \Illuminate\Support\Facades\DB::table('desks')->insert(array('name'=>'ESCRITORIO 3', 'serial'=>'ES03'));
        \Illuminate\Support\Facades\DB::table('desks')->insert(array('name'=>'ESCRITORIO 4', 'serial'=>'ES04'));
        \Illuminate\Support\Facades\DB::table('desks')->insert(array('name'=>'ESCRITORIO 5', 'serial'=>'ES05'));
        \Illuminate\Support\Facades\DB::table('desks')->insert(array('name'=>'ESCRITORIO 6', 'serial'=>'ES06'));
        \Illuminate\Support\Facades\DB::table('desks')->insert(array('name'=>'ESCRITORIO 7', 'serial'=>'ES07'));
        \Illuminate\Support\Facades\DB::table('desks')->insert(array('name'=>'ESCRITORIO 8', 'serial'=>'ES08'));
        \Illuminate\Support\Facades\DB::table('desks')->insert(array('name'=>'ESCRITORIO 9', 'serial'=>'ES09'));
        \Illuminate\Support\Facades\DB::table('desks')->insert(array('name'=>'ESCRITORIO 10', 'serial'=>'ES10'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('desks');
    }
}
