<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorMedicineAdviceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_medicine_advice', function (Blueprint $table) {
            $table->id();
            $table->integer('appointment_id');
            $table->integer('doctor_id');
            $table->integer('medi_id');
            $table->string('formulation', 50);
            $table->string('name', 500);
            $table->string('strength', 300);
            $table->string('route_of_administration');
            $table->string('frequncy', 100);
            $table->string('duration', 100);
            $table->string('special_instruction', 1000);
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
        Schema::dropIfExists('doctor_medicine_advice');
    }
}
