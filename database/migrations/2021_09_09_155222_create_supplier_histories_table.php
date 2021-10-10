<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_histories', function (Blueprint $table) {
            $table->id();
            $table->BigInteger('supplier_code')->nullable();
            $table->BigInteger('invoice_id')->nullable();
            $table->text('description')->nullable();
            $table->decimal('money_in',12,2)->nullable();
            $table->decimal('money_out',12,2)->nullable();
            $table->decimal('balance',12,2)->nullable();
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
        Schema::dropIfExists('supplier_histories');
    }
}
