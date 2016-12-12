<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBooksSubjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books_subject', function (Blueprint $table) {
            $table->increments('subject_id');
            $table->string('subject_isbn', 45);
            $table->text('subject_name');
        });

        DB::unprepared('ALTER TABLE `books_subject` DROP PRIMARY KEY, ADD PRIMARY KEY (  `subject_id` ,  `subject_isbn` )');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('books_subject');
    }
}
