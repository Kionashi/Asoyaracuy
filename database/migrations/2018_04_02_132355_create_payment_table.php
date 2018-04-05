<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\PaymentType;
use App\Enums\PaymentStatus;

class CreatePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment', function (Blueprint $table) {
            // Identifier
            $table->increments('id');
            
            // Fields
            $table->decimal('amount', 10, 2);
            $table->string('bank');
            $table->string('confirmation_code');
            $table->date('date')->nullable();
            $table->string('file');
            $table->string('note');
            $table->enum('type', [PaymentType::DEPOSIT, PaymentType::TRANSFERENCE, PaymentType::CASH]);
            $table->enum('status', [PaymentStatus::APPROVED, PaymentStatus::PENDING, PaymentStatus::REJECTED]);
            
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
        Schema::dropIfExists('payment');
    }
}
