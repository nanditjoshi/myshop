<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmailPhoneToRequestCallbacks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('request_callbacks', function (Blueprint $table) {
            $table->dropColumn('requestdestination');
            $table->string('requesttelephone')->nullable();
            $table->string('requestemail')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('request_callbacks', function (Blueprint $table) {
            $table->dropColumn('requesttelephone');
            $table->dropColumn('requestemail');
        });
    }
}
