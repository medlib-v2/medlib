<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function(Blueprint $table)
        {
            $table->increments('book_id');
            $table->string('isbn', 45);
            $table->string('title');
            $table->string('issn', 45);
            $table->integer('pages')->nullable();
            $table->string('language', 45)->nullable();
            $table->integer('edition_id')->foreign('edition_id')->references('edition_id')->on('editions');
            $table->date('publication');
            $table->text('notes')->nullable();
            $table->integer('author_id')->foreign('author_id')->references('author_id')->on('authors');
            $table->integer('publisher_id')->foreign('publisher_id')->references('publisher_id')->on('publishers');
            $table->integer('categorie_id')->foreign('categorie_id')->references('categorie_id')->on('categories');
        });

        DB::unprepared('ALTER TABLE `books` DROP PRIMARY KEY, ADD PRIMARY KEY (  `book_id` ,  `isbn` )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books');
    }
}
