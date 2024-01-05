<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpanelmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empanelments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('is_approved', [0, 1])->comment('0 not 1 yes')->default(0);
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
        Schema::dropIfExists('empanelments');
    }
}
