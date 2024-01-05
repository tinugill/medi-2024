<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('pharmacy_id')->nullable();
            $table->foreign('pharmacy_id')->references('id')->on('pharmacies')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->unsignedBigInteger('sub_category_id')->nullable();
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('formulations_id')->references('id')->on('formulations')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->string('title',500);
            $table->longText('description');
            $table->string('avaliblity');
            $table->string('formulation_id');
            $table->string('brand_name',300);
            $table->string('salt_name',1000);
            $table->string('expiry_month');
            $table->string('expiry_year');
            $table->string('expiry_type');
            $table->string('manufacturer_name');
            $table->string('prescription_required');
            $table->string('image', 500);
            $table->string('image_2', 500);
            $table->string('image_3', 500);
            $table->string('image_4', 500);
            $table->string('variant_name');
            $table->integer('mrp');
            $table->integer('discount');
            $table->string('strength');
            $table->string('manufacturer_address');
            $table->string('benefits');
            $table->string('ingredients');
            $table->string('uses');
            $table->string('productType');
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
        Schema::dropIfExists('products');
    }
}
