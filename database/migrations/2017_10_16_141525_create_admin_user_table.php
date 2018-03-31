<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user', function (Blueprint $table) {
            // Identifier
            $table->increments('id');
            
            // Fields
            $table->string('email');
            $table->boolean('enabled');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');
            $table->string('phone');
            $table->integer('type')->unsigned()->default(1);
            
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
        Schema::dropIfExists('admin_user');
    }
}
