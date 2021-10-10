<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCardPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('card_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('sale_id');
            $table->bigInteger('user_id');
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->bigInteger('ResultCode')->nullable();
            $table->unsignedDecimal('TransactionAmount',8,2)->nullable();
            $table->bigInteger('CashBackAmt')->nullable();
            $table->string('authCode')->nullable();
            $table->string('msg')->nullable();
            $table->string('rrn')->nullable();
            $table->string('respCode')->nullable();
            $table->string('cardExpiry')->nullable();
            $table->string('currency')->nullable();
            $table->string('pan')->nullable();
            $table->string('tid')->nullable();
            $table->string('transType')->nullable();
            $table->string('payDetails')->nullable();
            $table->boolean('reversed')->default(0);
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
        Schema::dropIfExists('card_payments');
    }
}
