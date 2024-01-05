<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('service_payments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('price'); 
            $table->integer('discount'); 
            $table->integer('price_4'); 
            $table->integer('discount_4'); 
            $table->integer('price_6'); 
            $table->integer('discount_6'); 
            $table->integer('price_12'); 
            $table->integer('discount_12'); 
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
        Schema::dropIfExists('service_payments');
    }
}
