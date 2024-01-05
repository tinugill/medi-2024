<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealerProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_products', function (Blueprint $table) {
            $table->id();
            $table->string('dealer_id');
            $table->string('item_name', 500);
            $table->string('company');
            $table->string('image', 500);
            $table->string('image_2', 500);
            $table->string('image_3', 500);
            $table->string('image_4', 500);
            $table->string('description', 5000);
            $table->integer('mrp');
            $table->integer('discount');
            $table->integer('delivery_charges');
            $table->enum('is_rent', [0, 1])->comment('0 not 1 yes')->default(0);
            $table->integer('rent_per_day');
            $table->integer('security_for_rent');
            $table->integer('delivery_charges_for_rent');
            $table->string('manufacturer_address');
            $table->string('pack_size');
            $table->integer('category_id'); 
            $table->enum('is_prescription_required', [0, 1])->comment('0 inactive 1 active')->default(1);
            $table->enum('status', [0, 1])->comment('0 inactive 1 active')->default(1);
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
        Schema::dropIfExists('dealer_products');
    }
}
