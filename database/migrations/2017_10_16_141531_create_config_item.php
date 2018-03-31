<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfigItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('config_item', function (Blueprint $table) {
        	
        	// Identifier
     		$table->increments('id');
     		
     		// Fields
     		$table->string('description');
	        $table->string('key');
	        $table->string('value');
      	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('config_item');
    }
}
