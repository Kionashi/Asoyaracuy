<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateAdminUserRoleHasPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user_role_has_permission', function (Blueprint $table) {

        	// Foreign keys
        	$table->integer('admin_user_role_id')->unsigned();
        	$table->foreign('admin_user_role_id')->references('id')->on('admin_user_role')->onDelete('cascade');
        	$table->integer('admin_user_permission_id')->unsigned();
        	$table->foreign('admin_user_permission_id')->references('id')->on('admin_user_permission')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_user_role_has_permission');
    }
}
