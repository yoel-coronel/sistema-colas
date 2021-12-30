<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketerasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticketeras', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('modulo_id');
            $table->foreign('modulo_id')->references('id')->on('modulos')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('name_host')->nullable();
            $table->string('password_host')->nullable();
            $table->string('name_user_host')->nullable();
            $table->string('name_ticket')->nullable();
            $table->string('ip_ticket')->nullable();
            $table->enum('level',[1,2])->default(1);//1:ip, 2:local
            $table->boolean('is_Active')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticketeras');
    }
}
