<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('username')->unique()->nullable();
            $table->boolean('status')->default(0);
            $table->string('phone')->unique()->nullable();
            $table->string('password');
            $table->timestamp('last_login')->nullable();
            $table->string('last_login_ip')->nullable();
            $table->string('last_login_mac')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->bigInteger('role_id')->nullable();
            $table->text('branch_id')->nullable();
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
        Schema::dropIfExists('admins');
    }
}
