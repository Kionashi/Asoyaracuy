<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAdminUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('admin_user_role', function (Blueprint $table) {
       		// Identifier
    		$table->increments('id');
    		
    		// Fields
    		$table->string('name');
    		$table->boolean('enabled');
    		$table->integer('admin_user_type')->unsigned()->default(1);
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       Schema::drop('admin_user_role');
    }
}
