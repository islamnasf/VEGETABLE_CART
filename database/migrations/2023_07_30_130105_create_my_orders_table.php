<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['Preparing','Prepared','finish'])->default('Preparing');
            $table->string('paid')->nullable();
            $table->string('money')->nullable();
            $table->unsignedBigInteger('allOrder_id');  
            $table->foreign('allOrder_id')->references('id')->on('all_orders')->onDelete('cascade');     
            $table->unsignedBigInteger('delivery_id');  
            $table->foreign('delivery_id')->references('id')->on('delivers')->onDelete('cascade');     
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
        Schema::dropIfExists('my_orders');
    }
}
