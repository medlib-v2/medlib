<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFeedReportsTable extends Migration
{
    public function up()
    {
        Schema::create('feed_reports', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('feed_id')->unsigned();
            $table->integer('reporter_id')->unsigned();
            $table->string('status', 200);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::drop('feed_reports');
    }
}
