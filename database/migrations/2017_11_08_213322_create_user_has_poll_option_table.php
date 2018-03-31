<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHasPollOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_poll_option', function (Blueprint $table) {
            // Identifier
            $table->increments('id');
            
            // Foreing keys
            $table->integer('poll_option_id')->unsigned();
            $table->foreign('poll_option_id')->references('id')->on('poll_option');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_poll_option');
    }
}
