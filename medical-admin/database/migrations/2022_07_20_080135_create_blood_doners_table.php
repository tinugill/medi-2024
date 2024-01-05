<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodDonersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blood_doners', function (Blueprint $table) {
            $table->id();
            $table->string('bloodbank_id');
            $table->string('user_id');
            $table->string('blood_group');
            $table->string('name');
            $table->string('email');
            $table->string('mobile');
            $table->string('date');
            $table->string('available_in_emergency');
            $table->enum('is_donated', [0, 1])->comment('0 not donated 1 donated')->default(0);
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
        Schema::dropIfExists('blood_doners');
    }
}
