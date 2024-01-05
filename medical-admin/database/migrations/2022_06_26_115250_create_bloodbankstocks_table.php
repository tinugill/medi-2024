<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBloodbankstocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bloodbankstocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bloodbank_id')->nullable();
            $table->foreign('bloodbank_id')->references('id')->on('bloodbanks')->onDelete('CASCADE')->onUpdate('CASCADE')->nullable();
            $table->string('component_name');
            $table->string('avialablity');
            $table->string('available_unit');
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
        Schema::dropIfExists('bloodbankstocks');
    }
}
