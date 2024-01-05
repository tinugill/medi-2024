<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodbanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloodbanks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('owner_name', 100);
            $table->string('public_number', 20);
            $table->unsignedBigInteger('hospital_id')->nullable();
            $table->foreign('hospital_id')->references('id')->on('hospitals')->onDelete('CASCADE')->onUpdate('CASCADE')->nullable();
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('about', 6000);
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
            $table->string('liscence_no', 500);
            $table->string('liscence_file', 500);
            $table->string('days', 100);
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
        Schema::dropIfExists('bloodbanks');
    }
}
