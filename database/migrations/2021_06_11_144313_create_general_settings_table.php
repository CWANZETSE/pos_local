<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('store_footer_copyright')->nullable();
            $table->string('store_name')->nullable();
            $table->string('store_address')->nullable();
            $table->string('store_phone')->nullable();
            $table->string('store_email')->nullable();
            $table->string('store_website')->nullable();
            $table->string('printer_name')->nullable();
            $table->integer('tax_percentage')->default(0);
            $table->integer('mpesa')->default(13);
            $table->integer('cash')->default(10);
            $table->integer('kcb_pinpad')->default(15);
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
        Schema::dropIfExists('general_settings');
    }
}
