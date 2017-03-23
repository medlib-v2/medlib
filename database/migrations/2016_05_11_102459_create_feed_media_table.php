<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeedMediaTable extends Migration
{
    public function up()
    {
        Schema::create('feed_media', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feed_id')->index()->unsigned();
            $table->foreign('feed_id')->references('id')->on('feeds')->onDelete('cascade');
            $table->integer('media_id')->index()->unsigned();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('feed_media');
    }
}
