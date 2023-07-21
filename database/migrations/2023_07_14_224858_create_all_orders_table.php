<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('all_orders', function (Blueprint $table) {
            $table->id();
            //user
            $table->unsignedBigInteger('user_id');
            $table->string('user_name')->nullable();
            $table->string('user_phone')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            //
            $table->enum('status', ['waiting', 'preparation','in delivery','finish','cancelled'])->default('waiting');
            $table->string('notes')->nullable();
            $table->string('code')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('total_price')->nullable();  
            $table->string('user_address')->nullable();  
            $table->date('day');
            $table->time('houre');         
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
        Schema::dropIfExists('all_orders');
    }
}
