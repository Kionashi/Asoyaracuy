<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpecialFeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('special_fee', function (Blueprint $table) {
            // Identifier
            $table->increments('id');
            
            // Fields
            $table->decimal('amount', 10, 2);
            $table->boolean('enabled');
            
            // Foreing keys
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('user');
            
            // Timestamps
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
        Schema::dropIfExists('special_fee');
    }
}
