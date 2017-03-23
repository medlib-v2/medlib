<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeedFollowsTable extends Migration
{
    public function up()
    {
        Schema::create('feed_follows', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feed_id')->index()->unsigned();
            $table->foreign('feed_id')->references('id')->on('feeds')->onDelete('cascade');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('feed_follows');
    }
}
