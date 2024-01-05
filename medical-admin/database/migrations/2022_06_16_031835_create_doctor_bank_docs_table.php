<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoctorBankDocsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctor_bank_docs', function (Blueprint $table) {
            $table->id();
            $table->integer('doctor_id');
            $table->string('name');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('ifsc');
            $table->string('ac_no');
            $table->string('ac_type');
            $table->string('micr_code');
            $table->string('cancel_cheque');
            $table->string('pan_no');
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
        Schema::dropIfExists('doctor_bank_docs');
    }
}
