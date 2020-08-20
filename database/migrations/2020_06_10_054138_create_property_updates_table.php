<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertyUpdatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_updates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('propertycode');
            $table->string('enabled');
            $table->timestamp('lastupdate')->nullable();
            $table->timestamp('photolastupdate')->nullable();
            $table->string('specialoffers')->nullable();
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
        Schema::dropIfExists('property_updates');
    }
}
