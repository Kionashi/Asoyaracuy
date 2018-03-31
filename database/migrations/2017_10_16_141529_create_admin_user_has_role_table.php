<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAdminUserHasRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_has_role', function (Blueprint $table) {
        	
        	// Foreign keys
    		$table->integer('admin_user_id')->unsigned();
    		$table->foreign('admin_user_id')->references('id')->on('admin_user')->onDelete('cascade');
    		$table->integer('admin_user_role_id')->unsigned();
    		$table->foreign('admin_user_role_id')->references('id')->on('admin_user_role');
    	});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_user_has_role');
    }
}
