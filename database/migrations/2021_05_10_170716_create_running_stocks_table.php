<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRunningStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('running_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('branch_id');
            $table->integer('user_id')->nullable();
            $table->integer('admin_id')->nullable();
            $table->integer('size_id');
            $table->integer('units');
            $table->decimal('unit_cost',10,2)->nullable();
            $table->integer('balance');
            $table->string('description');
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
        Schema::dropIfExists('running_stocks');
    }
}
