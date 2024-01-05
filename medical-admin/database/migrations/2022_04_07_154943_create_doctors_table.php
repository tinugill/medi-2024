<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('password');
            $table->enum('type', ['Doctor', 'Nurse', 'Staff']);
            $table->enum('gender', ['Male', 'Female', 'Other']);

            $table->string('specialization_id');
            $table->string('specialities_id');
            $table->string('symptom_i_see');
            $table->string('deasies_i_treat');
            $table->string('treatment_and_surgery');

            // $table->unsignedBigInteger('specialization_id')->nullable();
            // $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('CASCADE')->onUpdate('CASCADE');

            $table->string('degree_file');
            $table->string('working_days');
            $table->string('doctor_image');
            $table->string('l_h_image');
            $table->string('l_h_sign');
            $table->string('doctor_banner');
            $table->string('appointment_timing');
            $table->string('home_visit');
            $table->integer('consultancy_fee');
            $table->integer('home_consultancy_fee');
            $table->integer('online_consultancy_fee');
            $table->string('designation', 500);
            $table->string('letterhead', 500);
            $table->string('signature', 500);
            $table->string('about');
            $table->text('award');
            $table->string('experience');
            $table->string('memberships_detail');
            $table->string('registration_details');
            $table->string('medical_counsiling');
            $table->string('registration_certificate', 500);
            $table->string('latitude', 50);
            $table->string('longitude', 50);
            $table->integer('hospital_id');
            $table->text('address');
            $table->string('city');
            $table->string('pincode');
            $table->string('country');
            $table->text('address_2');
            $table->string('city_2');
            $table->string('pincode_2');
            $table->string('country_2');
            $table->string('latitude_2', 50);
            $table->string('longitude_2', 50);
            $table->string('slug')->unique();
            $table->enum('is_deleted', ['0', '1'])->default(0)->comment('0 Not Delete 1 Deleted');;
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
        Schema::dropIfExists('doctors');
    }
}
