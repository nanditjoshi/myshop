<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_passengers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('orders_id')->nullable(); // orders id
            $table->string('type')->nullable(); // adults or children
            $table->integer('is_lead')->nullable();
            $table->string('title')->nullable();
            $table->string('firstname')->nullable();
            $table->string('surname')->nullable();
            $table->string('post_code')->nullable();

            $table->string('house_name')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->string('post_code_add')->nullable();
            $table->string('telephone_no')->nullable();
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
        Schema::dropIfExists('order_passengers');
    }
}
