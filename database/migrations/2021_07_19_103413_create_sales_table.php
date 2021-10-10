<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('canceled_by')->nullable();
            $table->integer('branch_id');
            $table->bigInteger('txn_code')->default(10000000);
            $table->unsignedBigInteger('total');
            $table->decimal('tax_rate', 9, 2)->default(0);
            $table->decimal('tax', 9, 2)->default(0.00);
            $table->decimal('total_discount', 9, 2)->default(0);
            $table->text('sale');
            $table->string('mac_address')->nullable();
            $table->string('ip_address')->nullable();
            $table->unsignedBigInteger('margin')->nullable();
            $table->boolean('reversed')->default(0);
            $table->datetime('reversed_on')->nullable();
            $table->boolean('allow_reprint')->default(0);
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
        Schema::dropIfExists('sales');
    }
}
