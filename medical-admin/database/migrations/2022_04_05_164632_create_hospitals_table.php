<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHospitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('address');
            $table->string('phone_no', 20);
            $table->string('city');
            $table->string('pincode');
            $table->string('country');
            $table->string('beds_quantity');
            $table->string('specialities_id');
            $table->string('procedures_id');
            $table->string('image');
            $table->string('registration_details', 500);
            $table->string('registration_file', 500);
            $table->string('accredition_details', 500);
            $table->string('accredition_certificate', 500);
            $table->string('empanelments', 500);
            $table->string('about', 7000);
            $table->string('facilities_avialable', 500);
            $table->string('latitude', 50);
            $table->string('longitude', 50);
            $table->enum('type', ['Hospital', 'Clinic'])->default('Hospital');
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
            $table->string('slug')->unique();
            $table->enum('is_deleted', ['0', '1'])->default(0)->comment('0 Not Delete 1 Deleted');
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
        Schema::dropIfExists('hospitals');
    }
}
