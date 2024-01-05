<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulanceBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulance_bookings', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');  
            $table->string('name');  
            $table->string('mobile');  
            $table->integer('ambulance_id');  
            $table->integer('service_ambulance_id');  
            $table->string('booking_type');  
            $table->string('booking_for');  
            $table->string('payment_id');  
            $table->string('address',500);  
            $table->string('date');  
            $table->enum('status', [0, 1, 2, 3, 4, 5, 6])->comment('0 pending 1 accepted 2 out for service 3 reached 4 completed 5 canceled')->default(0);
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
        Schema::dropIfExists('ambulance_bookings');
    }
}
