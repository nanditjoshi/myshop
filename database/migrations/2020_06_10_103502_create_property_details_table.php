<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('propertycode');
            $table->string('propertyname')->nullable();
            $table->string('propertystars')->nullable();
            $table->string('propertypostcode')->nullable();
            $table->text('cottageweblocation')->nullable();
            $table->text('webdescription')->nullable();
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
        Schema::dropIfExists('property_details');
    }
}
