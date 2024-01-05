<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyCartOrderInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_cart_order_infos', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('order_id');
            $table->string('buy_cart_items');
            $table->string('total_amount');
            $table->string('total_discount');
            $table->string('address');
            $table->string('pincode');
            $table->string('city');
            $table->string('locality');
            $table->string('prescription', 500);
            $table->string('payment_id');
            $table->integer('delivery_boy');
            $table->enum('is_completed', [0, 1, 2, 3, 4])->comment('0 not 1 accepted 2 delivered 3 canceled 4 out of delivery')->default(0);
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
        Schema::dropIfExists('buy_cart_order_infos');
    }
}
