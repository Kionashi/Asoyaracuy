<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact', function (Blueprint $table) {
            // Identifier
            $table->increments('id');
            
            // Fields
            $table->dateTime('date_contact');
            $table->string('email');
            $table->string('first_name');
            $table->string('ip_address', 45);
            $table->string('last_name');
            $table->text('message');
            $table->string('phone');

            // Foreign keys
            $table->integer('contact_reason_id')->unsigned();
            $table->foreign('contact_reason_id')->references('id')->on('contact_reason');
            $table->integer('user_id')->nullable()->unsigned();
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
        Schema::dropIfExists('contact');
    }
}
