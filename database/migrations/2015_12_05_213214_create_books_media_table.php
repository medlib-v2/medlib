<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_media', function (Blueprint $table) {
            $table->increments('media_id');
            $table->string('media_url');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->integer('book_id')->foreign('book_id')->references('book_id')->on('books');
            $table->integer('book_isbn')->foreign('book_isbn')->references('book_isbn')->on('books');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books_media');
    }
}
