<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabtestBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labtest_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('lab_id');
            $table->integer('sample_collector');
            $table->integer('delivery_boy'); 
            $table->string('is_home_collection');
            $table->string('is_home_delivery');
            $table->string('is_ambulance');
            $table->string('price');
            $table->string('h_c_price');
            $table->string('h_d_price');
            $table->string('ambulance_price');
            $table->string('address', 600);
            $table->string('report_file', 400);
            $table->string('payment_id');
            $table->enum('is_completed', [0, 1, 2])->comment('0 not accepted 1 accepted 2 delivered')->default(0);
            $table->enum('is_deleted', [0, 1])->comment('0 not deleted 1 deleted')->default(0);

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
        Schema::dropIfExists('labtest_bookings');
    }
}
