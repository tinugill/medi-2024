<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_carts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('order_id');
            $table->integer('item_id');
            $table->string('item_type');
            $table->string('price');
            $table->string('discount');
            $table->string('qty');
            $table->string('req_date');
            $table->string('record_image', 500);
            $table->string('payment_id');
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
        Schema::dropIfExists('buy_carts');
    }
}
