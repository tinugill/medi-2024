<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePaymentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_payment_histories', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->date('from_date'); 
            $table->date('end_date'); 
            $table->integer('for_count');
            $table->integer('coupon');
            $table->string('order_id');
            $table->integer('payment_id');
            $table->integer('service_id');
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
        Schema::dropIfExists('service_payment_histories');
    }
}
