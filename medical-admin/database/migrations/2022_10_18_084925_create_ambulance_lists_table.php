<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAmbulanceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ambulance_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('amb_id');
            $table->string('regis_no');
            $table->string('regis_proof', 500);
            $table->string('img_1', 500);
            $table->string('img_2', 500);
            $table->string('img_3', 500);
            $table->string('img_4', 500);
            $table->string('img_5', 500);
            $table->string('img_6', 500);
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
        Schema::dropIfExists('ambulance_lists');
    }
}
