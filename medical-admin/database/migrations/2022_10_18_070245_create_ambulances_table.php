<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulances', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('owner_name');
            $table->string('image', 500);
            $table->string('banner', 500);
            $table->string('about', 2000);
            $table->string('registration_certificate', 500);
            $table->string('aadhar_proof', 500);
            $table->string('gstin_proof', 500);
            $table->string('gstin');
            $table->string('type_of_user');
            $table->string('aadhar');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('address');
            $table->string('city');
            $table->string('pincode');
            $table->string('country');
            $table->string('slug');
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
        Schema::dropIfExists('ambulances');
    }
}
