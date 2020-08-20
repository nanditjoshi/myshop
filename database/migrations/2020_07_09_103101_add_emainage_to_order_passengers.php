<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmainageToOrderPassengers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_passengers', function (Blueprint $table) {
            $table->string('email')->nullable();
            $table->string('age')->nullable()->comment('children age'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_passengers', function (Blueprint $table) {
            //
        });
    }
}
