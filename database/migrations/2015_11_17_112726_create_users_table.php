<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email', 64)->unique();
            $table->string('username', 64)->unique();
            $table->string('password');
            $table->string('first_name', 64)->nullable();
            $table->string('last_name', 64)->nullable();
            $table->enum('profession', ['student','researcher','teacher']);
            $table->date('date_of_birth');
            $table->enum('gender', ['male','female']);
            $table->boolean('activated')->default(false);
            $table->tinyInteger('account_type', false);
            $table->string('user_avatar');
            $table->boolean('onlinestatus')->default(0);
            $table->boolean('chatstatus')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
