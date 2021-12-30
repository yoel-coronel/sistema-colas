<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarouselsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carousels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('tiempo')->default(2);
            $table->longText('path')->nullable();
            $table->string('type_player')->nullable()->default('video/mp4');
            $table->string('class_default')->nullable()->default('active');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });

        \Illuminate\Support\Facades\DB::table('carousels')->insert(array('name'=>'FOVIPOL', 'tiempo'=>time(),'path'=>'img/1.png','type_player'=>'imgen/png','class_default'=>'active'));
        \Illuminate\Support\Facades\DB::table('carousels')->insert(array('name'=>'FOVIPOL', 'tiempo'=>time(),'path'=>'img/2.jpg','type_player'=>'imgen/png','class_default'=>''));
        \Illuminate\Support\Facades\DB::table('carousels')->insert(array('name'=>'FOVIPOL', 'tiempo'=>time(),'path'=>'video/REFINANCIAMIENTO.mp4','type_player'=>'video/mp4','class_default'=>''));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carousels');
    }
}
