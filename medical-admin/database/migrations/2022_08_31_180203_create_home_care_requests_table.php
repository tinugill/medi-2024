<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeCareRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_care_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('qty');
            $table->string('type');
            $table->integer('care_id');
            $table->integer('procedure_id');
            $table->date('date');
            $table->string('book_for');
            $table->string('price');
            $table->string('address');
            $table->string('city');
            $table->string('pincode');
            $table->string('payment_id');
            $table->string('id_proof',500);
            $table->enum('status', [0, 1, 2, 3, 4, 5, 6])->comment('0 pending 1 accepted 2 out for delivery 3 delivered 4 picked 5 returned to seller 6 canceled')->default(0);
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
        Schema::dropIfExists('home_care_requests');
    }
}
