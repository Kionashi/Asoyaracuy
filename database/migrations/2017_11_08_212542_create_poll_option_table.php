<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePollOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('poll_option', function (Blueprint $table) {
            // Identifier
            $table->increments('id');
            
            // Fields
            $table->string('title');
            $table->string('color');
            
            // Foreing keys
            $table->integer('poll_id')->unsigned();
            $table->foreign('poll_id')->references('id')->on('poll');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('poll_option');
    }
}
