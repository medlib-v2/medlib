<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->text('body');
            $table->integer('timeline_id')->index()->unsigned();
            $table->foreign('timeline_id')->references('id')->on('timelines')->onDelete('cascade');
            $table->integer('user_id')->index()->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->boolean('active')->default(1);
            $table->string('soundcloud_title')->nullable();
            $table->string('soundcloud_id')->nullable();
            $table->string('youtube_title')->nullable();
            $table->string('youtube_video_id')->nullable();
            $table->string('location')->nullable();
            $table->string('type', 100);
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
        Schema::dropIfExists('feeds');
    }
}
