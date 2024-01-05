<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabBookingInfoListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lab_booking_info_lists', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id'); 
            $table->integer('test_id'); 
            $table->string('type'); 
            $table->enum('status', [0, 1, 2, 3, 4, 5, 6])->comment('0 pending 1 accepted 2 out for service 3 reached 4 completed 5 canceled')->default(0);
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
        Schema::dropIfExists('lab_booking_info_lists');
    }
}
