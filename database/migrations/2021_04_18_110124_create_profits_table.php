<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profits', function (Blueprint $table) {
            $table->id();
            $table->integer('sale_id');
            $table->integer('branch_id');
            $table->integer('user_id');
            $table->integer('attribute_id');
            $table->integer('quantity');
            $table->float('buying_price');
            $table->float('selling_price');
            $table->float('buy_total');
            $table->float('sell_total');
            $table->float('margin');
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
        Schema::dropIfExists('profits');
    }
}
