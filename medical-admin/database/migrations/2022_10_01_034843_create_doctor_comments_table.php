<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('appointment_id');
            $table->integer('doctor_id');
            $table->string('relevent_point_from_history', 1000);
            $table->string('prescription_reports', 1000);
            $table->string('provisional_diagnosis', 1000);
            $table->string('investigation_suggested', 1000);
            $table->string('treatment_suggested', 1000);
            $table->string('special_instruction', 1000);
            $table->string('followup_advice', 1000);
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
        Schema::dropIfExists('doctor_comments');
    }
}
