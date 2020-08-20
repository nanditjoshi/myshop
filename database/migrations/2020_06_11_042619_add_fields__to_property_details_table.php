<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToPropertyDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('property_details', function (Blueprint $table) {
            $table->string('longitude')->nullable();
            $table->string('latitude')->nullable();
            $table->string('country')->nullable();
            $table->string('countryiso')->nullable();
            $table->string('regionname')->nullable();
            $table->integer('adults')->nullable();
            $table->integer('children')->nullable();
            $table->integer('infants')->nullable();
            $table->integer('bedrooms_new')->nullable();
            $table->integer('bathrooms_new')->nullable();
            $table->string('deposittype')->nullable();
            $table->string('checkin')->nullable();
            $table->string('checkout')->nullable();
            $table->string('title')->nullable();
            $table->string('metadescription')->nullable();
            $table->string('metakeywords')->nullable();
            $table->json('json_data')->nullable();

            $table->integer('siteID')->nullable();
            $table->integer('ownerID')->nullable();
            $table->integer('propertyownerID')->nullable();
            $table->integer('groupID')->nullable();
            $table->integer('managerID')->nullable();
            $table->string('managername')->nullable();
            $table->string('manageremail')->nullable();
            $table->string('propertyminbookingdays')->nullable();
            $table->string('propertyaddress')->nullable();
            $table->string('availabilitylink')->nullable();
            $table->timestamp('lastupdate')->nullable();
            $table->timestamp('photolastupdate')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_details', function (Blueprint $table) {
            //
        });
    }
}
