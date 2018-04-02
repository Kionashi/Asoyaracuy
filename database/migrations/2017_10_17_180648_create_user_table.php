<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\Gender;
use App\Enums\UserStatus;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            // Identifier
            $table->increments('id');
            
            // Fields
            $table->decimal('balance', 10, 2);
            $table->string('email');
            $table->boolean('enabled');
            $table->string('house');
            $table->string('password');
            $table->string('phone')->nullable();
            $table->string('recover_code')->nullable();
            $table->dateTime('recover_date')->nullable();
            $table->string('recover_ip_address')->nullable();
            $table->dateTime('register_date')->nullable();
            $table->string('register_ip_address')->nullable();
            $table->enum('status', [UserStatus::ACTIVE, UserStatus::CREATED, UserStatus::DISABLED]);
            
            // Foreign keys
            $table->integer('user_id')->unsigned();
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
        Schema::dropIfExists('user');
    }
}
