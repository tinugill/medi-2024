<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->integer('uid');
            $table->integer('doctor_id');
            $table->integer('hospital_id');
            $table->string('speciality_id');
            $table->string('illness', 500);
            $table->string('package_name');
            $table->string('hospital_name', 300)->default('');
            $table->string('hospital_address', 600)->default('');
            $table->string('stay_type');
            $table->string('package_location');
            $table->string('charges_in_rs');
            $table->string('discount_in_rs');
            $table->string('charges_in_doller');
            $table->string('discount_in_doller');
            $table->longText('details');
            $table->enum('is_active', [0, 1])->comment('0 not inactive 1 active')->default(1);
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
        Schema::dropIfExists('treatments');
    }
}
