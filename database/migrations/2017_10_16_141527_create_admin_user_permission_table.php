<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAdminUserPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_permission', function (Blueprint $table) {
        	// Identifier
    		$table->increments('id');

    		// Fields
    		$table->string('code');
    		$table->boolean('enabled');
    		$table->boolean('hidden');
    		$table->string('name');
    		$table->integer('admin_user_type')->unsigned()->default(1);
    		$table->string('url');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('admin_user_permission');
    }
}
