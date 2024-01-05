<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabtestpackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('labtestpackages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lab_id')->nullable();
            $table->foreign('lab_id')->references('id')->on('laboratorists')->onDelete('cascade');
            $table->string('package_name');
            $table->string('test_ids');
            $table->integer('price');
            $table->integer('discount');
            $table->string('image', 500);
            $table->string('home_sample_collection');
            $table->string('report_home_delivery');
            $table->string('ambulance_available');
            $table->integer('ambulance_fee');
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
        Schema::dropIfExists('labtestpackages');
    }
}
