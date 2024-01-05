<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaboratoristsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laboratorists', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner_name');
            $table->string('owner_id', 500);
            $table->string('phone_no');
            $table->integer('h_c_fee');
            $table->integer('h_c_fee_apply_before');
            $table->integer('r_d_fee');
            $table->integer('r_d_fee_apply_before');
            $table->integer('ambulance_fee');
            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('CASCADE')->onUpdate('CASCADE')->nullable();
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('address');
            $table->string('city');
            $table->string('pincode');
            $table->string('country');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('password');
            $table->string('image');
            $table->string('banner_image');
            $table->string('cp_name');
            $table->string('registration_detail', 500);
            $table->string('registration_file', 500);
            $table->string('about', 6000);
            $table->string('days', 100);
            $table->string('name_on_bank');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('ifsc');
            $table->string('ac_no');
            $table->string('ac_type');
            $table->string('micr_code');
            $table->string('pan_no');
            $table->string('cancel_cheque');
            $table->string('pan_image');
            $table->string('accredition_details', 500);
            $table->string('accredition_certificate', 500);
            $table->string('slug')->unique();
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
        Schema::dropIfExists('laboratorists');
    }
}
