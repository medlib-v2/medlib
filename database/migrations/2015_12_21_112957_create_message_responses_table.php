<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageResponsesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_responses', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->integer('message_id');
            $table->integer('sender_id')->unsigned()->index();
            $table->foreign('sender_id')->references('id')->on('users');
            $table->integer('receiver_id')->unsigned()->index();
            $table->foreign('receiver_id')->references('id')->on('users');
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
        Schema::dropIfExists('message_responses');
    }
}
