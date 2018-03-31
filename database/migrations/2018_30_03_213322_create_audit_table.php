<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audit', function (Blueprint $table) {
            // Identifier
            $table->increments('id');
            
            // Fields
            $table->string('action');
            $table->text('details');
            $table->string('ip_address');
            
            // Foreign keys
            $table->integer('admin_user_id')->unsigned()->nullable();
            $table->foreign('admin_user_id')->references('id')->on('admin_user');
            
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
        Schema::dropIfExists('audit');
    }
}
