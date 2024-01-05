<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->default(0);
            $table->integer('member_id')->default(0);
            $table->string('type');
            $table->date('date');
            $table->string('time_slot');
            $table->string('address', 400);
            $table->string('locality');
            $table->string('pincode');
            $table->string('city');
            $table->integer('hospital_id');
            $table->integer('doctor_id');
            $table->integer('payment_id', 500);
            $table->enum('is_accepted', [0, 1, 2])->comment('0 not not 1 for yes 2 completed')->default(0);
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
        Schema::dropIfExists('appointments');
    }
}
