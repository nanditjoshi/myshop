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
            $table->bigIncrements('id');
            $table->integer('userid')->nullable();
            $table->string('propertycode')->nullable();
            $table->integer('adults')->nullable();
            $table->integer('children')->nullable();
            $table->string('insurance_id')->nullable();
            $table->string('transfer_id')->nullable();
            $table->string('deposit_pay')->nullable();
            $table->string('remaning_pay')->nullable();
            $table->string('total_price')->nullable();
            $table->string('price_per_persion')->nullable();
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
