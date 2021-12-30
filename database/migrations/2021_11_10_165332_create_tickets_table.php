<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('level',[1,2,3,4,5,6])->default(1);
            $table->string('description')->nullable();
            $table->string('serial')->nullable();
            $table->longText('path')->nullable();
            $table->string('class_default')->nullable()->default('bg-success');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        \Illuminate\Support\Facades\DB::table('tickets')->insert(array('name'=>'MESA DE PARTES','serial'=>'MP','path'=>'/img/icon.png','class_default'=>'bg-success text-white'));
        \Illuminate\Support\Facades\DB::table('tickets')->insert(array('name'=>'PERSONAL','serial'=>'PE','path'=>'/img/icon.png','class_default'=>'bg-success text-white'));
        \Illuminate\Support\Facades\DB::table('tickets')->insert(array('name'=>'RECURSOS HUMANOS','serial'=>'RH','path'=>'/img/icon.png','class_default'=>'bg-info text-dark'));
        \Illuminate\Support\Facades\DB::table('tickets')->insert(array('name'=>'TESORERÍA','serial'=>'TE','path'=>'/img/icon.png','class_default'=>'bg-info text-dark'));
        \Illuminate\Support\Facades\DB::table('tickets')->insert(array('name'=>'PLATAFORMA','serial'=>'PL','path'=>'/img/icon.png','class_default'=>'bg-white text-dark'));
        \Illuminate\Support\Facades\DB::table('tickets')->insert(array('name'=>'VENTANILLA ','serial'=>'VE','path'=>'/img/icon.png','class_default'=>'bg-white text-dark'));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tickets');
    }
}
