<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulanceDriverListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulance_driver_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('amb_id');
            $table->string('driver_name');
            $table->string('image', 500);
            $table->string('liscence_no');
            $table->string('liscence_photo', 500);
            $table->string('address', 500);
            $table->string('mobile');
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
        Schema::dropIfExists('ambulance_driver_lists');
    }
}
