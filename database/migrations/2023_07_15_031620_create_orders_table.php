<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
           //product
            $table->unsignedBigInteger('product_id');
            $table->string('product_name')->nullable();
            $table->string('image')->nullable();
            $table->string('quantity')->nullable();
           // $table->enum('status', ['active','finish'])->default('active');
            $table->unsignedBigInteger('allOrder_id');  
            $table->foreign('allOrder_id')->references('id')->on('all_orders')->onDelete('cascade');     
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
