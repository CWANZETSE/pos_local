<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('branch_id')->nullable();
            $table->string('username')->unique()->nullable();
            $table->boolean('status')->default(0);
            $table->string('phone')->unique()->nullable();
            $table->boolean('assigned_till')->default(0);
            $table->string('password');
            $table->string('prefered_date_format')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('printer_ip')->nullable();
            $table->integer('printer_port')->nullable();
            $table->integer('print_receipt')->default(0);
            $table->string('last_login_mac')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
