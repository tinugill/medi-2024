<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmaciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharmacies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner_name');
            $table->string('owner_id', 500);
            $table->string('partner_name');
            $table->integer('delivery_charges_if_less')->default(0);
            $table->integer('delivery_charges')->default(0);
            $table->string('partner_id', 500);
            $table->string('pharmacist_name');
            $table->string('pharmacist_regis_no');
            $table->string('pharmacist_regis_upload', 500);
            $table->string('gstin');
            $table->string('gstin_certificate', 500);
            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('address');
            $table->string('city');
            $table->string('pincode');
            $table->string('country');
            $table->string('latitude');
            $table->string('longitude');
            $table->string('fax');
            $table->string('password');
            $table->string('image');
            $table->string('banner_image');
            $table->string('drug_liscence_number');
            $table->string('drug_liscence_file');
            $table->date('drug_liscence_valid_upto')->nullable();
            $table->string('cp_name');
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
        Schema::dropIfExists('pharmacies');
    }
}
