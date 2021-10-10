<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('supplier_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->unsignedBigInteger('invoice_id')->nullable();
            $table->boolean('canceled')->default(0);
            $table->text('order_data');
            $table->integer('canceled_by')->nullable();
            $table->boolean('payment_status')->default(0);
            $table->dateTime('due_on')->nullable();
            $table->dateTime('paid_on')->nullable();
            $table->unsignedBigInteger('paid_by')->nullable();
            $table->unsignedBigInteger('payment_id')->nullable();
            $table->unsignedBigInteger('account_number')->nullable();
            $table->string('bank_transaction_id')->nullable();
            $table->string('bank_name')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
