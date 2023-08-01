<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('phone')->unique();
            $table->string('phone_code');
            $table->string('image')->nullable();
            $table->unsignedBigInteger('code_number')->unique();
            $table->string('city')->nullable();
            $table->string('verify')->default("not-verified");
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('car_name')->nullable();
            $table->string('car_model')->nullable();
            $table->string('front_car')->nullable();
            $table->string('back_car')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
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
        Schema::dropIfExists('delivers');
    }
}
