<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIpcPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipc_payment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('ipcmethod')->nullable();
            $table->string('amount')->nullable();
            $table->string('currency')->nullable();
            $table->integer('orders_id')->nullable();
            $table->string('ipc_trnref')->nullable();
            $table->string('requeststan')->nullable();
            $table->timestamp('requestdatetime')->nullable();
            $table->string('customerphone')->nullable();
            $table->string('cardtoken')->nullable();
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
        Schema::dropIfExists('ipc_payment');
    }
}
