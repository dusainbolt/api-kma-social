<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_info', function (Blueprint $table) {
            $table->bigIncrements('id'); // The data type is Big Integer.
            $table->unsignedBigInteger("userId");
            $table->string('userName', 25);
            $table->string('fullName');
            $table->string('codeStudent', 12);
            $table->dateTime('birthday', 0);
            $table->tinyInteger('gender')->default(0);
            $table->string('job')->nullable();
            $table->timestamps();
        });

        Schema::table('user_info', function(Blueprint $table) {
            $table->foreign('userId')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_info');
    }
}