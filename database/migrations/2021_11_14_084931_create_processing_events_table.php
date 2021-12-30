<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProcessingEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('processing_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable()->default(null);
            $table->unsignedBigInteger('desk_id')->nullable()->default(null);
            $table->unsignedBigInteger('queue_list_id');
            $table->integer('processing');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('desk_id')->references('id')->on('desks')->onUpdate('cascade');
            $table->foreign('queue_list_id')->references('id')->on('queue_lists');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('processing_events');
    }
}
