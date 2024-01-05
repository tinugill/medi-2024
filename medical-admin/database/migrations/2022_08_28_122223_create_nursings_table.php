<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNursingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nursings', function (Blueprint $table) {
            $table->id();
            $table->integer('buero_id');
            $table->string('name');
            $table->string('regis_type');
            $table->string('mobile');
            $table->string('email');
            $table->string('type');
            $table->string('gender');
            $table->string('image', 500);
            $table->string('banner', 500);
            $table->string('about', 2000);
            $table->integer('experience');
            $table->string('registration_certificate', 500);
            $table->string('id_proof', 500);
            $table->string('qualification');
            $table->string('degree', 500);
            $table->string('part_fill_time');
            $table->string('work_hours');
            $table->string('is_weekof_replacement');
            $table->string('custom_remarks', 1000);
            $table->integer('visit_charges');
            $table->integer('per_hour_charges');
            $table->integer('per_days_charges');
            $table->integer('per_month_charges');
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
        Schema::dropIfExists('nursings');
    }
}
