<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyOptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('propertycode');
            $table->string('name')->nullable();
            $table->string('price')->nullable();  
            $table->string('pricetype')->nullable();
            $table->string('maxQty')->nullable();
            $table->string('allowedDates')->nullable();
            $table->string('defaultQty')->nullable();
            $table->string('img')->nullable();
            $table->string('optionPayment')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('property_options');
    }
}
